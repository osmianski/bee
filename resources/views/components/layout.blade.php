<?php
/* @var string $title */
?>
@props([
    'title' => '',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ ($title ? $title . ' - ' : '') . config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

        <x-favicon />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="h-full">
    <div x-data="{ open: false }" @keydown.window.escape="open = false">
        <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
        <div x-cloak x-show="open" class="relative z-40 md:hidden" role="dialog" aria-modal="true">
            <!-- Off-canvas menu backdrop, show/hide based on off-canvas menu state. -->
            <div x-show="open"
                x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>

            <div class="fixed inset-0 z-40 flex">
                <!-- Off-canvas menu, show/hide based on off-canvas menu state. -->
                <div x-show="open"
                    x-transition:enter="transition ease-in-out duration-300 transform"
                    x-transition:enter-start="-translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition ease-in-out duration-300 transform"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="-translate-x-full"
                    class="relative flex w-full max-w-xs flex-1 flex-col bg-indigo-700"
                    @click.away="open = false">
                    <!-- Close button, show/hide based on off-canvas menu state. -->
                    <div
                        x-show="open"
                        x-transition:enter="ease-in-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in-out duration-300"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="absolute top-0 right-0 -mr-12 pt-2">
                        <button type="button" class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                            @click="open = false">
                            <span class="sr-only">Close sidebar</span>
                            <!-- Heroicon name: outline/x-mark -->
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="h-0 flex-1 overflow-y-auto pt-5 pb-4">
                        <div class="flex flex-shrink-0 items-center px-4">
                            <a href="{{ route('home') }}">
                                <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=300" alt="Your Company">
                            </a>
                        </div>
                        <nav class="mt-5 px-2 divide-y divide-gray-400">
                            @foreach(config('nav') as $group)
                                <div class="my-2 @if(!$loop->first) pt-2 @endif">
                                    @if(isset($group['title']))
                                        <div class="text-white px-2 py-2 fond-bold text-xl">
                                            {{ $group['title'] }}
                                        </div>
                                    @endif
                                    @foreach($group['items'] as $item)
                                        @if (is_nav_item_active($item))
                                            <a href="{{ isset($item['route']) ? route($item['route']) : '#' }}" class="bg-indigo-800 text-white group flex items-center px-2 py-2 text-base font-medium rounded-md">
                                                @if(isset($item['icon']))
                                                    <x-dynamic-component :component="$item['icon']" class="mr-4 h-6 w-6 flex-shrink-0 text-indigo-300" />
                                                @else
                                                    <div class="mr-4 h-6 w-6 flex-shrink-0 "></div>
                                                @endif
                                                {{ $item['title'] }}
                                            </a>
                                        @else
                                            <a href="{{ isset($item['route']) ? route($item['route']) : '#' }}" class="text-white hover:bg-indigo-600 hover:bg-opacity-75 group flex items-center px-2 py-2 text-base font-medium rounded-md">
                                                @if(isset($item['icon']))
                                                    <x-dynamic-component :component="$item['icon']" class="mr-4 h-6 w-6 flex-shrink-0 text-indigo-300" />
                                                @else
                                                    <div class="mr-4 h-6 w-6 flex-shrink-0 "></div>
                                                @endif
                                                {{ $item['title'] }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @endforeach
                        </nav>
                    </div>
                    <div class="flex flex-shrink-0 border-t border-indigo-800 p-4">
                        <a href="{{ route('profile.edit') }}">
                            <x-hero-icons.solid.user class="inline-block h-9 w-9 rounded-full text-indigo-300" />
                        </a>
                        <div class="ml-3">
                            <a href="{{ route('profile.edit') }}" class="text-sm font-medium text-white">{{ Auth::user()->name }}</a>
                            <form method="POST" action="{{ route('logout') }}"  class="flex flex-row items-center">
                                @csrf

                                <a href="{{ route('profile.edit') }}" class="pr-2 text-xs font-medium text-indigo-200 hover:text-white">Profile</a>
                                <a class="cursor-pointer text-xs font-medium text-indigo-200 hover:text-white" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="w-14 flex-shrink-0" aria-hidden="true">
                    <!-- Force sidebar to shrink to fit close icon -->
                </div>
            </div>
        </div>

        <!-- Static sidebar for desktop -->
        <div class="hidden md:fixed md:inset-y-0 md:flex md:w-64 md:flex-col">
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="flex min-h-0 flex-1 flex-col bg-indigo-700">
                <div class="flex flex-1 flex-col overflow-y-auto pt-5 pb-4">
                    <div class="flex flex-shrink-0 items-center px-4">
                        <a href="{{ route('home') }}">
                            <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=300" alt="Your Company">
                        </a>
                    </div>
                    <nav class="mt-5 flex-1 px-2 divide-y divide-gray-400">
                        @foreach(config('nav') as $group)
                            <div class="my-2 @if(!$loop->first) pt-2 @endif">
                                @if(isset($group['title']))
                                    <div class="text-white px-2 py-2 fond-bold text-xl">
                                        {{ $group['title'] }}
                                    </div>
                                @endif
                                @foreach($group['items'] as $item)
                                    @if (is_nav_item_active($item))
                                        <a href="{{ isset($item['route']) ? route($item['route']) : '#' }}" class="bg-indigo-800 text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                                            @if(isset($item['icon']))
                                                <x-dynamic-component :component="$item['icon']" class="mr-3 h-6 w-6 flex-shrink-0 text-indigo-300" />
                                            @else
                                                <div class="mr-3 h-6 w-6 flex-shrink-0"></div>
                                            @endif
                                            {{ $item['title'] }}
                                        </a>
                                    @else
                                        <a href="{{ isset($item['route']) ? route($item['route']) : '#' }}" class="text-white hover:bg-indigo-600 hover:bg-opacity-75 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                                            @if(isset($item['icon']))
                                                <x-dynamic-component :component="$item['icon']" class="mr-3 h-6 w-6 flex-shrink-0 text-indigo-300" />
                                            @else
                                                <div class="mr-3 h-6 w-6 flex-shrink-0"></div>
                                            @endif
                                            {{ $item['title'] }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    </nav>
                </div>
                <div class="flex flex-shrink-0 border-t border-indigo-800 p-4">

                    <div class="group block w-full flex-shrink-0">
                        <div class="flex items-center">
                            <a href="{{ route('profile.edit') }}">
                                <x-hero-icons.solid.user class="inline-block h-9 w-9 rounded-full text-indigo-300" />
                            </a>
                            <div class="ml-3">
                                <a href="{{ route('profile.edit') }}" class="text-sm font-medium text-white">{{ Auth::user()->name }}</a>
                                <form method="POST" action="{{ route('logout') }}"  class="flex flex-row items-center">
                                    @csrf

                                    <a href="{{ route('profile.edit') }}" class="pr-2 text-xs font-medium text-indigo-200 hover:text-white">Profile</a>
                                    <a class="cursor-pointer text-xs font-medium text-indigo-200 hover:text-white" href="{{ route('logout') }}"
                                                     onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-1 flex-col md:pl-64">
            <div class="sticky top-0 z-10 bg-gray-100 pl-1 pt-1 sm:pl-3 sm:pt-3 md:hidden">
                <button type="button" @click="open = true"
                    class="-ml-0.5 -mt-0.5 inline-flex h-12 w-12 items-center justify-center rounded-md text-gray-500 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                    <span class="sr-only">Open sidebar</span>
                    <x-hero-icons.outline.bars-3 class="h-6 w-6" />
                </button>
            </div>
            <main class="flex-1">
                <div class="py-6">
                    @if (isset($title))
                        <div class="mx-auto max-w-7xl px-4 sm:px-6 md:px-8">
                            <h1 class="text-2xl font-semibold text-gray-900">{{ $title }}</h1>
                        </div>
                    @endif
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 md:px-8">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>
    @livewireScripts
    </body>
</html>
