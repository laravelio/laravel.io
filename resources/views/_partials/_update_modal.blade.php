<form-modal identifier="{{ $identifier }}" :active-modal="activeModal">
    <div class="modal-content" v-cloak>
        {{ Form::open(['route' => $route, 'method' => 'PUT']) }}
            <div class="flex flex-col justify-between h-full">
                <div class="overflow-auto">
                    <div class="modal-header">
                        <button type="button" class="close" aria-hidden="true" @click="activeModal = null">&times;</button>
                        <h4 class="modal-title">{{ $title }}</h4>
                    </div>
                    <div class="modal-body">
                        {!! $body !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="text-gray-600 mr-4" @click="activeModal = null">Cancel</button>
                    {{ Form::submit($submit ?? $title, ['class' => 'button button-primary']) }}
                </div>
            </div>
        {{ Form::close() }}
    </div>
</form-modal>
