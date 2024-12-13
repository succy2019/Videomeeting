<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $meeting->room_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="w-full px-6 py-6 mx-auto">
        <div class="container mx-auto bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold">{{ $meeting->room_name }}</h2>
            
            @if($meeting->description)
                <p class="mt-2 text-gray-700">{{ $meeting->description }}</p>
            @endif
            
            <p class="mt-2 text-gray-600">Scheduled At: {{ \Carbon\Carbon::parse($meeting->start_time)->format('l, F j, Y \a\t g:i A') }}</p>
            <p class="mt-2 text-gray-600">Scheduled to End: {{ \Carbon\Carbon::parse($meeting->end_time)->format('l, F j, Y \a\t g:i A') }}</p>

            <div class="mt-4">
                <a href="{{ route('meetings.join', $meeting->id) }}" class="inline-block px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Start Meeting</a>
                <a href="{{ route('dashboard') }}" class="inline-block ml-4 px-4 py-2 text-gray-700 bg-gray-300 rounded hover:bg-gray-400">Back to Meetings</a>
            </div>
        </div>
    </div>
</body>
</html>