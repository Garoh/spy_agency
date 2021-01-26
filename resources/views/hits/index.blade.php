@extends('layouts.app')

@section('content')
	<h1>Hits</h1>

	<p>
		{{ $created }}
		{{ $updated }}
	</p>

	@if(Auth::user()->type != 3)
		<p>
			<a href="{{ route('hits.create') }}">Create</a>	
			 | 
			<a href="{{ route('hits.bulk') }}">Bulk</a>	
		</p>
	@endif	

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