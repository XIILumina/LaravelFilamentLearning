<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of all users.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search users
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->get('role'));
        }

        $users = $query->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show user details and allow role changes.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Update user role.
     */
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,admin'
        ]);

        $user->update(['role' => $request->get('role')]);

        return redirect()->route('admin.users.show', $user)
            ->with('success', "User role updated to {$user->role}");
    }

    /**
     * Deactivate or ban a user.
     */
    public function deactivate(User $user)
    {
        // This would typically soft delete or mark as inactive
        // For now, we'll just show a confirmation message
        
        return redirect()->back()
            ->with('info', 'User deactivation feature coming soon');
    }
}
