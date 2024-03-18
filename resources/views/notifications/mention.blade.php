@php($data = $notification->data)

<tr>
    <td
        class="whitespace-nowrap border-b border-gray-200 px-6 py-4 text-sm leading-5 text-gray-600"
    >
        <div class="flex items-center">
            <x-heroicon-o-megaphone class="mr-4 h-5 w-5" />

            <div>
                You were mentioned in
                <a
                    href="{{ route('replyable', [$data['replyable_id'], $data['replyable_type']]) }}"
                    class="text-lio-700"
                >
                    "{{ $data['replyable_subject'] }}"
                </a>
                .
            </div>
        </div>
    </td>

    <td
        class="whitespace-nowrap border-b border-gray-200 px-6 py-4 text-sm leading-5 text-gray-600"
    >
        {{ $notification->created_at->diffForHumans() }}
    </td>

    <td
        class="whitespace-nowrap border-b border-gray-200 px-6 py-4 text-right text-sm leading-5 text-gray-600"
    >
        <div class="flex justify-end">
            <button
                wire:click="markAsRead('{{ $notification->id }}')"
                class="text-lio-500"
            >
                <x-heroicon-s-check class="h-5 w-5" />
            </button>
        </div>
    </td>
</tr>
