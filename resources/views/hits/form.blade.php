@extends('layouts.app')

@section('content')

    <h1>{{ $title }} Hit</h1>

    <form method="POST" 
        action="@if($readonly == '') {{ route('hits.store') }} @else  {{ route('hits.update', $model->id) }} @endif">
        @csrf

        @if($readonly != '')
            <input type="hidden" name="_method" value="put">
        @endif

        <p>
            <label for="id_user_assigned">{{ __('Hitman') }}</label>
            
            @if($readonly != '')

                @if($model->status == 0 && Auth::user()->type != 3)
                    <select name="id_user_assigned">
                        @foreach($hitmens as $hitmen)
                            <option value="{{ $hitmen->id }}"
                                @if($model->id_user_assigned == $hitmen->id) selected @endif>
                                {{ $hitmen->name }}
                            </option>
                        @endforeach
                    </select>
                    @else
                        : {{ $model->assigned->name }} 
                @endif


                @else
                    <select name="id_user_assigned">
                        @foreach($hitmens as $hitmen)
                            <option value="{{ $hitmen->id }}"
                                @if($model->id_user_assigned == $hitmen->id) selected @endif>
                                {{ $hitmen->name }}
                            </option>
                        @endforeach
                    </select>
            @endif

            @error('id_user_assigned')
                    <strong>{{ $message }}</strong>
            @enderror
        </p>

        <p>
            <label for="description">{{ __('Description') }}</label>

            <input id="description" type="text" name="description" value="{{ $model->description }}" 
                autocomplete="description" autofocus {{ $readonly }}>

            @error('description')
                    <strong>{{ $message }}</strong>
            @enderror
        </p>

        <p>
            <label for="target">{{ __('Target') }}</label>

            <input id="target" type="text" name="target" value="{{ $model->target }}" 
                autocomplete="target" autofocus {{ $readonly }}>

            @error('target')
                    <strong>{{ $message }}</strong>
            @enderror
        </p>

        @if($readonly != '')
            <p>
                <label for="id_user_creator">{{ __('Creator') }}</label>

                <input id="id_user_creator" type="text" name="id_user_creator" value="{{ $model->creator->name }}" 
                    autocomplete="id_user_creator" autofocus {{ $readonly }}>

                @error('id_user_creator')
                        <strong>{{ $message }}</strong>
                @enderror
            </p>
        @endif


        @if($readonly == '')
            <div>
                <button type="submit">
                    {{ __('Create') }}
                </button>
            </div>
        @endif

        @if($readonly != '')
            @if(Auth::user()->type == 3 && $model->status == 0)
                <p>
                    <input type="radio" id="failed" name="status" value="1">
                    <label for="failed">Failed</label><br>
                    <input type="radio" id="completed" name="status" value="2">
                    <label for="completed">Completed</label><br>
                </p>
                @else
                    Status: {{ $model->getStatus() }}
            @endif

            <div>
                <button type="submit">
                    {{ __('Update') }}
                </button>
            </div>
        @endif
    </form>
@endsection