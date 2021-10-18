@props([
    'label' => null,
    'content' => null, 
    'enableActionButton' => false, 
    'actionButtonLabel' => 'Submit', 
    'actionButtonType' => 'submit',
    'actionButtonIcon' => null,
])

<div>
    @if ($label)
        <span class="text-xl text-gray-900 font-semibold mb-4 block">
            {{ $label }}
        </span>
    @endif

    <div x-data="editorConfig()" x-init="minHeight = $refs.editor.scrollHeight" class="bg-white rounded-md shadow-md">    
        <textarea
            @keyup.prevent="expand($refs.editor, minHeight)"
            @load.window="expand($refs.editor, minHeight)"
            x-ref="editor"
            name="body"
            id="body"
            class="resize-none h-40 focus:outline-none border-none p-5"
            placeholder=""
        >{{ old('body') ?: $content }}</textarea>

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
</div>