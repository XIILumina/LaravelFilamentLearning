<x-layouts.app :title="'Platform Analytics'">
    <div class="w-full px-6 py-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">Platform Analytics</h1>
                <p class="text-slate-600 dark:text-slate-400">Key metrics and statistics</p>
            </div>

            <!-- Main Stats Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Users -->
                <div class="bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 p-6">
                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">Total Users</p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white">{{ $totalUsers }}</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">
                        +{{ $newUsersThisMonth }} this month
                    </p>
                </div>

                <!-- Admins -->
                <div class="bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 p-6">
                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">Administrator Accounts</p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white">{{ $admins }}</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">
                        {{ round(($admins/$totalUsers)*100, 1) }}% of users
                    </p>
                </div>

                <!-- Posts -->
                <div class="bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 p-6">
                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">Total Posts</p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white">{{ $totalPosts }}</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">
                        +{{ $postsThisMonth }} this month
                    </p>
                </div>

                <!-- Avg Posts per User -->
                <div class="bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 p-6">
                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">Avg Posts/User</p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white">{{ $avgPostsPerUser }}</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Community engagement</p>
                </div>
            </div>

            <!-- Content Stats -->
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <!-- Games -->
                <div class="bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Game Database</h3>
                    <p class="text-4xl font-bold text-indigo-600 mb-2">{{ $totalGames }}</p>
                    <p class="text-slate-600 dark:text-slate-400 text-sm">Games in the database</p>
                </div>

                <!-- Communities -->
                <div class="bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Active Communities</h3>
                    <p class="text-4xl font-bold text-purple-600 mb-2">{{ $activeCommunities }}</p>
                    <p class="text-slate-600 dark:text-slate-400 text-sm">Communities powered by users</p>
                </div>
            </div>

            <!-- Top Authors -->
            <div class="bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 p-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6">Top Contributors</h3>
                <div class="space-y-4">
                    @forelse($topAuthors as $author)
                        <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-700 rounded-lg">
                            <div>
                                <p class="font-medium text-slate-900 dark:text-white">{{ $author->user->name }}</p>
                                <p class="text-sm text-slate-600 dark:text-slate-400">{{ $author->user->username ? '@' . $author->user->username : 'User' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-indigo-600">{{ $author->post_count }}</p>
                                <p class="text-sm text-slate-600 dark:text-slate-400">Posts</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-600 dark:text-slate-400">No authors yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
