<div>
    <div x-data="{ showApi: false, copyToast: false }" class="flex justify-end items-center">
        <input
            x-bind:type="!showApi ? 'password' : 'text'"
            name="apikey" readonly="readonly" value="{{ $token }}"
            class="bg-white mr-2 text-gray-800 px-2 py-1 rounded-md"
        />

        <x-heroicon-o-clipboard
            aria-label="Copy API key"
            @@click="navigator.clipboard.writeText('{{ $token }}'); copyToast = true; setTimeout(() => copyToast = false, 4000)"
            class="mr-2 text-white h-6 w-6 hover:cursor-pointer"
        />

        <x-heroicon-o-eye aria-label="Show Api Key" x-show="!showApi" @@click="showApi = true" class="mr-2 h-6 w-6 text-white hover:cursor-pointer" />

        <x-heroicon-o-eye-slash aria-label="Hide API Key" x-show="showApi" @@click="showApi = false" class="mr-2 h-6 w-6 text-white hover:cursor-pointer" />

        <div x-show="copyToast" x-transition class="fixed bottom-20 left-0 z-10 right-0 flex justify-center items-center">
            <span class="text-white z-[99999] bg-gray-800 px-5 py-4 rounded-md text-md">
                API Key Copied
            </span>
        </div>
    </div>
</div>
