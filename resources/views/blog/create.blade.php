<x-layouts.app title="Create Post">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4 mb-4">
                <a href="{{ route('blog.index') }}" 
                   class="text-zinc-400 hover:text-indigo-400 transition-colors">
                    ← Back to Blog
                </a>
            </div>
            <h1 class="text-4xl font-bold text-white">Create New Post</h1>
            <p class="text-zinc-400">Share your gaming thoughts with the community</p>
        </div>

        <!-- Create Post Form -->
        <div class="bg-zinc-800 rounded-xl p-8">
            <form method="POST" action="{{ route('blog.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-zinc-300 mb-2">
                        Post Title
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title"
                           value="{{ old('title') }}" 
                           placeholder="Enter your post title..." 
                           class="w-full bg-zinc-700 border border-zinc-600 rounded-lg px-4 py-3 text-white placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500"
                           required>
                    @error('title')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Game Tag -->
                <div>
                    <label for="game_id" class="block text-sm font-medium text-zinc-300 mb-2">
                        Game Tag (Optional)
                    </label>
                    <select name="game_id" 
                            id="game_id"
                            class="w-full bg-zinc-700 border border-zinc-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select a game (optional)</option>
                        @foreach($games as $game)
                            <option value="{{ $game->id }}" {{ old('game_id') == $game->id ? 'selected' : '' }}>
                                {{ $game->title }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-zinc-400 text-sm mt-1">
                        Tag a game to help others find your post. Clicking the tag will link to the game page.
                    </p>
                    @error('game_id')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Photo Upload -->
                <div>
                    <label for="photo" class="block text-sm font-medium text-zinc-300 mb-2">
                        Photo (Optional)
                    </label>
                    <div class="border-2 border-dashed border-zinc-600 rounded-lg p-6 text-center hover:border-zinc-500 transition-colors">
                        <input type="file" 
                               name="photo" 
                               id="photo"
                               accept="image/*"
                               class="hidden"
                               onchange="previewImage(this)">
                        <label for="photo" class="cursor-pointer">
                            <div id="upload-placeholder">
                                <div class="text-zinc-400 text-4xl mb-2">📷</div>
                                <p class="text-zinc-400 mb-1">Click to upload an image</p>
                                <p class="text-zinc-500 text-sm">PNG, JPG, GIF up to 2MB</p>
                            </div>
                            <div id="image-preview" class="hidden">
                                <img id="preview-img" class="max-h-64 mx-auto rounded-lg">
                                <p class="text-zinc-400 text-sm mt-2">Click to change image</p>
                            </div>
                        </label>
                    </div>
                    @error('photo')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-zinc-300 mb-2">
                        Content
                    </label>
                    <textarea name="content" 
                              id="content"
                              rows="10" 
                              placeholder="Share your thoughts, strategies, reviews, or any gaming-related content..." 
                              class="w-full bg-zinc-700 border border-zinc-600 rounded-lg px-4 py-3 text-white placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 resize-none"
                              required>{{ old('content') }}</textarea>
                    <p class="text-zinc-400 text-sm mt-1">
                        Write your post content. You can share strategies, reviews, questions, or start discussions.
                    </p>
                    @error('content')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-zinc-700">
                    <button type="submit" 
                            class="bg-indigo-600 hover:bg-indigo-700 px-8 py-3 rounded-lg text-white font-medium transition-colors">
                        Publish Post
                    </button>
                    <a href="{{ route('blog.index') }}" 
                       class="bg-zinc-600 hover:bg-zinc-700 px-8 py-3 rounded-lg text-white font-medium transition-colors text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Tips -->
        <div class="mt-8 bg-zinc-800 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4">💡 Tips for Great Posts</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-zinc-300">
                <div>
                    <h4 class="font-medium text-indigo-400 mb-2">📝 Writing</h4>
                    <ul class="text-sm space-y-1 text-zinc-400">
                        <li>• Use descriptive titles</li>
                        <li>• Structure your content clearly</li>
                        <li>• Include relevant details</li>
                        <li>• Ask questions to engage readers</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-medium text-indigo-400 mb-2">🎮 Gaming Content</h4>
                    <ul class="text-sm space-y-1 text-zinc-400">
                        <li>• Tag relevant games</li>
                        <li>• Share screenshots or clips</li>
                        <li>• Discuss strategies and tips</li>
                        <li>• Be respectful to others</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('upload-placeholder').classList.add('hidden');
                    document.getElementById('image-preview').classList.remove('hidden');
                    document.getElementById('preview-img').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-layouts.app>