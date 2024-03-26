<div>
    <div x-data="{ showApi: false, copyToast: false }" class="flex items-center justify-end">
        <input
            x-bind:type="! showApi ? 'password' : 'text'"
            name="apikey"
            readonly="readonly"
            value="{{ $token }}"
            class="mr-2 rounded-md bg-white px-2 py-1 text-gray-800"
        />

        <x-heroicon-o-clipboard
            aria-label="Copy API key"
            @@click="navigator.clipboard.writeText('{{ $token }}'); copyToast = true; setTimeout(() => copyToast = false, 4000)"
            class="mr-2 h-6 w-6 text-white hover:cursor-pointer"
        />

        <x-heroicon-o-eye aria-label="Show Api Key" x-show="!showApi" @@click="showApi = true" class="mr-2 h-6 w-6 text-white hover:cursor-pointer" />

        <x-heroicon-o-eye-slash
            aria-label="Hide API Key"
            x-show="showApi"
            @@click="showApi = false"
            class="mr-2 h-6 w-6 text-white hover:cursor-pointer"
        />

        <div x-show="copyToast" x-transition class="fixed bottom-20 left-0 right-0 z-10 flex items-center justify-center">
            <span class="text-md z-[99999] rounded-md bg-gray-800 px-5 py-4 text-white">API Key Copied</span>
        </div>
    </div>
</div>
