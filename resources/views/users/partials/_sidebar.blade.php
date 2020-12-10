<aside class="py-6 px-2 sm:px-6 lg:py-0 lg:px-0 lg:col-span-3">
    <nav class="space-y-1">
        <x-sidebar-link to="{{ route('dashboard') }}" label="Dashboard" icon="heroicon-o-home" active="{{ is_active('dashboard') }}" />
        <x-sidebar-link to="{{ route('profile', Auth::user()->username()) }}" label="Profile" icon="heroicon-o-user" active="{{ is_active('profile') }}" />
        <x-sidebar-link to="{{ route('user.articles') }}" label="Articles" icon="heroicon-o-document" active="{{ is_active('user.articles') }}" />
        <x-sidebar-link to="{{ route('settings.profile') }}" label="Settings" icon="heroicon-o-cog" active="{{ is_active('settings.profile') }}" />
    </nav>
</aside>