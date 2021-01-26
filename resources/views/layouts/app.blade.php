<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

</head>
<body>
    <div id="app">
            
        <div style="display: flex; justify-content: space-between; width: 30%; margin: auto; margin-bottom: 50px">   
            @guest
                <a href="{{ route('login') }}">Login</a>
                
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @else
                <a href="{{ route('hits.index') }}">Hits</a>

                @if(Auth::user()->type != 3)
                    <a href="{{ route('users.index') }}">Users</a>
                @endif

                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit">Exit</button>
                </form>
            @endguest
        </div>

        <main style="width: 70%; margin: auto;">
            @yield('content')
        </main>
    </div>
</body>
</html>
