<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TherapistProfile;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        if ($request->filled('role')) $query->where('role', $request->role);
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('name','like',"%$s%")->orWhere('email','like',"%$s%"));
        }
        $users = $query->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('therapistProfile', 'moodLogs', 'patientSessions', 'therapistSessions');
        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        if ($user->isAdmin()) return back()->with('error', 'Cannot delete admin accounts.');
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }

    public function toggleRole(Request $request, User $user)
    {
        $request->validate(['role' => 'required|in:patient,therapist,admin']);
        $user->update(['role' => $request->role]);
        return back()->with('success', "User role updated to {$request->role}.");
    }

    public function verifyTherapist(User $user)
    {
        abort_unless($user->isTherapist(), 400);
        $user->therapistProfile->update(['is_verified' => true]);
        return back()->with('success', 'Therapist verified successfully.');
    }
}
