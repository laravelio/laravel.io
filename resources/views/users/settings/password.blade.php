@title('Password')

@extends('layouts.settings')

@section('content')
    <div class="md:p-4 md:border-2 md:rounded md:bg-gray-100 mb-8">
        <form action="{{ route('settings.password.update') }}" method="POST">
            @csrf
            @method('PUT')

            @if (Auth::user()->hasPassword())
                @formGroup('current_password')
                    <label for="current_password">Current Password</label>
                    <input type="password" name="current_password" id="current_password" class="form-control" required />
                    @error('current_password')
                @endFormGroup
            @endif

            @formGroup('password')
                <label for="password">New Password</label>
                <input type="password" name="password" id="password" class="form-control" required />
                @error('password')
            @endFormGroup

            @formGroup('password_confirmation')
                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required />
            @endFormGroup

            <div class="flex justify-end">
                <button type="submit" class="button button-primary">Save</button>
            </div>
        </form>
    </div>
@endsection
