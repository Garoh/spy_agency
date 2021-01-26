@extends('layouts.app')

@section('content')

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <p>
            <label for="email">{{ __('E-Mail') }}</label>

            <input id="email" type="email" name="email" value="{{ old('email') }}" 
                autocomplete="email" autofocus>

            @error('email')
                    <strong>{{ $message }}</strong>
            @enderror
        </p>

        <p>
            <label for="password">{{ __('Password') }}</label>

                <input id="password" type="password" name="password">

                @error('password')
                    <strong>{{ $message }}</strong>
                @enderror
        </p>

        <div>
            <button type="submit" class="btn btn-primary">
                {{ __('Login') }}
            </button>
        </div>
    </form>
                
@endsection
