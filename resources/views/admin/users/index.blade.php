<x-layouts.app :title="'Manage Users'">
    <div class="w-full px-6 py-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">User Management</h1>
                <p class="text-slate-600 dark:text-slate-400">Manage user roles and permissions</p>
            </div>

            <!-- Search & Filter -->
            <div class="bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 p-6 mb-6">
                <form method="GET" action="{{ route('admin.users') }}" class="flex flex-col md:flex-row gap-4">
                    <input type="text" name="search" placeholder="Search by name or email..." value="{{ request('search') }}" 
                           class="flex-1 px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white">
                    <select name="role" class="px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white">
                        <option value="">All Roles</option>
                        <option value="user" @if(request('role') === 'user') selected @endif>User</option>
                        <option value="admin" @if(request('role') === 'admin') selected @endif>Admin</option>
                    </select>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        Search
                    </button>
                </form>
            </div>

            <!-- Users Table -->
            <div class="bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900 dark:text-white">Name</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900 dark:text-white">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900 dark:text-white">Role</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900 dark:text-white">Joined</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900 dark:text-white">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="border-t border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                <td class="px-6 py-4 text-sm text-slate-900 dark:text-white font-medium">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-3 py-1 rounded-full text-white text-xs font-medium @if($user->isAdmin()) bg-red-600 @else bg-blue-600 @endif">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-indigo-600 hover:text-indigo-700 font-medium">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-600 dark:text-slate-400">
                                    No users found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
                <div class="mt-6">
                    {{ $users->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
