<div>
    @if ($label)
        <span class="text-xl text-gray-900 font-semibold mb-4 block">
            {{ $label }}
        </span>
    @endif

    <div x-data="editorConfig($wire.entangle('body'))" class="bg-white rounded-md shadow-md">
        <ul class="flex p-5 gap-x-4">
            <li>
                <button type="button" @click="mode = 'write'">Write</button>
            </li>

            <li>
                <button type="button" @click="mode = 'preview'" wire:click="preview">Preview</button>
            </li>
        </ul>

        <div x-show="mode === 'write'">
            <div class="flex flex-col relative">
                <div x-text="body" class="invisible whitespace-pre-wrap p-5 min-h-[5rem]"></div>
                <textarea 
                    class="w-full h-full absolute left-0 top-0 right-0 bottom-0 overflow-y-hidden resize-none border-none p-5"
                    id="body"
                    name="body"
                    placeholder="Write a reply..."
                    wire:model.defer="body"
                    x-model='body'
                >{{ $body }}</textarea>
            </div>

            <div class="flex flex-col items-center justify-end gap-y-4 gap-x-5 p-5 md:flex-row">
                <ul class="flex items-center gap-x-5">
                    <li class="flex">
                        <button 
                            title="Heading"
                            type="button" 
                            class="text-gray-900 cursor-pointer"
                            @click="handleClick('header', $el)"
                        >
                            <x-icon-heading class="w-5 h-5 md:w-6 md:h-6"/>
                        </button>
                    </li>

                    <li class="flex">
                        <button 
                            title="Bold"
                            type="button" 
                            class="text-gray-900 cursor-pointer"
                            @click="handleClick('bold', $el)"
                        >
                            <x-icon-bold class="w-5 h-5 md:w-6 md:h-6"/>
                        </button>
                    </li>

                    <li class="flex">
                        <button
                            title="Italic"
                            type="button" 
                            class="text-gray-900 cursor-pointer"
                            @click="handleClick('italic', $el)"
                        >
                            <x-icon-italic class="w-5 h-5 md:w-6 md:h-6"/>
                        </button>
                    </li>

                    <li class="flex">
                        <button 
                            title="Block quotation"
                            type="button" 
                            class="text-gray-900 cursor-pointer"
                            @click="handleClick('quote', $el)"
                        >
                            <x-heroicon-s-chevron-right class="w-5 h-5 md:w-6 md:h-6"/>
                        </button>
                    </li>

                    <li class="flex">
                        <button
                            title="Code sample"
                            type="button" 
                            class="text-gray-900 cursor-pointer"
                            @click="handleClick('code', $el)"
                        >
                            <x-heroicon-o-code class="w-5 h-5 md:w-6 md:h-6"/>
                        </button>
                    </li>

                    <li class="flex">
                        <button
                            title="Link"
                            type="button" 
                            class="text-gray-900 cursor-pointer"
                            @click="handleClick('link', $el)"
                        >
                            <x-heroicon-o-link class="w-5 h-5 md:w-6 md:h-6"/>
                        </button>
                    </li>

                    <li class="flex">
                        <button
                            title="Image"
                            type="button" 
                            class="text-gray-900 cursor-pointer"
                            @click="handleClick('image', $el)"
                        >
                            <x-heroicon-o-photograph class="w-5 h-5 md:w-6 md:h-6"/>
                        </button>
                    </li>
                </ul>

                @if ($enableActionButton)
                    <x-buttons.primary-cta type="{{ $actionButtonType }}" class="w-full md:w-auto">
                        <span class="flex items-center">
                            {{ $actionButtonLabel }}

                            @if ($actionButtonIcon)
                                <span class="ml-1">
                                    @svg($actionButtonIcon, 'w-5 h-5')
                                </span>
                            @endif
                        </span>
                    </x-buttons.primary-cta>
                @endif
            </div>
        </div>

        <div class="prose prose-lio max-w-none p-6 break-words" x-show="mode === 'preview'" x-cloak id="editor-preview">
            {!! $this->preview !!}
        </div>
    </div>
</div>