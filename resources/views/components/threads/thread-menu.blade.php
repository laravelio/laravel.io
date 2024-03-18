@props([
    'thread',
])

@canany([App\Policies\ThreadPolicy::LOCK, App\Policies\ThreadPolicy::UPDATE, App\Policies\ThreadPolicy::DELETE, App\Policies\ThreadPolicy::REPORT_SPAM], $thread)
    <div
        class="relative -mr-3 flex items-center"
        x-data="{ open: false }"
        @click.outside="open = false"
    >
        <button
            class="inline-block rounded p-2 hover:bg-gray-100"
            @click="open = !open"
        >
            <x-heroicon-o-ellipsis-horizontal class="h-6 w-6" />
        </button>

        <div
            x-cloak
            x-show="open"
            class="absolute right-1 top-12 flex w-48 flex-col rounded bg-white shadow"
        >
            @can(App\Policies\ThreadPolicy::LOCK, $thread)
                <x-buk-form-button
                    class="flex w-full gap-x-2 rounded p-3 hover:bg-gray-100"
                    action="{{ route('threads.lock', $thread->slug()) }}"
                >
                    @if ($thread->isLocked())
                        <x-heroicon-o-lock-closed class="h-6 w-6" />
                        Unlock
                    @else
                        <x-heroicon-o-lock-open class="h-6 w-6" />
                        Lock
                    @endif
                </x-buk-form-button>
            @endcan

            @can(App\Policies\ThreadPolicy::UPDATE, $thread)
                <a
                    class="flex gap-x-2 rounded p-3 hover:bg-gray-100"
                    href="{{ route('threads.edit', $thread->slug()) }}"
                >
                    <x-heroicon-o-pencil class="h-6 w-6" />
                    Edit
                </a>
            @endcan

            @can(App\Policies\ThreadPolicy::DELETE, $thread)
                <button
                    class="flex gap-x-2 rounded p-3 hover:bg-gray-100"
                    @click="activeModal = 'deleteThread'"
                >
                    <x-heroicon-o-trash class="h-6 w-6 text-red-500" />
                    Delete
                </button>
            @endcan

            @can(App\Policies\ThreadPolicy::REPORT_SPAM, $thread)
                <button
                    class="flex gap-x-2 rounded p-3 hover:bg-gray-100"
                    @click="activeModal = 'markAsSpam'"
                >
                    <x-heroicon-o-exclamation-triangle
                        class="h-6 w-6 text-red-500"
                    />
                    Mark as spam
                </button>
            @endcan
        </div>
    </div>

    @can(App\Policies\ThreadPolicy::DELETE, $thread)
        <x-modal
            identifier="deleteThread"
            :action="route('threads.delete', $thread->slug())"
            title="Delete Thread"
        >
            <p>
                Are you sure you want to delete this thread and its replies?
                This cannot be undone.
            </p>

            @unless ($thread->isAuthoredBy(Auth::user()))
                <div class="mt-4">
                    <x-forms.inputs.textarea
                        name="reason"
                        label="Reason"
                        placeholder="Optional reason that will be mailed to the author..."
                    />
                </div>
            @endunless
        </x-modal>
    @endcan

    @can(App\Policies\ThreadPolicy::REPORT_SPAM, $thread)
        <x-modal
            identifier="markAsSpam"
            :action="route('threads.spam.mark', $thread->slug())"
            title="Mark as spam"
            type="post"
        >
            <p>
                Are you sure this thread is spam? We'll report this to our
                moderators.
            </p>
        </x-modal>
    @endcan
@endcanany
