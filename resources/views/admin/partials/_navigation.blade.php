<nav class="space-y-1">
    <x-sidebar-link href="{{ route('admin') }}" icon="heroicon-o-user-group" :active="is_active('admin')">
        Users
    </x-sidebar-link>

    <x-sidebar-link href="{{ route('admin.articles') }}" icon="heroicon-o-document-duplicate" :active="is_active('admin.articles')">
        Articles
    </x-sidebar-link>
</nav>