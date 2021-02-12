<section aria-labelledby="who-to-follow-heading">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <h2 id="who-to-follow-heading" class="text-base font-medium text-gray-900">
                Thanks to our community
            </h2>
            <div class="mt-6 flow-root">
                <ul class="-my-4 divide-y divide-gray-200">
                    @foreach (\App\Models\User::mostReplies()->take(3)->get() as $user)
                        <li class="flex items-center py-4 space-x-3">
                            <div class="flex-shrink-0">
                                <x-avatar :user="$user" class="h-8 w-8 rounded-full" />
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-gray-900">
                                    <a href="{{ route('profile', $user->username()) }}">
                                        {{ $user->name() }}
                                    </a>
                                </p>

                                <p class="text-sm text-gray-500">
                                    {{ $user->countReplies() }} replies, {{ $user->countSolutions() }} solutions
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="flex items-center justify-center rounded-lg inline-flex bg-lio-100 text-lio-700 h-10 w-10">
                                    {{ $loop->iteration }}
                                </span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>