<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('最初のページ') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5 text-3xl text-green-900">
                    <x-nav-link :href="route('info')" :active="request()->routeIs('info')">
                        {{ __('お知らせ') }}
                    </x-nav-link>
                </div>
            </div>
        </div>
    </div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5 text-3xl text-green-900">
                    <x-nav-link :href="route('tweets.index')" :active="request()->routeIs('tweet.index')">
                        {{ __('My Famiry Tail Chat') }}
                    </x-nav-link>
                </div>
            </div>
        </div>
    </div>


    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5 text-3xl text-green-900">
                    <x-nav-link :href="route('senryus.index')" :active="request()->routeIs('senryus.index')">
                        {{ __('シルバー川柳') }}
                    </x-nav-link>
                </div>
            </div>
        </div>
    </div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5 text-3xl text-green-900">
                    <x-nav-link :href="route('youtube.index')" :active="request()->routeIs('youtube.index')">
                        {{ __('動画交流') }}
                    </x-nav-link>
                </div>
            </div>
        </div>
    </div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5 text-3xl text-green-900">
                    <x-nav-link :href="route('events.index')" :active="request()->routeIs('events.index')">
                        {{ __('オンラインイベント') }}
                    </x-nav-link>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
