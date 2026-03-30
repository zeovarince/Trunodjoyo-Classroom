<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Thread;
use App\Models\Lpp;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{
    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'lpp_id' => 'required|exists:lpps,id',
            'content' => 'required|string',
        ]);

        $lpp = Lpp::with('classroom.students')->findOrFail($request->lpp_id);

        if ($user->role === 'dosen') {
            abort_unless($lpp->classroom->dosen_id === $user->id, 403);
        } else {
            abort_unless($user->joinedClassrooms()->where('classrooms.id', $lpp->classroom_id)->exists(), 403);
        }

        Thread::create([
            'lpp_id' => $request->lpp_id,
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);

        foreach ($lpp->classroom->students as $student) {
            if ($student->id === Auth::id()) {
                continue;
            }

            Notification::create([
                'user_id' => $student->id,
                'message' => 'Diskusi baru pada: ' . $lpp->title,
            ]);
        }

        return back()->with('success', 'Diskusi berhasil ditambahkan.');
    }
}
