@php($data = $notification->data)

<tr>
    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200 text-sm leading-5 text-gray-600">
        <div class="flex items-center">
            <x-heroicon-s-reply class="w-5 h-5 mr-4"/>

            <div>
                A new reply was added to <a href="{{ route('replyable', [$data['replyable_id'], $data['replyable_type']]) }}" class="text-lio-700">"{{ $data['replyable_subject'] }}"</a>.
            </div>
        </div>
    </td>

    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200 text-sm leading-5 text-gray-600">
        {{ $notification->created_at->diffForHumans() }}
    </td>

    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200 text-sm leading-5 text-gray-600 text-right">
        <div class="flex justify-end">
            <button wire:click="markAsRead('{{ $notification->id }}')" class="text-lio-500">
                <x-heroicon-s-check class="w-5 h-5"/>
            </button>
        </div>
    </td>
</tr>
