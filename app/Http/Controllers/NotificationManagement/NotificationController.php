<?php

namespace App\Http\Controllers\NotificationManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Notification;

class NotificationController extends Controller
{
    private function visibleQuery()
    {
        $user = auth()->user();

        $query = Notification::query();

        // Employee: only see notifications meant for them or general ones
        if ($user->isEmployee()) {
            $employee = $user->employee;
            $query->where(function ($q) use ($employee) {
                $q->whereNull('department')
                  ->orWhere('department', '');
                if ($employee) {
                    $q->orWhere('department', $employee->department);
                }
            });
        }

        return $query;
    }

    private function ensureCanManage()
    {
        $user = auth()->user();

        abort_unless(
            $user && ($user->isAdmin() || $user->isHr() || $user->hasPermission('manage_notifications')),
            403,
            'You do not have permission to manage notifications.'
        );
    }

    //  Display Notifications
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = $this->visibleQuery();

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Category Filter
        if ($request->filled('category') && $request->category != 'All') {
            $query->where('category', $request->category);
        }

        $notifications = $query
            ->orderByDesc('is_pinned')
            ->latest('publish_date')
            ->paginate(10);

        $important = Notification::where('is_pinned', true)
            ->latest('publish_date')
            ->first();

        $recent = Notification::latest('publish_date')
            ->take(5)
            ->get();

        $unreadCount = $this->visibleQuery()
            ->whereDoesntHave('readByUsers', function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->where('is_read', true);
            })
            ->count();

        $unreadBase = function () use ($user) {
            return $this->visibleQuery()
                ->whereDoesntHave('readByUsers', function ($q) use ($user) {
                    $q->where('user_id', $user->id)
                      ->where('is_read', true);
                });
        };

        $tabUnreadCounts = collect(['All', 'Company', 'HR', 'Policies', 'Training', 'Events'])
            ->mapWithKeys(function ($cat) use ($unreadBase) {
                $q = clone $unreadBase();
                if ($cat !== 'All') {
                    $q->where('category', $cat);
                }
                return [$cat => $q->count()];
            })
            ->all();

        $readIds = Notification::whereHas('readByUsers', function ($q) use ($user) {
            $q->where('user_id', $user->id)
              ->where('is_read', true);
        })->pluck('id')->all();

        return view(
            'NotificationManagement.notifications.index',
            compact(
                'notifications',
                'important',
                'recent',
                'unreadCount',
                'tabUnreadCounts',
                'readIds'
            )
        );
    }

    //  JSON endpoint of per-category unread counts (used for real-time badge polling)
    public function unreadCounts()
    {
        $user = auth()->user();

        $unreadBase = function () use ($user) {
            return $this->visibleQuery()
                ->whereDoesntHave('readByUsers', function ($q) use ($user) {
                    $q->where('user_id', $user->id)
                      ->where('is_read', true);
                });
        };

        $counts = collect(['All', 'Company', 'HR', 'Policies', 'Training', 'Events'])
            ->mapWithKeys(function ($cat) use ($unreadBase) {
                $q = clone $unreadBase();
                if ($cat !== 'All') {
                    $q->where('category', $cat);
                }
                return [$cat => $q->count()];
            })
            ->all();

        return response()->json($counts);
    }

    //  Create Form
    public function create()
    {
        $this->ensureCanManage();

        return view('NotificationManagement.notifications.create');
    }

    //  Store Notification
    public function store(Request $request)
    {
        $this->ensureCanManage();

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category' => 'required',
            'department' => 'nullable',
            'priority' => 'required',
            'published_by' => 'required',
            'publish_date' => 'required|date',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $notification = new Notification();

        $notification->title = $request->title;
        $notification->description = $request->description;
        $notification->category = $request->category;
        $notification->department = $request->department;
        $notification->priority = $request->priority;
        $notification->published_by = $request->published_by;
        $notification->publish_date = $request->publish_date;
        $notification->is_pinned = $request->has('is_pinned');
        $notification->status = true;

        if ($request->hasFile('attachment')) {
            $notification->attachment = $request
                ->file('attachment')
                ->store('notifications', 'public');
        }

        $notification->save();

        return redirect()
            ->route('notifications.index')
            ->with('success', 'Notification Created Successfully.');
    }

    //  Edit Notification
    public function edit($id)
    {
        $this->ensureCanManage();

        $notification = Notification::findOrFail($id);

        return view('NotificationManagement.notifications.edit', compact('notification'));
    }

    //  Show Notification
    public function show($id)
    {
        $notification = Notification::findOrFail($id);

        // Mark as read once the user opens and views it
        $notification->markAsRead(auth()->user());

        return view(
            'NotificationManagement.notifications.show',
            compact('notification')
        );
    }

    //  Update Notification
    public function update(Request $request, $id)
    {
        $this->ensureCanManage();

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category' => 'required',
            'department' => 'nullable',
            'priority' => 'required',
            'published_by' => 'required',
            'publish_date' => 'required|date',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $notification = Notification::findOrFail($id);

        $notification->title = $request->title;
        $notification->description = $request->description;
        $notification->category = $request->category;
        $notification->department = $request->department;
        $notification->priority = $request->priority;
        $notification->published_by = $request->published_by;
        $notification->publish_date = $request->publish_date;
        $notification->is_pinned = $request->has('is_pinned');

        if ($request->hasFile('attachment')) {
            if ($notification->attachment) {
                Storage::disk('public')->delete($notification->attachment);
            }

            $notification->attachment = $request
                ->file('attachment')
                ->store('notifications', 'public');
        }

        $notification->save();

        return redirect()
            ->route('notifications.index')
            ->with('success', 'Notification Updated Successfully.');
    }

    //  Delete Notification
    public function destroy($id)
    {
        $this->ensureCanManage();

        $notification = Notification::findOrFail($id);

        if ($notification->attachment) {
            Storage::disk('public')->delete($notification->attachment);
        }

        $notification->delete();

        return redirect()
            ->route('notifications.index')
            ->with('success', 'Notification Deleted Successfully.');
    }

    //  Pin Notification
    public function pin($id)
    {
        $this->ensureCanManage();

        $notification = Notification::findOrFail($id);

        $notification->is_pinned = true;

        $notification->save();

        return back()->with('success', 'Notification Pinned Successfully.');
    }

    //  Unpin Notification
    public function unpin($id)
    {
        $this->ensureCanManage();

        $notification = Notification::findOrFail($id);

        $notification->is_pinned = false;

        $notification->save();

        return back()->with('success', 'Notification Unpinned Successfully.');
    }

    //  Mark a single notification as read for the current user
    public function markAsRead(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);
        $user = auth()->user();

        \DB::table('notification_user')
            ->updateOrInsert(
                ['notification_id' => $id, 'user_id' => $user->id],
                ['is_read' => true, 'read_at' => now(), 'updated_at' => now()]
            );

        return response()->json(['success' => true, 'unreadCount' => $this->visibleQuery()->whereDoesntHave('readByUsers', function ($q) use ($user) {
            $q->where('user_id', $user->id)->where('is_read', true);
        })->count()]);
    }

    //  Mark all visible notifications as read for the current user
    public function markAllAsRead()
    {
        $user = auth()->user();

        $ids = $this->visibleQuery()->pluck('id');

        foreach ($ids as $id) {
            \DB::table('notification_user')
                ->updateOrInsert(
                    ['notification_id' => $id, 'user_id' => $user->id],
                    ['is_read' => true, 'read_at' => now(), 'updated_at' => now()]
                );
        }

        return redirect()
            ->route('notifications.index')
            ->with('success', 'All notifications marked as read.');
    }
}
