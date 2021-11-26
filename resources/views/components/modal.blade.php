@push('modals')
    <div class="modal" x-show="activeModal == '{{ $identifier }}'" x-cloak>
        <div class="modal-content" @click.outside="activeModal = false">
            <x-buk-form :action="$action" :method="$method()">
                <div class="flex flex-col justify-between h-full">
                    <div class="overflow-auto">
                        <div class="modal-header">
                            <button type="button" class="close" aria-hidden="true" @click.prevent="activeModal = false">&times;</button>
                            
                            <h4 class="modal-title">{{ $title }}</h4>
                        </div>

                        <div class="modal-body">
                            {{ $slot }}
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="text-gray-600 mr-4" @click.prevent="activeModal = false">Cancel</button>
                        
                        <button type="submit" class="button {{ $type === 'delete' ? 'button-danger' : 'button-primary' }}">{{ $submit ?? $title }}</button>
                    </div>
                </div>
            </x-buk-form>
        </div>
    </div>
@endpush