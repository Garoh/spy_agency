@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <p>
            <label for="name">{{ __('Name') }}</label>

            <input id="name" type="text" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>

            @error('name')
                <strong>{{ $message }}</strong>
            @enderror
        </p>

        <p>
            <label for="email">{{ __('E-Mail Address') }}</label>

            <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email">

            @error('email')
                <strong>{{ $message }}</strong>
            @enderror
        </p>

        <p>
            <label for="description">{{ __('Description') }}</label>

            <input id="description" type="text" name="description" value="{{ old('description') }}"  
                autocomplete="description">

            @error('description')
                <strong>{{ $message }}</strong>
            @enderror
        </p>

        <p>
            <label for="password">{{ __('Password') }}</label>

            <input id="password" type="password" name="password" autocomplete="new-password">

            @error('password')
                <strong>{{ $message }}</strong>
            @enderror
        </p>

        <p>
            <label for="password-confirm">{{ __('Confirm Password') }}</label>

            <input id="password-confirm" type="password" name="password_confirmation"  autocomplete="new-password">
        </p>

        <p>
            <button type="submit" class="btn btn-primary">
                {{ __('Register') }}
            </button>
        </p>
    </form>
@endsection
