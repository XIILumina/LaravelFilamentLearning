<!-- Sticky Footer - Hidden until scroll to bottom -->
<footer x-data="{ 
    show: false,
    checkScroll() {
        const scrolled = window.scrollY + window.innerHeight;
        const pageHeight = document.documentElement.scrollHeight;
        this.show = scrolled >= pageHeight - 100;
    }
}" 
@scroll.window="checkScroll()"
x-init="checkScroll()"
x-show="show"
x-transition:enter="transition ease-out duration-300"
x-transition:enter-start="opacity-0 translate-y-full"
x-transition:enter-end="opacity-100 translate-y-0"
x-transition:leave="transition ease-in duration-200"
x-transition:leave-start="opacity-100 translate-y-0"
x-transition:leave-end="opacity-0 translate-y-full"
class="fixed bottom-0 left-0 right-0 bg-zinc-900 border-t border-zinc-800 z-40"
style="display: none;">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- About Section -->
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-2 mb-4">
                    <x-app-logo class="h-8 w-8" />
                    <span class="text-xl font-bold text-white">GameHub</span>
                </div>
                <p class="text-sm text-zinc-400 mb-4">
                    Your ultimate gaming community platform. Connect with gamers, share your experiences, and discover trending content.
                </p>
                <div class="flex gap-3">
                    <a href="#" class="text-zinc-400 hover:text-white transition-colors">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-zinc-400 hover:text-white transition-colors">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-zinc-400 hover:text-white transition-colors">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-zinc-400 hover:text-white transition-colors">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('trending.index') }}" class="text-sm text-zinc-400 hover:text-white transition-colors">Trending</a></li>
                    <li><a href="{{ route('communities.index') }}" class="text-sm text-zinc-400 hover:text-white transition-colors">Communities</a></li>
                    <li><a href="{{ route('blog.index') }}" class="text-sm text-zinc-400 hover:text-white transition-colors">Blog</a></li>
                    <li><a href="{{ route('genres.index') }}" class="text-sm text-zinc-400 hover:text-white transition-colors">Genres</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div>
                <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Support</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('contact.index') }}" class="text-sm text-zinc-400 hover:text-white transition-colors">Contact Us</a></li>
                    <li><a href="{{ route('inbox.index') }}" class="text-sm text-zinc-400 hover:text-white transition-colors">Help Center</a></li>
                    <li><a href="#" class="text-sm text-zinc-400 hover:text-white transition-colors">Terms of Service</a></li>
                    <li><a href="#" class="text-sm text-zinc-400 hover:text-white transition-colors">Privacy Policy</a></li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="mt-8 pt-6 border-t border-zinc-800">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-zinc-500">
                    © {{ date('Y') }} GameHub. All rights reserved.
                </p>
                <div class="flex items-center gap-4">
                    <button @click="window.scrollTo({top: 0, behavior: 'smooth'})" 
                            class="text-sm text-orange-500 hover:text-orange-400 font-medium flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        Back to top
                    </button>
                </div>
            </div>
        </div>
    </div>
</footer>
