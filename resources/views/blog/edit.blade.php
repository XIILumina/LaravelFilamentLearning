<x-layouts.app title="Edit Post">
    <div class="min-h-screen bg-zinc-950">
        <!-- Header -->
        <div class="px-4 sm:px-6 py-4 border-b border-zinc-800 sticky top-0 bg-zinc-950/95 backdrop-blur-lg z-40">
            <div class="max-w-2xl mx-auto flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <a href="{{ route('blog.show', $post) }}" 
                       class="text-zinc-400 hover:text-white p-2 -ml-2 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <h1 class="text-lg font-semibold text-white">Edit Post</h1>
                </div>
                <button type="submit" form="edit-post-form"
                        class="bg-orange-500 hover:bg-orange-600 px-4 py-2 rounded-xl font-medium text-white text-sm transition">
                    Save
                </button>
            </div>
        </div>

        <!-- Form -->
        <div class="px-4 sm:px-6 py-6 pb-24 sm:pb-12">
            <div class="max-w-2xl mx-auto">
                <form id="edit-post-form" method="POST" action="{{ route('blog.update', $post) }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PUT')
                    
                    <!-- Title -->
                    <div>
                        <input type="text" 
                               name="title" 
                               id="title"
                               value="{{ old('title', $post->title) }}" 
                               placeholder="Title" 
                               class="w-full bg-transparent border-0 border-b border-zinc-800 focus:border-orange-500 px-0 py-3 text-xl text-white placeholder-zinc-600 focus:ring-0 transition"
                               required>
                        @error('title')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Game & Community Tags -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <select name="game_id" 
                                    id="game_id"
                                    class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-4 py-3 text-white text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                <option value="">🎮 Game (optional)</option>
                                @foreach($games as $game)
                                    <option value="{{ $game->id }}" {{ old('game_id', $post->game_id) == $game->id ? 'selected' : '' }}>
                                        {{ $game->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('game_id')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <select name="community_id" 
                                    id="community_id"
                                    class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-4 py-3 text-white text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                <option value="">👥 Community (optional)</option>
                                @foreach($communities as $community)
                                    <option value="{{ $community->id }}" {{ old('community_id', $post->community_id) == $community->id ? 'selected' : '' }}>
                                        {{ $community->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('community_id')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Current Photo -->
                    @if($post->photo)
                        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden">
                            <img src="{{ asset('storage/' . $post->photo) }}" 
                                 alt="Current post image" 
                                 class="w-full max-h-48 object-cover">
                            <div class="p-3 border-t border-zinc-800 flex items-center justify-between">
                                <span class="text-xs text-zinc-500">Current image</span>
                                <label for="photo" class="text-xs text-orange-500 hover:text-orange-400 cursor-pointer transition">
                                    Change
                                </label>
                            </div>
                        </div>
                    @endif

                    <!-- Photo Upload -->
                    <div>
                        <div class="bg-zinc-900 border border-zinc-800 border-dashed rounded-2xl overflow-hidden hover:border-zinc-700 transition {{ $post->photo ? 'hidden' : '' }}" id="upload-container">
                            <input type="file" 
                                   name="photo" 
                                   id="photo"
                                   accept="image/*"
                                   class="hidden"
                                   onchange="previewImage(this)">
                            <label for="photo" class="cursor-pointer block">
                                <div id="upload-placeholder" class="p-8 text-center">
                                    <div class="w-12 h-12 bg-zinc-800 rounded-xl flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <p class="text-zinc-400 text-sm">{{ $post->photo ? 'Change image' : 'Add an image' }}</p>
                                    <p class="text-zinc-600 text-xs mt-1">PNG, JPG up to 2MB</p>
                                </div>
                                <div id="image-preview" class="hidden">
                                    <img id="preview-img" class="w-full max-h-64 object-cover">
                                    <div class="p-3 text-center border-t border-zinc-800">
                                        <p class="text-zinc-400 text-sm">Tap to change image</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('photo')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div>
                        <textarea name="content" 
                                  id="content"
                                  rows="10" 
                                  placeholder="What's on your mind?" 
                                  class="w-full bg-zinc-900 border border-zinc-800 rounded-2xl px-4 py-4 text-white placeholder-zinc-600 focus:ring-2 focus:ring-orange-500 focus:border-transparent resize-none text-sm"
                                  required>{{ old('content', $post->content) }}</textarea>
                        @error('content')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mobile Submit Button -->
                    <div class="sm:hidden pt-4">
                        <button type="submit" 
                                class="w-full bg-orange-500 hover:bg-orange-600 px-6 py-3 rounded-xl text-white font-medium transition">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Mobile Bottom Navigation -->
        <div class="fixed bottom-0 left-0 right-0 bg-zinc-900/95 backdrop-blur-lg border-t border-zinc-800 sm:hidden z-50">
            <div class="flex items-center justify-around py-2">
                <a href="{{ route('home') }}" class="flex flex-col items-center p-2 text-zinc-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="text-xs mt-1">Home</span>
                </a>
                <a href="{{ route('games.index') }}" class="flex flex-col items-center p-2 text-zinc-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>
                    </svg>
                    <span class="text-xs mt-1">Games</span>
                </a>
                <a href="{{ route('communities.index') }}" class="flex flex-col items-center p-2 text-zinc-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-xs mt-1">Communities</span>
                </a>
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center p-2 text-zinc-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="text-xs mt-1">Profile</span>
                </a>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('upload-container').classList.remove('hidden');
                    document.getElementById('upload-placeholder').classList.add('hidden');
                    document.getElementById('image-preview').classList.remove('hidden');
                    document.getElementById('preview-img').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-layouts.app>
