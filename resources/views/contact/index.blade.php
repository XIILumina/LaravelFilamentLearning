<x-layouts.app title="Contact Us">
    <div class="min-h-screen bg-zinc-950">
        <!-- Header -->
        <div class="px-4 sm:px-6 py-8 border-b border-zinc-800">
            <div class="max-w-4xl mx-auto text-center">
                <div class="w-14 h-14 bg-orange-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">Get in Touch</h1>
                <p class="text-zinc-500 text-sm sm:text-base max-w-lg mx-auto">
                    Have a question or feedback? We'd love to hear from you.
                </p>
            </div>
        </div>

        <!-- Content -->
        <div class="px-4 sm:px-6 py-8 pb-24 sm:pb-12">
            <div class="max-w-4xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                    <!-- Contact Form -->
                    <div class="lg:col-span-3">
                        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-5 sm:p-6">
                            <!-- Success Message -->
                            @if(session('success'))
                                <div class="bg-green-500/10 border border-green-500/20 text-green-400 p-4 rounded-xl mb-6 flex items-center gap-3">
                                    <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ session('success') }}
                                </div>
                            @endif

                            <!-- Error Message -->
                            @if(session('error'))
                                <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-xl mb-6 flex items-center gap-3">
                                    <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('contact.send') }}" class="space-y-5">
                                @csrf
                                
                                <!-- Name & Email Row -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-zinc-400 mb-2">Name</label>
                                        <input type="text" 
                                               name="name" 
                                               id="name"
                                               value="{{ old('name') }}" 
                                               placeholder="Your name" 
                                               class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm"
                                               required>
                                        @error('name')
                                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-zinc-400 mb-2">Email</label>
                                        <input type="email" 
                                               name="email" 
                                               id="email"
                                               value="{{ old('email') }}" 
                                               placeholder="you@example.com" 
                                               class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm"
                                               required>
                                        @error('email')
                                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Subject -->
                                <div>
                                    <label for="subject" class="block text-sm font-medium text-zinc-400 mb-2">Subject</label>
                                    <select name="subject" 
                                            id="subject"
                                            class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm"
                                            required>
                                        <option value="">Select a topic</option>
                                        <option value="General Inquiry" {{ old('subject') == 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                                        <option value="Bug Report" {{ old('subject') == 'Bug Report' ? 'selected' : '' }}>Bug Report</option>
                                        <option value="Feature Request" {{ old('subject') == 'Feature Request' ? 'selected' : '' }}>Feature Request</option>
                                        <option value="Game Suggestion" {{ old('subject') == 'Game Suggestion' ? 'selected' : '' }}>Game Suggestion</option>
                                        <option value="Account Issue" {{ old('subject') == 'Account Issue' ? 'selected' : '' }}>Account Issue</option>
                                        <option value="Feedback" {{ old('subject') == 'Feedback' ? 'selected' : '' }}>Feedback</option>
                                        <option value="Partnership" {{ old('subject') == 'Partnership' ? 'selected' : '' }}>Partnership</option>
                                        <option value="Other" {{ old('subject') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('subject')
                                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Message -->
                                <div>
                                    <label for="message" class="block text-sm font-medium text-zinc-400 mb-2">Message</label>
                                    <textarea name="message" 
                                              id="message"
                                              rows="5" 
                                              placeholder="How can we help?" 
                                              class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent resize-none text-sm"
                                              required>{{ old('message') }}</textarea>
                                    <div class="flex justify-between items-center mt-2">
                                        @error('message')
                                            <p class="text-red-400 text-xs">{{ $message }}</p>
                                        @enderror
                                        <span id="char-count" class="text-zinc-500 text-xs ml-auto">0 / 2000</span>
                                    </div>
                                </div>

                                <!-- Submit -->
                                <button type="submit" 
                                        class="w-full bg-orange-500 hover:bg-orange-600 px-6 py-3 rounded-xl text-white font-medium transition flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                    Send Message
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-2 space-y-4">
                        <!-- Quick Info -->
                        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-5">
                            <h3 class="font-semibold text-white mb-4">Quick Info</h3>
                            <div class="space-y-4">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 bg-orange-500/10 rounded-xl flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-white">Email</p>
                                        <p class="text-sm text-zinc-500">support@gamesite.com</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 bg-green-500/10 rounded-xl flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-white">Response Time</p>
                                        <p class="text-sm text-zinc-500">Within 24 hours</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ -->
                        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-5">
                            <h3 class="font-semibold text-white mb-4">FAQ</h3>
                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-sm font-medium text-orange-500 mb-1">How do I add games to wishlist?</h4>
                                    <p class="text-xs text-zinc-500">Click the heart icon on any game page while logged in.</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-orange-500 mb-1">Can I suggest new games?</h4>
                                    <p class="text-xs text-zinc-500">Yes! Use "Game Suggestion" as your subject.</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-orange-500 mb-1">How do I report a bug?</h4>
                                    <p class="text-xs text-zinc-500">Select "Bug Report" and provide details.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Social -->
                        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-5">
                            <h3 class="font-semibold text-white mb-4">Follow Us</h3>
                            <div class="flex gap-2">
                                <a href="#" class="w-10 h-10 bg-zinc-800 hover:bg-zinc-700 rounded-xl flex items-center justify-center transition">
                                    <svg class="w-5 h-5 text-zinc-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                    </svg>
                                </a>
                                <a href="#" class="w-10 h-10 bg-zinc-800 hover:bg-zinc-700 rounded-xl flex items-center justify-center transition">
                                    <svg class="w-5 h-5 text-zinc-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.317 4.3698a19.7913 19.7913 0 00-4.8851-1.5152.0741.0741 0 00-.0785.0371c-.211.3753-.4447.8648-.6083 1.2495-1.8447-.2762-3.68-.2762-5.4868 0-.1636-.3933-.4058-.8742-.6177-1.2495a.077.077 0 00-.0785-.037 19.7363 19.7363 0 00-4.8852 1.515.0699.0699 0 00-.0321.0277C.5334 9.0458-.319 13.5799.0992 18.0578a.0824.0824 0 00.0312.0561c2.0528 1.5076 4.0413 2.4228 5.9929 3.0294a.0777.0777 0 00.0842-.0276c.4616-.6304.8731-1.2952 1.226-1.9942a.076.076 0 00-.0416-.1057c-.6528-.2476-1.2743-.5495-1.8722-.8923a.077.077 0 01-.0076-.1277c.1258-.0943.2517-.1923.3718-.2914a.0743.0743 0 01.0776-.0105c3.9278 1.7933 8.18 1.7933 12.0614 0a.0739.0739 0 01.0785.0095c.1202.099.246.1981.3728.2924a.077.077 0 01-.0066.1276 12.2986 12.2986 0 01-1.873.8914.0766.0766 0 00-.0407.1067c.3604.698.7719 1.3628 1.225 1.9932a.076.076 0 00.0842.0286c1.961-.6067 3.9495-1.5219 6.0023-3.0294a.077.077 0 00.0313-.0552c.5004-5.177-.8382-9.6739-3.5485-13.6604a.061.061 0 00-.0312-.0286zM8.02 15.3312c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9555-2.4189 2.157-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.419 0 1.3332-.9555 2.4189-2.1569 2.4189zm7.9748 0c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9554-2.4189 2.1569-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.419 0 1.3332-.946 2.4189-2.1568 2.4189z"/>
                                    </svg>
                                </a>
                                <a href="#" class="w-10 h-10 bg-zinc-800 hover:bg-zinc-700 rounded-xl flex items-center justify-center transition">
                                    <svg class="w-5 h-5 text-zinc-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
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
                @auth
                    <a href="{{ route('dashboard') }}" class="flex flex-col items-center p-2 text-zinc-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span class="text-xs mt-1">Profile</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="flex flex-col items-center p-2 text-zinc-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        <span class="text-xs mt-1">Login</span>
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const messageTextarea = document.getElementById('message');
            const charCount = document.getElementById('char-count');
            
            function updateCharCount() {
                const length = messageTextarea.value.length;
                charCount.textContent = `${length} / 2000`;
                charCount.className = length > 1800 ? 'text-orange-500 text-xs ml-auto' : 'text-zinc-500 text-xs ml-auto';
            }
            
            messageTextarea.addEventListener('input', updateCharCount);
            updateCharCount();
        });
    </script>
</x-layouts.app>
