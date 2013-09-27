<div class="contributor member">
	<h2>{{ $contributor->name }}</h2>
	<img src="{{ $contributor->avatar_url }}" alt="{{ $contributor->name }}">
	<p>Count: {{ $contributor->contribution_count }}</p>
</div>