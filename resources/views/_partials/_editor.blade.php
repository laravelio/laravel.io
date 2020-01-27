<div x-data="editorConfig()">
    <div class="border-2 border-b-0 rounded-t p-2 bg-gray-200">
        <ul>
            <li>
                <template
                    x-for="[key, value] of Object.entries(styles)"
                    :key="key"
                >
                    <button 
                        type="button" 
                        class="text-gray-600 mr-4 cursor-pointer"
                        @click="handleClick(key, $el)"
                    >
                        <i class="fa" :class="value.class"></i>
                    </button>
                </template>
            </li>
        </ul>
    </div>
    <textarea
        name="body"
        id="body"
        class="editor rounded-t-none resize-none h-40"
    >{{ $content }}</textarea>
</div>