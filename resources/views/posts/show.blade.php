@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-default">Go Back</a>
    <h1>{{$post->title}}</h1>
	<div class='row'>
		<div class="col-md-6">
			<img style="width:100%" src="/storage/cover_images/{{$post->cover_image}}">
			<br>
			<br>
		</div>
		<div class="col-md-6">
			{!!$post->body!!}
		</div>
	</div>
	<!--Images from Cloudinary-->
	<div class="row">
		<h2>Photos Album</h2>
		<div class="well">
			<div class="row">
			@if(count($cloudinaryRes) > 0)
				@foreach($cloudinaryRes as $cRes)
					@if (strpos($cRes,"image")!== false)
						<div class="col-md-6">
							<img src="{{$cRes->resURL}}"></img>
						</div>            
					@elseif(strpos($cRes,"video")!== false)
						<div class="col-md-6">
							<video controls>
								<source src="{{$cRes->resURL}}" type="video/mp4">
							</video>
						</div>            
					@endif
				@endforeach
			@else
				<p>No Album found</p>
			@endif	
			</div>
		</div>
	</div>

    <hr>
    <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
    <hr>
    @if(!Auth::guest())
        @if(Auth::user()->id == $post->user_id)
            <a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a>

            {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif
    @endif

	<h2>Comments</h2>
    @if(count($comments) > 0)
        @foreach($comments as $comment)
            <div class="well">
				<div class="row">
					<h4>{{$comment->Commenter}}</h4>
					<small>on {{$post->created_at}}</small>
					<hr>
					<p>{!!$comment->body!!}</p>
				</div>            
			</div>
        @endforeach
    @else
        <p>No posts found</p>
    @endif
	
    <h3>Create Comment</h3>
    {!! Form::open(['action' => 'CommentsController@store', 'method' => 'POST']) !!}
        <div class="form-group">
            {{Form::label('Commenter', 'Commentator\'s Name')}}
            {{Form::text('Commenter', '', ['class' => 'form-control', 'placeholder' => 'Your Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('body', 'Body')}}
            {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Your Toughts'])}}
        </div>
		{{ Form::hidden('post_id', $post->id) }}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
	
	
@endsection