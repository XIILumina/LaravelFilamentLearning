<x-layouts.app title="Contact Us">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-white mb-4">Get in Touch</h1>
            <p class="text-zinc-400 text-lg max-w-2xl mx-auto">
                Have a question, suggestion, or just want to say hello? We'd love to hear from you! 
                Send us a message and we'll get back to you as soon as possible.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="bg-zinc-800 rounded-xl p-8">
                <h2 class="text-2xl font-bold text-white mb-6">Send us a Message</h2>
                
                <!-- Success Message -->
                @if(session('success'))
                    <div class="bg-green-600 text-white p-4 rounded-lg mb-6">
                        <div class="flex items-center">
                            <span class="text-xl mr-2">✅</span>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                <!-- Error Message -->
                @if(session('error'))
                    <div class="bg-red-600 text-white p-4 rounded-lg mb-6">
                        <div class="flex items-center">
                            <span class="text-xl mr-2">❌</span>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.send') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-zinc-300 mb-2">
                            Full Name
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name"
                               value="{{ old('name') }}" 
                               placeholder="Your full name" 
                               class="w-full bg-zinc-700 border border-zinc-600 rounded-lg px-4 py-3 text-white placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                               required>
                        @error('name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-zinc-300 mb-2">
                            Email Address
                        </label>
                        <input type="email" 
                               name="email" 
                               id="email"
                               value="{{ old('email') }}" 
                               placeholder="your@email.com" 
                               class="w-full bg-zinc-700 border border-zinc-600 rounded-lg px-4 py-3 text-white placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                               required>
                        @error('email')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subject -->
                    <div>
                        <label for="subject" class="block text-sm font-medium text-zinc-300 mb-2">
                            Subject
                        </label>
                        <select name="subject" 
                                id="subject"
                                class="w-full bg-zinc-700 border border-zinc-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                required>
                            <option value="">Select a subject</option>
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
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-sm font-medium text-zinc-300 mb-2">
                            Message
                        </label>
                        <textarea name="message" 
                                  id="message"
                                  rows="6" 
                                  placeholder="Please provide as much detail as possible..." 
                                  class="w-full bg-zinc-700 border border-zinc-600 rounded-lg px-4 py-3 text-white placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-none transition-colors"
                                  required>{{ old('message') }}</textarea>
                        <div class="flex justify-between items-center mt-1">
                            @error('message')
                                <p class="text-red-400 text-sm">{{ $message }}</p>
                            @else
                                <p class="text-zinc-400 text-sm">Maximum 2,000 characters</p>
                            @enderror
                            <span id="char-count" class="text-zinc-400 text-sm">0 / 2000</span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6 border-t border-zinc-700">
                        <button type="submit" 
                                class="w-full bg-indigo-600 hover:bg-indigo-700 px-8 py-3 rounded-lg text-white font-medium transition-colors duration-200 transform hover:scale-[1.02] focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-zinc-800">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Send Message
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="space-y-8">
                <!-- Contact Info Cards -->
                <div class="bg-zinc-800 rounded-xl p-6">
                    <h3 class="text-xl font-bold text-white mb-4">Contact Information</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-indigo-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-white">Email</h4>
                                <p class="text-zinc-400">support@gamesite.com</p>
                                <p class="text-zinc-500 text-sm">We typically respond within 24 hours</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-white">Response Time</h4>
                                <p class="text-zinc-400">1-24 hours</p>
                                <p class="text-zinc-500 text-sm">Usually much faster during business hours</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-white">Location</h4>
                                <p class="text-zinc-400">Online</p>
                                <p class="text-zinc-500 text-sm">Serving gamers worldwide</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Section -->
                <div class="bg-zinc-800 rounded-xl p-6">
                    <h3 class="text-xl font-bold text-white mb-4">Frequently Asked Questions</h3>
                    
                    <div class="space-y-4">
                        <div class="border-b border-zinc-700 pb-4">
                            <h4 class="font-medium text-indigo-400 mb-2">How do I add games to my wishlist?</h4>
                            <p class="text-zinc-400 text-sm">Simply click the heart icon ❤️ on any game card or game detail page while logged in.</p>
                        </div>
                        
                        <div class="border-b border-zinc-700 pb-4">
                            <h4 class="font-medium text-indigo-400 mb-2">Can I suggest new games?</h4>
                            <p class="text-zinc-400 text-sm">Absolutely! Use the "Game Suggestion" subject when contacting us.</p>
                        </div>
                        
                        <div class="border-b border-zinc-700 pb-4">
                            <h4 class="font-medium text-indigo-400 mb-2">How do I report a bug?</h4>
                            <p class="text-zinc-400 text-sm">Select "Bug Report" as your subject and provide as much detail as possible.</p>
                        </div>
                        
                        <div>
                            <h4 class="font-medium text-indigo-400 mb-2">Is my data secure?</h4>
                            <p class="text-zinc-400 text-sm">Yes! We take privacy seriously and never share your personal information.</p>
                        </div>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="bg-zinc-800 rounded-xl p-6">
                    <h3 class="text-xl font-bold text-white mb-4">Connect With Us</h3>
                    
                    <div class="flex space-x-4">
                        <a href="#" class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-700 transition-colors">
                            <span class="text-white font-bold">fb</span>
                        </a>
                        <a href="#" class="w-12 h-12 bg-blue-400 rounded-lg flex items-center justify-center hover:bg-blue-500 transition-colors">
                            <span class="text-white font-bold">tw</span>
                        </a>
                        <a href="#" class="w-12 h-12 bg-red-600 rounded-lg flex items-center justify-center hover:bg-red-700 transition-colors">
                            <span class="text-white font-bold">yt</span>
                        </a>
                        <a href="#" class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center hover:bg-purple-700 transition-colors">
                            <span class="text-white font-bold">dc</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Character Counter Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const messageTextarea = document.getElementById('message');
            const charCount = document.getElementById('char-count');
            
            function updateCharCount() {
                const length = messageTextarea.value.length;
                charCount.textContent = `${length} / 2000`;
                
                if (length > 1800) {
                    charCount.classList.add('text-yellow-400');
                    charCount.classList.remove('text-zinc-400');
                } else if (length > 1950) {
                    charCount.classList.add('text-red-400');
                    charCount.classList.remove('text-yellow-400', 'text-zinc-400');
                } else {
                    charCount.classList.add('text-zinc-400');
                    charCount.classList.remove('text-yellow-400', 'text-red-400');
                }
            }
            
            messageTextarea.addEventListener('input', updateCharCount);
            updateCharCount(); // Initial count
        });
    </script>
</x-layouts.app>