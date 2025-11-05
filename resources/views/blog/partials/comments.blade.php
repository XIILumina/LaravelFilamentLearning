@foreach($comments as $comment)
    <div class="comment" id="comment-{{ $comment->id }}">
        <div class="flex items-start space-x-3">
            <!-- User Avatar -->
            <div class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                {{ $comment->user->initials() }}
            </div>
            
            <div class="flex-1">
                <!-- Comment Header -->
                <div class="flex items-center space-x-2 mb-2">
                    <span class="text-zinc-300 font-medium">{{ $comment->user->name }}</span>
                    <span class="text-zinc-500 text-sm">{{ $comment->created_at->diffForHumans() }}</span>
                    @if($comment->parent)
                        <span class="text-zinc-500 text-sm">
                            replying to <span class="text-indigo-400">{{ $comment->parent->user->name }}</span>
                        </span>
                    @endif
                </div>
                
                <!-- Comment Content -->
                <div class="text-zinc-300 mb-3">
                    {!! nl2br(e($comment->content)) !!}
                </div>
                
                <!-- Comment Actions -->
                <div class="flex items-center space-x-4">
                    @auth
                        <!-- Like/Dislike -->
                        <div class="flex items-center space-x-2">
                            <button onclick="toggleCommentLike({{ $comment->id }}, true)" 
                                    class="flex items-center space-x-1 text-sm transition-colors {{ $comment->isLikedBy(auth()->user()) ? 'text-green-400' : 'text-zinc-400 hover:text-green-400' }}">
                                <span>👍</span>
                                <span id="comment-likes-{{ $comment->id }}">{{ $comment->likes_count }}</span>
                            </button>
                            <button onclick="toggleCommentLike({{ $comment->id }}, false)" 
                                    class="flex items-center space-x-1 text-sm transition-colors {{ $comment->isDislikedBy(auth()->user()) ? 'text-red-400' : 'text-zinc-400 hover:text-red-400' }}">
                                <span>👎</span>
                                <span id="comment-dislikes-{{ $comment->id }}">{{ $comment->dislikes_count }}</span>
                            </button>
                        </div>
                        
                        <!-- Reply Button -->
                        <button onclick="toggleReplyForm({{ $comment->id }})" 
                                class="text-zinc-400 hover:text-indigo-400 text-sm transition-colors">
                            Reply
                        </button>
                        
                        <!-- Edit/Delete (for comment owner) -->
                        @if($comment->user_id === auth()->id())
                            <form method="POST" action="{{ route('comments.destroy', $comment) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Delete this comment?')"
                                        class="text-zinc-400 hover:text-red-400 text-sm transition-colors">
                                    Delete
                                </button>
                            </form>
                        @endif
                    @else
                        <div class="flex items-center space-x-2 text-zinc-400 text-sm">
                            <span class="flex items-center space-x-1">
                                <span>👍</span>
                                <span>{{ $comment->likes_count }}</span>
                            </span>
                            <span class="flex items-center space-x-1">
                                <span>👎</span>
                                <span>{{ $comment->dislikes_count }}</span>
                            </span>
                        </div>
                    @endauth
                </div>
                
                @auth
                    <!-- Reply Form -->
                    <div id="reply-form-{{ $comment->id }}" style="display: none;" class="mt-4">
                        <form method="POST" action="{{ route('comments.store', $comment->post) }}" class="space-y-3">
                            @csrf
                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-xs">
                                    {{ auth()->user()->initials() }}
                                </div>
                                <div class="flex-1">
                                    <textarea name="content" 
                                              rows="2" 
                                              placeholder="Write a reply..." 
                                              class="w-full bg-zinc-700 border border-zinc-600 rounded-lg px-3 py-2 text-white placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 resize-none text-sm"
                                              required></textarea>
                                </div>
                            </div>
                            <div class="flex justify-end space-x-2">
                                <button type="button" 
                                        onclick="toggleReplyForm({{ $comment->id }})"
                                        class="bg-zinc-600 hover:bg-zinc-700 px-4 py-1 rounded text-white text-sm transition-colors">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="bg-indigo-600 hover:bg-indigo-700 px-4 py-1 rounded text-white text-sm transition-colors">
                                    Reply
                                </button>
                            </div>
                        </form>
                    </div>
                @endauth
                
                <!-- Replies -->
                @if($comment->replies->isNotEmpty())
                    <div class="mt-4 ml-4 space-y-4 border-l-2 border-zinc-700 pl-4">
                        @include('blog.partials.comments', ['comments' => $comment->replies])
                    </div>
                @endif
            </div>
        </div>
    </div>
@endforeach