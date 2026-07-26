@extends('CoreSystem.layouts.app')

@section('title', $notification->title)

@section('content')

<div class="px-4 sm:px-8 py-4 sm:py-8 max-w-4xl">

    <div class="bg-white rounded-xl shadow-lg p-4 sm:p-8">

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 break-words">
                {{ $notification->title }}
            </h1>

            <a href="{{ route('notifications.index') }}"
               class="w-full sm:w-auto text-center bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg text-sm font-medium transition">
                Back
            </a>
        </div>

        <div class="space-y-4 text-sm sm:text-base">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <strong class="text-slate-600">Category:</strong>
                    <span class="text-slate-800 ml-1">{{ $notification->category }}</span>
                </div>

                <div>
                    <strong class="text-slate-600">Department:</strong>
                    <span class="text-slate-800 ml-1">{{ $notification->department }}</span>
                </div>

                <div>
                    <strong class="text-slate-600">Priority:</strong>
                    <span class="text-slate-800 ml-1">{{ $notification->priority }}</span>
                </div>

                <div>
                    <strong class="text-slate-600">Published By:</strong>
                    <span class="text-slate-800 ml-1">{{ $notification->published_by }}</span>
                </div>

                <div>
                    <strong class="text-slate-600">Publish Date:</strong>
                    <span class="text-slate-800 ml-1">{{ $notification->publish_date }}</span>
                </div>
            </div>

            <div>
                <strong class="text-slate-600">Description:</strong>

                <div class="mt-2 p-4 bg-gray-50 rounded-lg break-words">
                    {{ $notification->description }}
                </div>
            </div>

            @if($notification->attachment)
                <div>
                    <strong class="text-slate-600">Attachment:</strong>

                    <a href="{{ asset('storage/'.$notification->attachment) }}"
                       target="_blank"
                       class="text-blue-600 underline ml-1">
                        View Attachment
                    </a>
                </div>
            @endif

        </div>

    </div>

</div>

@endsection
