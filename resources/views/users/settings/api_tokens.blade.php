@title('API Tokens')

<section aria-labelledby="api_token_settings_heading" class="mt-6">
    <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div>
                <h2 id="api_token_settings_heading" class="text-lg leading-6 font-medium text-gray-900">
                    API Tokens
                </h2>

                <p class="mt-1 text-sm leading-5 text-gray-500">
                    Create API tokens to access your account over our REST API.
                </p>
            </div>

            <ul class="space-y-3">
                @foreach (Auth::user()->tokens as $token)
                    <li class="md:flex justify-between md:space-x-2">
                        <div>
                            <span class="block font-bold">
                                {{ $token->name }}
                            </span>

                            <time datetime="{{ $token->created_at }}" class="block mb-2 text-sm w-full text-gray-700">
                                {{ $token->created_at->diffForHumans() }}
                            </time>
                        </div>

                        <x-buk-form method="DELETE" :action="route('settings.api-tokens.delete')">
                            <input type="hidden" name="id" value="{{ $token->getKey() }}" />

                            <x-buttons.danger-button>
                                Delete Token
                            </x-buttons.danger-button>
                        </x-buk-form>
                    </li>
                @endforeach
            </ul>

            <div>
                <div class="col-span-12">
                    <x-forms.label for="token_name">Token name</x-forms.label>

                    <x-forms.inputs.input name="token_name" form="api_token_settings_form" required />
                </div>
            </div>
        </div>

        <x-buk-form id="api_token_settings_form" method="POST" action="{{ route('settings.api-tokens.store') }}">
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <x-buttons.primary-button type="submit">
                    Generate New Token
                </x-buttons.primary-button>
            </div>
        </x-buk-form>
    </div>
</section>
