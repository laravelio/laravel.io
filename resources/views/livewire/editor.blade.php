<div class="editor">
    @if ($label)
        <span class="mb-4 block text-xl font-semibold text-gray-900">
            {{ $label }}
        </span>
    @endif

    <div x-data="editorConfig(@entangle('body'), {{ $hasMentions }})" class="{{ $hasShadow ? 'shadow-md' : '' }} rounded-md bg-white">
        <ul class="flex gap-x-4 p-5">
            <li>
                <button type="button" @click="mode = 'write'" :class="{ 'text-lio-500 border-lio-500 border-b-2': mode === 'write' }">Write</button>
            </li>

            <li>
                <button
                    type="button"
                    @click="mode = 'preview'"
                    wire:click="preview"
                    :class="{ 'text-lio-500 border-lio-500 border-b-2': mode === 'preview' }"
                >
                    Preview
                </button>
            </li>
        </ul>

        <div x-show="mode === 'write'">
            <div class="relative flex flex-col">
                <div x-text="body + '\n'" class="invisible min-h-[5rem] whitespace-pre-line border-none p-5"></div>
                <textarea
                    class="absolute bottom-0 left-0 right-0 top-0 h-full w-full resize-none overflow-y-hidden border-none p-5 focus:border focus:border-lio-300 focus:ring focus:ring-lio-200 focus:ring-opacity-50"
                    id="body"
                    name="body"
                    placeholder="{{ $placeholder }}"
                    x-model="body"
                    required
                    x-ref="editor"
                    @keydown.cmd.enter="submit"
                    @keydown.ctrl.enter="submit"
                    @keydown.space="showMentions = false"
                    @keydown.down="highlightNextUser(event)"
                    @keydown.up="highlightPreviousUser(event)"
                    @keydown.enter="selectHighlightedUser(event)"
                    @keydown.escape="showMentions = false"
                    @click.away="showMentions = false"
                    @keydown.debounce.500ms="updateUserSearch($event)"
                ></textarea>

                @if (count($users) > 0)
                    <ul
                        x-cloak
                        x-show="showUserListbox()"
                        x-ref="users"
                        class="absolute flex flex-col rounded bg-white shadow"
                        :style="`top: ${cursorTop}; left: ${cursorLeft}; display: ${showUserListbox() ? 'block' : 'none'}`"
                        tabindex="-1"
                        role="listbox"
                    >
                        @foreach ($users as $user)
                            <li
                                @click.prevent="selectUser('{{ $user['username'] }}')"
                                role="option"
                                class="flex cursor-pointer items-center gap-x-2 p-2 hover:bg-lio-100"
                                data-username="{{ $user['username'] }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                            >
                                <span class="font-medium text-gray-900">
                                    {{ $user['username'] }}
                                </span>

                                <small class="text-sm text-gray-500 text-gray-900">
                                    {{ $user['name'] }}
                                </small>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="flex flex-col items-center justify-end gap-x-5 gap-y-4 p-5 md:flex-row">
                <x-forms.editor.controls />

                @isset($cancelLink)
                    <span class="text-gray-500">|</span>

                    <a href="{{ $cancelLink }}" class="text-lio-700"> Cancel </a>
                @endisset

                @isset($cancelAction)
                    <span class="text-gray-500">|</span>

                    <button class="text-lio-700" {!! $cancelAction !!}>Cancel</button>
                @endisset

                @if ($hasButton)
                    <x-buttons.primary-cta type="{{ $buttonType }}" class="w-full md:w-auto" @click.prevent="submit">
                        <span class="flex items-center">
                            {{ $buttonLabel }}

                            @if ($buttonIcon)
                                <span class="ml-1">
                                    @svg($buttonIcon, 'h-5 w-5')
                                </span>
                            @endif
                        </span>
                    </x-buttons.primary-cta>
                @endif
            </div>
        </div>

        <div x-show="mode === 'preview'" x-cloak>
            <div class="prose-lio prose max-w-none break-words p-5" id="editor-preview">
                {!! $this->preview !!}
            </div>
        </div>
    </div>

    @if ($errors->has('body'))
        @foreach ($errors->get('body') as $error)
            <x-forms.error>{{ $error }}</x-forms.error>
        @endforeach
    @endif
</div>
