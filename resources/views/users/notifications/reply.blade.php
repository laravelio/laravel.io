<tr>
    <td><i class="fa fa-reply text-gray-500"></i></td>
    <td>
        @if($data['thread']['author_id'] == Auth::id())
            <a href="{{ route('profile', $data['author']['username']) }}" class="text-green-darker">{{ $data['author']['name'] }}</a> replied to your <a href="{{ route('thread', $data['thread']['slug']) }}" class="text-green-darker">thread</a>
        @else
            <a href="{{ route('profile', $data['author']['username']) }}" class="text-green-darker">{{ $data['author']['name'] }}</a> replied to a <a href="{{ route('thread', $data['thread']['slug']) }}" class="text-green-darker">thread</a> you're subscribed to
        @endif
    </td>
    <td>
        {{ $notification->created_at->diffForHumans() }}
    </td>
    <td>
        <button wire:click="markAsRead('{{ $notification->id }}')">
            <i class="fa fa-check"></i>
        </button>
    </td>
</tr>