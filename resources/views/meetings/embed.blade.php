@extends('layouts.tailwind')

@section('content')
<div class="container">
    <h2>{{ $meeting->meeting_title }}</h2>
    <div id="jitsi-container" style="height: 700px; width: 100%;"></div>
</div>

<script src="https://meet.jit.si/external_api.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const domain = "{{ config('jitsi.domain', 'meet.jit.si') }}"; // Replace with your domain if self-hosted
        const options = {
            roomName: "{{ $meeting->room_name }}",
            parentNode: document.querySelector('#jitsi-container'),
            userInfo: {
                displayName: "{{ auth()->user()->name }}"
            },
            configOverwrite: {
                disableDeepLinking: true,
                prejoinPageEnabled: false,
                disableLobby: true, // Ensure no waiting for moderator
                startWithAudioMuted: true,
                startWithVideoMuted: true,
                enableWelcomePage: false
            }
        };
        try {
            const api = new JitsiMeetExternalAPI(domain, options);
        } catch (error) {
            console.error('Failed to load Jitsi Meet:', error);
        }
    });
</script>




@endsection
