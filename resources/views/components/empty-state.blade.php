
@props(['icon', 'title'])

<div class="text-center">
    @svg($icon, 'mx-auto h-12 w-12 text-gray-400')
    
    <h3 class="mt-2 text-sm font-medium text-gray-900">
        {{ $title }}
    </h3>
</div>