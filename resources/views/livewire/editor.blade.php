<div class="editor">
    @if ($label)
        <span class="text-xl text-gray-900 font-semibold mb-4 block">
            {{ $label }}
        </span>
    @endif

    <div x-data="editorConfig($wire.entangle('body').defer, {{ $hasMentions }})" class="bg-white rounded-md {{ $hasShadow ? 'shadow-md' : '' }}">

        <ul class="flex p-5 gap-x-4">
            <li>
                <button 
                    type="button" 
                    @click="mode = 'write'" 
                    :class="{ 'text-lio-500 border-lio-500 border-b-2': mode === 'write' }"
                >
                    Write
                </button>
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
            <div class="flex flex-col relative">
                <div x-text="body + '\n'" class="invisible whitespace-pre-line border-none p-5 min-h-[5rem]"></div>
                <textarea 
                    class="w-full h-full absolute left-0 top-0 right-0 bottom-0 overflow-y-hidden resize-none border-none p-5 focus:border focus:border-lio-300 focus:ring focus:ring-lio-200 focus:ring-opacity-50"
                    id="body"
                    name="body"
                    placeholder="{{ $placeholder }}"
                    x-model=body
                    required
                    x-ref="editor"
                    @keydown.cmd.enter="submit($event)"
                    @keydown.ctrl.enter="submit($event)"
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
                        class="absolute flex flex-col bg-white rounded shadow" 
                        :style="`top: ${cursorTop}; left: ${cursorLeft}; display: ${showUserListbox() ? 'block' : 'none'}`"
                        tabindex="-1"
                        role="listbox"
                    >
                        @foreach ($users as $user)
                            <li
                                @click.prevent="selectUser('{{ $user['username'] }}')"
                                role="option"
                                class="flex items-center gap-x-2 p-2 cursor-pointer hover:bg-lio-100"
                                data-username="{{ $user['username'] }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                            >
                                <span class="text-gray-900 font-medium">
                                    {{ $user['username'] }}
                                </span>

                                <small class="text-gray-900 text-sm text-gray-500">
                                    {{ $user['name'] }}
                                </small>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>            

            <div class="flex flex-col items-center justify-end gap-y-4 gap-x-5 p-5 md:flex-row">
                <x-forms.editor.controls />

                @if ($hasButton)
                    <x-buttons.primary-cta type="{{ $buttonType }}" class="w-full md:w-auto" @click.prevent="submit">
                        <span class="flex items-center">
                            {{ $buttonLabel }}

                            @if ($buttonIcon)
                                <span class="ml-1">
                                    @svg($buttonIcon, 'w-5 h-5')
                                </span>
                            @endif
                        </span>
                    </x-buttons.primary-cta>
                @endif
            </div>
        </div>

        <div x-show="mode === 'preview'" x-cloak>
            <div class="prose prose-lio max-w-none p-5 break-words" id="editor-preview">
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