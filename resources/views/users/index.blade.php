@extends('layouts.app')

@section('content')
	<h1>Users</h1>

	<p>
		{{ $created }}
		{{ $updated }}
	</p>

	<table style="width: 100%;" border="1">
		<tr>
			<th>Name</th>
			<th>Email</th>
			<th>Type</th>
			<th>Status</th>
			<th>Actions	</th>
		</tr>

		@foreach($model as $row)
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
@endsection