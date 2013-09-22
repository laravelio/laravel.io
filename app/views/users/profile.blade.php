<h1>{{ $user->name }}</h1>
<img src="{{ $user->image_url }}"/>
<a href="{{ $user->github_url }}">GitHub Profile</a>

<h2>Forum</h2>

@if($user->mostRecentFiveForumPosts->count() > 0)
	<ul>
		@foreach($user->mostRecentFiveForumPosts as $post)
			<li>
				@if($post->parent)				
					<a href="{{ $post->parent->forumThreadUrl }}">reply to: {{ $post->parent->title }}</a>
				@else
					title: {{ $post->title }}
				@endif

				<p>
					{{ Str::words($post->body, 200) }}
				</p>
			</li>
		@endforeach
	</ul>
@endif