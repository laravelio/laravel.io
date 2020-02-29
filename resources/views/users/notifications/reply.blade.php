<tr>
    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-600">
        <div class="flex items-center">
            <svg viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-4">
                <path fill-rule="evenodd" d="M7.707 3.293a1 1 0 010 1.414L5.414 7H11a7 7 0 017 7v2a1 1 0 11-2 0v-2a5 5 0 00-5-5H5.414l2.293 2.293a1 1 0 11-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
            </svg>
            <div>
                @if($data['thread']['author_id'] == Auth::id())
                    <a href="{{ route('profile', $data['author']['username']) }}" class="text-green-darker">{{ $data['author']['name'] }}</a> replied to your <a href="{{ route('thread', $data['thread']['slug']) }}" class="text-green-darker">thread</a>
                @else
                    <a href="{{ route('profile', $data['author']['username']) }}" class="text-green-darker">{{ $data['author']['name'] }}</a> replied to a <a href="{{ route('thread', $data['thread']['slug']) }}" class="text-green-darker">thread</a> you're subscribed to
                @endif
            </div>
        </div>
    </td>
    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-600">
        {{ $notification->created_at->diffForHumans() }}
    </td>
    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-600 text-right">
        <div class="flex justify-end">
            <button wire:click="markAsRead('{{ $notification->id }}')" class="text-green-primary">
                <svg viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
    </td>
</tr>