<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meeting;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;

class MeetingController extends Controller
{


//     public function generateJitsiToken($roomName)
// {
//     $signer = new Sha256();
//     $time = time();

//     $token = (new Builder())
//         ->issuedBy(config('vpaas-magic-cookie-67b99372adbc448baebdceb62adfc1cc/21a73a')) // App ID
//         ->withClaim('context', [
//             'user' => [
//                 'name' => auth()->user()->name, // Use the authenticated user's name
//                 'email' => auth()->user()->email,
//                 'avatar' => auth()->user()->avatar ?? '',
//                 'moderator' => true, // Grant moderator rights if necessary
//             ]
//         ])
//         ->withClaim('room', $roomName) // Specific room name
//         ->expiresAt($time + 3600) // Token expires in 1 hour
//         ->getToken($signer, new Key(config('MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDhaaQC68KZgs7N
// R4e9drqkcfRPzNOqzUnYRcgSAsqq6zvWyBzRrDxXbRvz6JMGfKMJDoslzNg6RTf8
// qnj1xKZeRj4qv/eUnrAfsjEE+GS7QYBEh7quOGNDY78XO0iHaXdSQrOtH23K5oFV
// yVjPvMSfOkDrAm98CR5MJ7Jfxtv4JvXFCtFL2n3a92qg52u/apnGfsmM1CTdWkbh
// fvlBm0MVg62xdScpOWKdA8xkoNHwfHSfvkjwD1PPUg/6Xb37t8SwA+FLlu4x+AfF
// TH88H+9AyCfa1nzsu8c3nqkd7NRzY4US6kY3UPxHIeRs+RG99dJrRuVSocDxuaTI
// NM/ZQ4UjAgMBAAECggEBANwgTgqMMX24QDw3nldnmtz8a5mCbTJfR73sZ3UvRLuk
// /MrCoWIg0MyPwLxwYyPyk0RE7536bS56ajJUR8u6Pr3R2uPkk+KPFW/elABGkhhL
// 3vcNlUCN0GH/Bp2pRyr105CBkvV9u7ppX+RmvFQiA+F7Aep+dmCqhuvX2Fmv2SB7
// FlB8eFj8v2aYX0fHq/ulWKHnS1BHodaxQ2s4LTm/PJpEIf6yWUJ+RuCrTy9zQe+M
// teKDsrCsANMRVVmir52jKrwua0b1jHbqg6DDfAxfxVfsSmaZbpQyHCYUo/X+4Cb7
// 9X7VUt0O5cnwS4ZCmozH5AQ8KluHDGNtupTNFlSCoAECgYEA8yfDIjHyg4+9RJWF
// 72FMbXserp2I8gkHuu6Vz6NZwI5mH4tVCpJvTD9ykfMBaELfqtGfjIX8TxekVYOb
// kPdGcB/yGWLBsVsb0jrv2sY3tBCc6aLthuz4/V48MQm+OrDbdMCmFIEjaPC2dDKa
// dtcNXMsiqEGPicRIAO/jnHcRZukCgYEA7VHw3VnzJOeMTRV3Cewg6GzpZXbl4MnA
// Ap5yyvRZnMs1YNNbJt+nvvIaQLye9ZIpcEWynoJFgilFHmNVmEeyEJjtyHbIGp0K
// T5t8RWvP1yAZL40DwZexsvfo1DJALRB/wgGVRoCJ+usRPZPpvONxOWrDy9HlxJNa
// /fJmBStP3CsCgYBc0WvajMhvUhpEqPMkira7AAmZTEdvZOUPhW2ogkmLiJARMIW4
// 8GcN6xZYAjQiUYzBzx0hbi//HR49Cm0C7HF18avf5uPbSNUY7iiLEalH0iOjx+71
// 11XAmg1OBtMX4lUTf0qmfxk+QMzVFFAEV1khd+V15vjc9RErUmdHXehFqQKBgDiz
// PSMFnKwSjljUag561hnx+4l8cMvWKAP4K2EGJGrruiMaHEsbYI6kdVVGO4xckX37
// iQOKCGViytrJzOeHKaoBf75HcuO45X/DnFtRuOSjDKFpxZ35SkGCLaSVJPQfXwbR
// LgMcLts+Um4t6shwZtrbAVCvI4Bl3HWT9oABqyDlAoGAaFwW8r2eV0jDHpUgDmbr
// R96sB6YYL4+IggZpTb0SL8BCg1mT5WbNcOhTxTL9bteDuRh/1xBkvdqWwsKTKVJd
// hC1TDFJUDzLISUZvasKUdDiPs9OiwZtHZmiat+4Qa7hH5pZtwx1RWsOBm0XxBwUf
// G6vhx8PDVZ573IYRVciDsLc='))); // App Secret

//     return (string) $token;
// }
    public function start($id)
    {
        $meeting = Meeting::findOrFail($id);
        return view('meetings.start', ['meeting' => $meeting]);
    }

    public function join($id)
    {
        $meeting = Meeting::findOrFail($id);
        return view('meetings.embed', ['meeting'=>$meeting]);
    }


    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'scheduled_at' => 'required|date',
        'scheduled_end' => 'required|date',
    ]);

    $roomName = 'Room-' . uniqid(); // Generate unique room name
    $jitsiDomain = config('jitsi.domain', 'meet.jit.si'); // Replace with your self-hosted Jitsi domain
    $embedLink = "https://$jitsiDomain/$roomName"; // Construct the embedded link

    $meeting = Meeting::create([
        'room_name' => $request->name,
        'start_time' => $request->scheduled_at,
        'end_time' => $request->scheduled_end,
        'meeting_link' => $embedLink,
        
    ]);

    return redirect()->route('meetings.start', $meeting->id)->with('status', 'Meeting created successfully!');
}

public function showAll()
{
    $meetings = Meeting::all();
    $totalmet = Meeting::count();
    $currentTime = now();
    $expiredMeetings = Meeting::where('end_time', '<', $currentTime)->get();
    $upcomingMeetings = Meeting::where('end_time', '>', $currentTime)->get();
    $expiredCount = $expiredMeetings->count();
    $Upcoming = $upcomingMeetings->count();
    return view('dashboard', ['meetings' => $meetings, 'totalmet'=>$totalmet, 'expired' =>$expiredCount,'upcoming'=>$Upcoming]);

}


}
