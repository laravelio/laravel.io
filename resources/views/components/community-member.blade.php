<div class="my-2 mr-8 h-14 w-14 shrink-0 cursor-pointer md:h-20 md:w-20">
    <x-stat-popout x-cloak x-show="active == '{{ $member->id }}'" class="absolute -ml-20 -mt-40 w-64" :user="$member" />

    <x-avatar
        :user="$member"
        class="inset-0 h-14 w-14 md:h-20 md:w-20"
        x-on:mouseover="active = {{ $member->id }}"
        x-on:mouseout="active = false"
    />
</div>
