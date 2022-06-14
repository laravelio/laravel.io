<div>
    <section aria-labelledby="list_blocked_users" class="mt-6">
        <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                <div>
                    <h2 id="list_blocked_users" class="text-lg leading-6 font-medium text-red-500 uppercase">Blocked Users</h2>
                    <p class="mt-1 text-sm leading-5 text-gray-500">
                        Adding these users will result in them being blocked from your account.
                    </p>
                </div>
                @empty($this->blockedUsers)
                    <div>No Blocked users</div>
                @endempty
                <ul class="space-y-3">
                    @foreach ($this->blockedUsers as $user)
                        <li class="md:flex justify-between items-center md:space-x-2">
                            <div>
                                <span class="block font-bold">
                                    {{ $user->username() }}
                                </span>
                            </div>

                            <x-buttons.danger-button wire:click="removeBlockedUser('{{ $user->username() }}')">
                                Remove from blocked list
                            </x-buttons.danger-button>
                        </li>
                    @endforeach
                </ul>
                <div>
                    <div class="col-span-12">
                        <x-forms.label for="username">User name</x-forms.label>

                        <x-forms.inputs.input name="username" list="potentiallyBlockedUsers" wire:model="blockedUsername" />
                        <datalist id="potentiallyBlockedUsers">
                            @foreach ($this->potentiallyBlockedUsers as $user)
                                <option value="{{ $user->username() }}">
                            @endforeach
                        </datalist>
                    </div>
                    @if ($errors->has('blockedUsername'))
                        <span class="text-red-500">{{ $errors->first('blockedUsername') }}</span>
                    @endif
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <x-buttons.primary-button wire:click="addBlockedUser">
                            Add to the blocked list
                        </x-buttons.primary-button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
