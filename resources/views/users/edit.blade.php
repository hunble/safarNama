@extends('layouts.app')

@section('content')

    <h1>Edit Profile</h1>
    {!! Form::open(['action' => ['UsersController@update', $user->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
		<div class="form-group">
			{{Form::label('anonymity', 'Anonymity')}}
			@if($user->anonymity=='true')
				{{Form::checkbox('anonymity[]',$user->anonymity, 1)}}
			@else
				{{Form::checkbox('anonymity[]',$user->anonymity, 0)}}			
			@endif
        </div>
		<div class="form-group">
            {{Form::label('name', 'Name')}}
            {{Form::text('name', $user->name, ['class' => 'form-control', 'placeholder' => 'Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('email', 'Email')}}
            {{Form::email('email', $user->email, ['class' => 'form-control', 'placeholder' => 'Email'])}}
        </div>        
        <div class="form-group">
            {{Form::label('password', 'Password')}}
            {{Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password' , 'min' => '8'])}}
        </div>
		{{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection