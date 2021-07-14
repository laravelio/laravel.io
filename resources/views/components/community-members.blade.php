<div class="flex flex-col w-full" x-data="{ active: false }">
    @isset ($members[0])
        <div class="flex" style="margin-left: 134px;">
            @foreach ($members[0] as $member)
                <x-community-member :member="$member" />
            @endforeach
        </div>
    @endisset

    @isset ($members[1])
        <div class="flex" style="margin-left: 71px;">
            @foreach ($members[1] as $member)
                <x-community-member :member="$member" />
            @endforeach
        </div>
    @endisset

    @isset ($members[2])
        <div class="flex">
            @foreach ($members[2] as $member)
                <x-community-member :member="$member" />
            @endforeach
        </div>
    @endisset

    @isset ($members[3])
        <div class="flex" style="margin-left: 71px;">
            @foreach ($members[3] as $member)
                <x-community-member :member="$member" />
            @endforeach
        </div>
    @endisset

    @isset ($members[4])
        <div class="flex" style="margin-left: 134px;">
            @foreach ($members[4] as $member)
                <x-community-member :member="$member" />
            @endforeach
        </div>
    @endisset
</div>
