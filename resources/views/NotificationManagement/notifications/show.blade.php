<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $notification->title }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-4xl mx-auto mt-10">

    <div class="bg-white rounded-xl shadow-lg p-8">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">
                {{ $notification->title }}
            </h1>

            <a href="{{ route('notifications.index') }}"
               class="bg-gray-200 px-4 py-2 rounded-lg">
                Back
            </a>
        </div>

        <div class="space-y-4">

            <div>
                <strong>Category:</strong>
                {{ $notification->category }}
            </div>

            <div>
                <strong>Department:</strong>
                {{ $notification->department }}
            </div>

            <div>
                <strong>Priority:</strong>
                {{ $notification->priority }}
            </div>

            <div>
                <strong>Published By:</strong>
                {{ $notification->published_by }}
            </div>

            <div>
                <strong>Publish Date:</strong>
                {{ $notification->publish_date }}
            </div>

            <div>
                <strong>Description:</strong>

                <div class="mt-2 p-4 bg-gray-50 rounded-lg">
                    {{ $notification->description }}
                </div>
            </div>

            @if($notification->attachment)
                <div>
                    <strong>Attachment:</strong>

                    <a href="{{ asset('storage/'.$notification->attachment) }}"
                       target="_blank"
                       class="text-blue-600 underline">
                        View Attachment
                    </a>
                </div>
            @endif

        </div>

    </div>

</div>

</body>
</html>