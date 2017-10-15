@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-default">Go Back</a>
	@if(!Auth::guest())
	@if(Auth::user()->id == $post->user_id)
		<a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a>
	@endif
	@if(Auth::user()->id == $post->user_id || Auth::user()->is_admin == true)

		{!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
			{{Form::hidden('_method', 'DELETE')}}
			{{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
		{!!Form::close()!!}
	@endif
	@endif
	<div class='row container'>
		<hr>
		<div class="col-md-2">
			<img class="img-thumbnail img-circle" width="100%" src="{{$post->cover_image}}" >
		</div>
		<div class="col-md-10">
			<h1>{{$post->title}}</h1>
			<h5>{{$post->destination}}</h5>
			<h6>{{$post->location}}</h6>
		</div>
	</div><hr>
	<div class="row">
		<div class="col-md-4 well">	
				{!!$post->body!!}
		</div>
		<div class="col-md-8">
			@include('cloudinaryRes.show')
		</div>
	</div>
    <hr>
    <small>Written on {{$post->created_at}} by {{$post->user->public_name}}</small>
	<hr>
	<div class='row'>
		<div class='col-md-6'>
			@include('comments.show')
		</div>
		<div class='col-md-6'>
			@include('comments.create')
		</div>
	</div>
	
@endsection