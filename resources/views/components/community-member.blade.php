<div class="flex-shrink-0 w-14 h-14 md:w-20 md:h-20 mr-8 my-2 cursor-pointer">
    <x-stat-popout
        x-cloak
        x-show="active == '{{ $member->id }}'"
        class="w-64 absolute -mt-40 -ml-20"
        :user="$member"
    />

    <x-avatar
        :user="$member"
        class="inset-0 w-14 h-14 md:w-20 md:h-20"
        x-on:mouseover="active = {{ $member->id }}"
        x-on:mouseout="active = false"
    />
</div>
