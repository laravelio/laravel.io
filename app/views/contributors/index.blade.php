<h1>Contributors</h1>

<ul>
    @foreach($contributors as $contributor)
        <li>
            @if($contributor->user)
                @include('contributors._member_card')
            @else
                @include('contributors._nonmember_card')
            @endif
        </li>
    @endforeach
</ul>