<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user = User::findOrFail($user->id);
        $isDosen = $user->role === 'dosen';

        $exp = 0;
        $level = 1;
        $currentLevelMax = 100;
        $progressPercent = 0;
        $frameImage = null;

        if (!$isDosen) {
            $expCap = 500;
            $exp = max(0, min($expCap, (int) $user->exp));
            $level = min(5, intdiv($exp, 100) + 1);
            $currentLevelMin = ($level - 1) * 100;
            $currentLevelMax = $level === 5 ? 500 : ($level * 100);
            $progressPercent = $level === 5
                ? 100
                : (int) round((($exp - $currentLevelMin) / 100) * 100);
            $frameImage = 'images/lv' . $level . '.png';
        }

        if ($isDosen) {
            $activeClassesCount = $user->taughtClassrooms()->count();
            $taughtClassroomIds = $user->taughtClassrooms()->pluck('id');
            $completedTasksCount = Submission::whereHas('lpp', function ($query) use ($taughtClassroomIds) {
                $query->whereIn('classroom_id', $taughtClassroomIds);
            })->whereNotNull('grade')->count();
            $mentoredStudentsCount = $user->taughtClassrooms()->withCount('students')->get()->sum('students_count');
        } else {
            $activeClassesCount = $user->joinedClassrooms()->count();
            $completedTasksCount = Submission::where('user_id', $user->id)
                ->where(function ($query) {
                    $query->whereNotNull('assignment_id')
                        ->orWhereNotNull('lpp_id');
                })
                ->count();
            $mentoredStudentsCount = null;
        }

        $frameLabels = [
            1 => 'Bronze Frame',
            2 => 'Emerald Frame',
            3 => 'Sky Frame',
            4 => 'Violet Frame',
            5 => 'Legend Frame',
        ];

        return view('profile', compact(
            'user',
            'isDosen',
            'exp',
            'level',
            'currentLevelMax',
            'progressPercent',
            'frameImage',
            'activeClassesCount',
            'completedTasksCount',
            'mentoredStudentsCount',
            'frameLabels'
        ));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'prodi' => 'nullable|string|max:255',
            'fakultas' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user->name = $request->input('name');
        $user->prodi = $request->input('prodi');
        $user->fakultas = $request->input('fakultas');

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function avatar($id)
    {
        $targetUser = User::findOrFail($id);

        abort_if(!$targetUser->avatar || !Storage::disk('public')->exists($targetUser->avatar), 404);

        return response()->file(Storage::disk('public')->path($targetUser->avatar));
    }
}
