@push('modals')
    <div class="modal" x-show="activeModal === '{{ $identifier }}'" x-cloak>
        <div class="modal-content">
            <form action="{{ route(...$route) }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex flex-col justify-between h-full">
                    <div class="overflow-auto">
                        <div class="modal-header">
                            <button type="button" class="close" aria-hidden="true" @click.prevent="activeModal = false">&times;</button>
                            
                            <h4 class="modal-title">{{ $title }}</h4>
                        </div>

                        <div class="modal-body">
                            {!! $body !!}
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="text-gray-600 mr-4" @click.prevent="activeModal = false">Cancel</button>
                        
                        <button type="submit" class="button button-danger">{{ $submit ?? $title }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endpush
