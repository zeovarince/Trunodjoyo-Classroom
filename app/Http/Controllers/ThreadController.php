<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
