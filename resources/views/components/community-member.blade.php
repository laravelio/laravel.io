<div class="shrink-0 mr-8 my-2 cursor-pointer">
    <x-avatar
        :user="$member"
        class="inset-0 hover:scale-120 transition-transform duration-300 ease-in-out"
        x-on:mouseover="active = {{ $member->id }}"
        x-on:mouseout="active = false"
        size="xl"
    />
</div>
