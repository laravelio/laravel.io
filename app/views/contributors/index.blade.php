<h1>Contributors</h1>

<ul>
    @foreach($contributors as $contributor)
        <li>
            @if($contributor->user)
                @render('contributors._card', ['user' => $contributor->user, 'count' => $contributor->contribution_count])
            @else
                @render('contributors._card', ['user' => $contributor, 'count' => $contributor->contribution_count])
            @endif
        </li>
    @endforeach
</ul>