<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Thread;
use App\Models\Lpp; 

class LppController extends Controller
{
    public function show($id)
{
    $lpp = \App\Models\Lpp::findOrFail($id);
    $assignments = Assignment::where('lpp_id', $id)->get();
$threads = Thread::where('lpp_id', $id)->latest()->get();

return view('lpp.detail', compact('lpp', 'assignments', 'threads'));

}
}