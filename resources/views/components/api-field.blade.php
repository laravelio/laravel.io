<div>
    <div x-data="{ showApi: false, copyToast: false }" class="flex justify-end items-center"><input x-bind:type="!showApi ? 'password' : 'text'" name="apikey" readonly="readonly" value="{{ $token['token'] }}" class="bg-white mr-2 text-gray-800 px-2 py-1 rounded-md"> 
        
        <svg aria-label="Copy API key" @click="navigator.clipboard.writeText('{{ $token['token'] }}'); copyToast = true; setTimeout(() => copyToast = false, 4000)" class="mr-2 hover:cursor-pointer" style="width:24px;height:24px" viewBox="0 0 24 24">
          <path fill="currentColor" d="M19,21H8V7H19M19,5H8A2,2 0 0,0 6,7V21A2,2 0 0,0 8,23H19A2,2 0 0,0 21,21V7A2,2 0 0,0 19,5M16,1H4A2,2 0 0,0 2,3V17H4V3H16V1Z" />
        </svg>
    
        <svg aria-label="Show Api Key" x-show="!showApi" @click="showApi = true" class="mr-2 hover:cursor-pointer" style="width:24px;height:24px" viewBox="0 0 24 24">
         <path fill="currentColor" d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z" />
        </svg> 
    
        <svg aria-label="Hide API Key" x-show="showApi" @click="showApi = false" class="mr-2 hover:cursor-pointer" style="width:24px;height:24px" viewBox="0 0 24 24">
         <path fill="currentColor" d="M11.83,9L15,12.16C15,12.11 15,12.05 15,12A3,3 0 0,0 12,9C11.94,9 11.89,9 11.83,9M7.53,9.8L9.08,11.35C9.03,11.56 9,11.77 9,12A3,3 0 0,0 12,15C12.22,15 12.44,14.97 12.65,14.92L14.2,16.47C13.53,16.8 12.79,17 12,17A5,5 0 0,1 7,12C7,11.21 7.2,10.47 7.53,9.8M2,4.27L4.28,6.55L4.73,7C3.08,8.3 1.78,10 1,12C2.73,16.39 7,19.5 12,19.5C13.55,19.5 15.03,19.2 16.38,18.66L16.81,19.08L19.73,22L21,20.73L3.27,3M12,7A5,5 0 0,1 17,12C17,12.64 16.87,13.26 16.64,13.82L19.57,16.75C21.07,15.5 22.27,13.86 23,12C21.27,7.61 17,4.5 12,4.5C10.6,4.5 9.26,4.75 8,5.2L10.17,7.35C10.74,7.13 11.35,7 12,7Z" />
        </svg>
    
        <div x-show="copyToast" x-transition class="fixed bottom-20 left-0 z-10 right-0 flex justify-center items-center" style="display:none;"><span class="text-white z-[99999] bg-gray-800 px-5 py-4 rounded-md text-md">API Key Copied</span></div>
    </div>
</div>