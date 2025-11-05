<footer class="mt-12 bg-gray-900 py-6 text-center text-gray-400 text-sm">
    <p>&copy; {{ date('Y') }} Game Database. All rights reserved.</p>
    <div class="mt-2 space-x-4">
        <a href="{{ route('contact.index') }}" class="hover:text-indigo-400">Contact</a>
        <a href="{{ route('community.index') }}" class="hover:text-indigo-400">Community</a>
        <a href="{{ route('blog.index') }}" class="hover:text-indigo-400">Blog</a>
    </div>
</footer>