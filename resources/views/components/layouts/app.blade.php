<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
    
    <!-- Sticky Footer -->
    <x-sticky-footer />
</x-layouts.app.sidebar>
