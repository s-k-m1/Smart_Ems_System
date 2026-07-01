<?php

namespace App\Http\Controllers\NotificationManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    
    //  Display Notifications
    public function index(Request $request)
    {
        $query = Notification::query();

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

        return view(
            'NotificationManagement.notifications.index',
            compact(
                'notifications',
                'important',
                'recent'
            )
        );
    }

   
    //  Create Form
    
    public function create()
    {
        return view('NotificationManagement.notifications.create');
    }

   
    //  Store Notification
     
    public function store(Request $request)
    {
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

    //  Show Notification
     
    public function show($id)
    {
        $notification = Notification::findOrFail($id);

        return view(
            'NotificationManagement.notifications.show',
            compact('notification')
        );
    }

   
    //   Edit Notification
   
    public function edit($id)
    {
        $notification = Notification::findOrFail($id);

        return view(
            'NotificationManagement.notifications.edit',
            compact('notification')
        );
    }

    
    //  Update Notification
    
    public function update(Request $request, $id)
    {
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

  
    //   Delete Notification

    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);

        if ($notification->attachment) {

            Storage::disk('public')->delete($notification->attachment);

        }

        $notification->delete();

        return redirect()
            ->route('notifications.index')
            ->with('success', 'Notification Deleted Successfully.');
    }


    //   Pin Notification
    
    public function pin($id)
    {
        $notification = Notification::findOrFail($id);

        $notification->is_pinned = true;

        $notification->save();

        return back()->with('success', 'Notification Pinned Successfully.');
    }

    
    //   Unpin Notification
    
    public function unpin($id)
    {
        $notification = Notification::findOrFail($id);

        $notification->is_pinned = false;

        $notification->save();

        return back()->with('success', 'Notification Unpinned Successfully.');
    }
}