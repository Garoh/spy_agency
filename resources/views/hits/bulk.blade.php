@extends('layouts.app')

@section('content')
	<h1>Hits Bulk</h1>

	<p>
		{{ $created }}
	</p>

	<form action="{{ route('hits.bulkGenerate') }}" method="post">
		@csrf

		<p>
			Hitman
			<select name="id_user_assigned">
                @foreach($hitmens as $hitmen)
                    <option value="{{ $hitmen->id }}">
                        {{ $hitmen->name }}
                    </option>
                @endforeach
            </select>

			
		</p>

		<table style="width: 100%;" border="1">
			<tr>
				<th></th>
				<th>Hitmen</th>
				<th>Target</th>
				<th>Status</th>
			</tr>

			@foreach($model as $row)
				<tr>
					<td>
						<input type="checkbox" name="check[]" value="{{ $row->id }}">
					</td>
					<td>{{ $row->assigned->name }}</td>
					<td>{{ $row->target }}</td>
					<td>{{ $row->getStatus() }}</td>
				</tr>
			@endforeach
		</table>

		<p>
			<button type="submit">Bulk</button>
		</p>
	</form>
@endsection