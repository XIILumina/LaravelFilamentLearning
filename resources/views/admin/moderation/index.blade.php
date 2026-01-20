<x-layouts.app :title="'Content Moderation'">
    <div class="w-full px-6 py-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">Content Moderation</h1>
                <p class="text-slate-600 dark:text-slate-400">Review and manage community content</p>
            </div>

            <!-- Tabs -->
            <div class="flex gap-4 mb-6 border-b border-slate-200 dark:border-slate-700">
                <button onclick="showTab('posts')" class="px-4 py-2 font-medium text-slate-900 dark:text-white border-b-2 border-indigo-600 cursor-pointer">
                    Recent Posts
                </button>
                <button onclick="showTab('comments')" class="px-4 py-2 font-medium text-slate-600 dark:text-slate-400 border-b-2 border-transparent hover:border-slate-300 dark:hover:border-slate-600 cursor-pointer">
                    Recent Comments
                </button>
            </div>

            <!-- Posts Section -->
            <div id="posts-section" class="space-y-4">
                @forelse($recentPosts as $post)
                    <div class="bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 p-6">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-bold text-slate-900 dark:text-white">{{ $post->title }}</h3>
                                <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">By {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex gap-2">
                                <form action="{{ route('admin.posts.flag', $post) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 text-sm rounded bg-yellow-100 text-yellow-800 hover:bg-yellow-200 transition-colors">
                                        Flag
                                    </button>
                                </form>
                                <form action="{{ route('admin.posts.delete', $post) }}" method="POST" class="inline" onsubmit="return confirm('Delete this post?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 text-sm rounded bg-red-100 text-red-800 hover:bg-red-200 transition-colors">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                        <p class="text-slate-600 dark:text-slate-400 text-sm line-clamp-3">{{ $post->content }}</p>
                    </div>
                @empty
                    <p class="text-slate-600 dark:text-slate-400">No posts to review</p>
                @endforelse
            </div>

            <!-- Comments Section (hidden by default) -->
            <div id="comments-section" class="space-y-4 hidden">
                @forelse($recentComments as $comment)
                    <div class="bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 p-6">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <p class="font-bold text-slate-900 dark:text-white">{{ $comment->user->name }}</p>
                                <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex gap-2">
                                <form action="{{ route('admin.posts.flag', $comment->post) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 text-sm rounded bg-yellow-100 text-yellow-800 hover:bg-yellow-200 transition-colors">
                                        Flag
                                    </button>
                                </form>
                                <form action="{{ route('admin.comments.delete', $comment) }}" method="POST" class="inline" onsubmit="return confirm('Delete this comment?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 text-sm rounded bg-red-100 text-red-800 hover:bg-red-200 transition-colors">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                        <p class="text-slate-600 dark:text-slate-400 text-sm">{{ $comment->content }}</p>
                    </div>
                @empty
                    <p class="text-slate-600 dark:text-slate-400">No comments to review</p>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        function showTab(tab) {
            document.getElementById('posts-section').classList.toggle('hidden', tab !== 'posts');
            document.getElementById('comments-section').classList.toggle('hidden', tab !== 'comments');
        }
    </script>
</x-layouts.app>
