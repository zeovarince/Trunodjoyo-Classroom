<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;

$users = User::where('role', 'mahasiswa')->get();

foreach ($users as $user) {
    Notification::create([
        'user_id' => $user->id,
        'message' => 'Diskusi baru ditambahkan'
    ]);
}

class ThreadController extends Controller
{
    public function store(Request $request)
{
    \App\Models\Thread::create([
        'lpp_id' => $request->lpp_id,
        'user_id' => auth()->id(),
        'content' => $request->content
    ]);

    return back();
}
}
