@extends('layouts.app')

@section('content')
	<h1>Hits</h1>

	<p>
		{{ $created }}
		{{ $updated }}
	</p>
	<p>
		<a href="{{ route('hits.create') }}">Create</a>	
	</p>

	<table style="width: 100%;" border="1">
		<tr>
			<th>Hitmen</th>
			<th>Target</th>
			<th>Status</th>
			<th>Actions	</th>
		</tr>

		@foreach($model as $row)
			<tr>
				<td>{{ $row->assigned->name }}</td>
				<td>{{ $row->target }}</td>
				<td>{{ $row->getStatus() }}</td>
				<td>
					<a href="{{ route('hits.show', $row->id) }}">Show</a>
				</td>
			</tr>
		@endforeach
	</table>
@endsection