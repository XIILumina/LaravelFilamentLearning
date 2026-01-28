@props(['user', 'size' => 'md'])

@php
    $sizeClasses = [
        'xs' => 'w-6 h-6 text-xs',
        'sm' => 'w-8 h-8 text-sm',
        'md' => 'w-10 h-10 text-base',
        'lg' => 'w-16 h-16 text-2xl',
        'xl' => 'w-24 h-24 text-3xl',
        '2xl' => 'w-32 h-32 text-4xl',
    ];
    
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

@if($user->profilePictureUrl())
    <img src="{{ $user->profilePictureUrl() }}" 
         alt="{{ $user->name }}" 
         {{ $attributes->merge(['class' => "$sizeClass rounded-full object-cover ring-2 ring-orange-500/20"]) }}>
@else
    <div {{ $attributes->merge(['class' => "$sizeClass bg-gradient-to-br from-orange-500 to-red-600 rounded-full flex items-center justify-center text-white font-bold ring-2 ring-orange-500/20"]) }}>
        {{ $user->initials() }}
    </div>
@endif
