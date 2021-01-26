@extends('layouts.app')

@section('content')

    <h1>User</h1>

    <form method="POST" action="{{ route('users.update', $model->id) }}">
        @csrf

    <input type="hidden" name="_method" value="put">

        @if($model->active == 1 && $model->type == 3 && Auth::user()->id == 1)
            <p>
                <label for="id_user_manager">{{ __('Manager') }}</label>
                
                        <select name="id_user_manager">
                            @foreach($managers as $manager)
                                <option value="{{ $manager->id }}"
                                    @if($model->id_manager == $manager->id) selected @endif>
                                    {{ $manager->name }}
                                </option>
                            @endforeach
                        </select>

                @error('id_user_manager')
                        <strong>{{ $message }}</strong>
                @enderror
            </p>
        @endif

        <p>
            <label for="name">{{ __('Name') }}</label>: {{ $model->name }}
        </p>

        <p>
            <label for="email">{{ __('Email') }}</label>: {{ $model->email }}
        </p>

        <p>
            <label for="description">{{ __('Description') }}</label>: {{ $model->description }}
        </p>



        @if($model->active == 1)
            <p>
                <input type="radio" id="active" name="active" value="1">
                <label for="active">Active</label><br>
                <input type="radio" id="inactive" name="active" value="2">
                <label for="inactive">Inactive</label><br>
            </p>
            @else
                Status: {{ $model->active == 1 ? 'Active' : 'Inactive' }}
        @endif

        <div>
            <button type="submit">
                {{ __('Update') }}
            </button>
        </div>
    </form>


    @if(Auth::user()->id == 1)
        <h1>Lackeys</h1>

        <table style="width: 100%;" border="1">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Type</th>
                <th>Status</th>
                <th>Actions </th>
            </tr>

            @foreach($lackeys as $row)
                <tr>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->email }}</td>
                    <td>{{ $row->type == 2 ? 'Manager' : 'Hitman' }}</td>
                    <td>{{ $row->active == 1 ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <a href="{{ route('users.show', $row->id) }}">Show</a>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
@endsection