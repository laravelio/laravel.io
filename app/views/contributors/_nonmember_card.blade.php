<div class="contributor nonMember">
    <h2>{{ $contributor->name }}</h2>
    <p class="github-link">
        <a href="{{ $contributor->github_url }}">Github profile</a>
    </p>
    <p class="avatar">
        <img src="{{ $contributor->avatar_url }}" alt="{{ $contributor->name }}">
    </p>
    <p class="count">
        Count: {{ $contributor->contribution_count }}
    </p>
</div>
