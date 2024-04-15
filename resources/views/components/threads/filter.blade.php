<div class="flex w-full rounded shadow">
    <a
        href="{{ url(request()->url().'?filter=recent') }}"
        aria-current="{{ $filter === 'recent' ? 'page' : 'false' }}"
        class="{{ $filter === 'recent' ? 'border-gray-900 bg-gray-900 text-white hover:bg-gray-800' : 'border-gray-200 bg-white text-gray-800 hover:bg-gray-100' }} flex w-full justify-center rounded-l border px-5 py-2 font-medium"
    >
        Recent
    </a>

    <a
        href="{{ url(request()->url().'?filter=resolved') }}"
        aria-current="{{ $filter === 'resolved' ? 'page' : 'false' }}"
        class="{{ $filter === 'resolved' ? 'border-gray-900 bg-gray-900 text-white hover:bg-gray-800' : 'border-gray-200 bg-white text-gray-800 hover:bg-gray-100' }} flex w-full justify-center border-b border-t px-5 py-2 font-medium"
    >
        Resolved
    </a>

    <a
        href="{{ url(request()->url().'?filter=unresolved') }}"
        aria-current="{{ $filter === 'unresolved' ? 'page' : 'false' }}"
        class="{{ $filter === 'unresolved' ? 'border-gray-900 bg-gray-900 text-white hover:bg-gray-800' : 'border-gray-200 bg-white text-gray-800 hover:bg-gray-100' }} flex w-full justify-center rounded-r border px-5 py-2 font-medium"
    >
        Unresolved
    </a>
</div>
