@props(['thread'])

@canany([App\Policies\ThreadPolicy::LOCK, App\Policies\ThreadPolicy::UPDATE, App\Policies\ThreadPolicy::DELETE, App\Policies\ThreadPolicy::REPORT_SPAM], $thread)
    <div class="relative flex items-center -mr-3" x-data="{ open: false }" @click.outside="open = false">
        <button
            class="inline-block p-2 rounded hover:bg-gray-100"
            @click="open = !open"
        >
            <x-heroicon-o-ellipsis-horizontal class="w-6 h-6" />
        </button>

        <div
            x-cloak
            x-show="open"
            class="absolute top-12 right-1 flex flex-col bg-white rounded shadow w-48"
        >
            @can(App\Policies\ThreadPolicy::LOCK, $thread)
                <x-buk-form-button class="flex gap-x-2 p-3 w-full rounded hover:bg-gray-100" action="{{ route('threads.lock', $thread->slug()) }}">
                    @if ($thread->isLocked())
                        <x-heroicon-o-lock-closed class="w-6 h-6"/>
                        Unlock
                    @else
                        <x-heroicon-o-lock-open class="w-6 h-6"/>
                        Lock
                    @endif
                </x-buk-form-button>
            @endcan

            @can(App\Policies\ThreadPolicy::UPDATE, $thread)
                <a class="flex gap-x-2 p-3 rounded hover:bg-gray-100" href="{{ route('threads.edit', $thread->slug()) }}">
                    <x-heroicon-o-pencil class="w-6 h-6"/>
                    Edit
                </a>
            @endcan

            @can(App\Policies\ThreadPolicy::DELETE, $thread)
                <button class="flex gap-x-2 p-3 rounded hover:bg-gray-100" @click="activeModal = 'deleteThread'">
                    <x-heroicon-o-trash class="w-6 h-6 text-red-500"/>
                    Delete
                </button>
            @endcan

            @can(App\Policies\ThreadPolicy::REPORT_SPAM, $thread)
                <button class="flex gap-x-2 p-3 rounded hover:bg-gray-100" @click="activeModal = 'markAsSpam'">
                    <x-heroicon-o-exclamation-triangle class="w-6 h-6 text-red-500"/>
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
            <p>Are you sure you want to delete this thread and its replies? This cannot be undone.</p>

            @unless ($thread->isAuthoredBy(Auth::user()))
                <div class="mt-4">
                    <x-forms.inputs.textarea name="reason" label="Reason" placeholder="Optional reason that will be mailed to the author..." />
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
            <p>Are you sure this thread is spam? We'll report this to our moderators.</p>
        </x-modal>
    @endcan
@endcanany
