@extends('layouts.app')

@section('content')
    <h1>Registered Users</h1>
    @if(count($users) > 0)
	<div class="row">
        @foreach($users as $user)
		<div class="col-md-4">
	
            <div class="well">
                <div class="row">
					<h3>{{$user->name}}</h3>
					<h2>{{$user->email}}</h2>
					<small>Registed on {{$user->created_at}}</small>
					<hr>
					{!!Form::open(['action' => ['UsersController@destroy', $user->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
						{{Form::hidden('_method', 'DELETE')}}
						{{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
					{!!Form::close()!!}
                </div>
            </div>
		</div>
        @endforeach
        {{$users->links()}}
    <d/iv>
	@else
        <p>No users found</p>
    @endif
@endsection