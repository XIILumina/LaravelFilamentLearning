@php
    $comments = $comments ?? $post->comments ?? collect();
@endphp

@foreach($comments as $comment)
    <div class="comment p-5 sm:p-6" id="comment-{{ $comment->id }}">
        <div class="flex gap-3">
            <!-- User Avatar -->
            <x-avatar :user="$comment->user" size="sm" class="shrink-0" />
            
            <div class="flex-1 min-w-0">
                <!-- Comment Header -->
                <div class="flex flex-wrap items-center gap-2 text-sm mb-2">
                    <span class="font-medium text-white">{{ $comment->user->name }}</span>
                    <span class="text-zinc-500">{{ $comment->created_at->diffForHumans() }}</span>
                    @if($comment->parent)
                        <span class="text-zinc-500">
                            → <span class="text-orange-500">{{ $comment->parent->user->name }}</span>
                        </span>
                    @endif
                </div>
                
                <!-- Comment Content -->
                <div class="text-zinc-300 text-sm mb-3 whitespace-pre-line">{{ $comment->content }}</div>
                
                <!-- Comment Actions -->
                <div class="flex items-center gap-4 text-xs">
                    @auth
                        <div class="flex items-center gap-1">
                            <button onclick="toggleCommentLike({{ $comment->id }}, true)" 
                                    class="p-1 transition {{ $comment->isLikedBy(auth()->user()) ? 'text-orange-500' : 'text-zinc-500 hover:text-orange-500' }}"
                                    data-comment-id="{{ $comment->id }}"
                                    data-action="like">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 3a1 1 0 01.707.293l7 7a1 1 0 01-1.414 1.414L10 5.414 3.707 11.707a1 1 0 01-1.414-1.414l7-7A1 1 0 0110 3z"/>
                                </svg>
                            </button>
                            <span class="like-count text-zinc-400 font-medium">{{ $comment->likes_count }}</span>
                            <button onclick="toggleCommentLike({{ $comment->id }}, false)" 
                                    class="p-1 transition {{ $comment->isDislikedBy(auth()->user()) ? 'text-blue-500' : 'text-zinc-500 hover:text-blue-500' }}"
                                    data-comment-id="{{ $comment->id }}"
                                    data-action="dislike">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 17a1 1 0 01-.707-.293l-7-7a1 1 0 011.414-1.414L10 14.586l6.293-6.293a1 1 0 011.414 1.414l-7 7A1 1 0 0110 17z"/>
                                </svg>
                            </button>
                            <span class="dislike-count text-zinc-400 font-medium">{{ $comment->dislikes_count }}</span>
                        </div>
                        
                        <button onclick="toggleReplyForm({{ $comment->id }})" 
                                class="text-zinc-500 hover:text-white transition">
                            Reply
                        </button>
                        
                        @if($comment->user_id === auth()->id())
                            <form method="POST" action="{{ route('comments.destroy', $comment) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Delete this comment?')"
                                        class="text-zinc-500 hover:text-red-500 transition">
                                    Delete
                                </button>
                            </form>
                        @endif
                    @else
                        <div class="flex items-center gap-2 text-zinc-500">
                            <span>👍 {{ $comment->likes_count }}</span>
                            <span>👎 {{ $comment->dislikes_count }}</span>
                        </div>
                    @endauth
                </div>
                
                @auth
                    <!-- Reply Form -->
                    <div id="reply-form-{{ $comment->id }}" style="display: none;" class="mt-4">
                        <form method="POST" action="{{ route('comments.store', $comment->post) }}" class="space-y-3">
                            @csrf
                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                            <div class="flex gap-2">
                                <x-avatar :user="auth()->user()" size="xs" class="shrink-0" />
                                <div class="flex-1">
                                    <textarea name="content" 
                                              rows="2" 
                                              placeholder="Write a reply..." 
                                              class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white placeholder-zinc-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent resize-none text-sm"
                                              required></textarea>
                                </div>
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="button" 
                                        onclick="toggleReplyForm({{ $comment->id }})"
                                        class="bg-zinc-800 hover:bg-zinc-700 px-3 py-1.5 rounded-lg text-white text-xs transition">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="bg-orange-500 hover:bg-orange-600 px-3 py-1.5 rounded-lg text-white text-xs transition">
                                    Reply
                                </button>
                            </div>
                        </form>
                    </div>
                @endauth
                
                <!-- Replies -->
                @if($comment->replies->isNotEmpty())
                    <div class="mt-4 ml-2 border-l-2 border-zinc-800 pl-4 space-y-0 divide-y divide-zinc-800">
                        @include('blog.partials.comments', ['comments' => $comment->replies])
                    </div>
                @endif
            </div>
        </div>
    </div>
@endforeach
