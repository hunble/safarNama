@extends('layouts.app')

@section('content')
    <a href="/home" class="btn btn-default">Go Back</a><hr>
	<div class="row">
		<div class="col-md-6">
			<h1>Edit Post</h1>
			{!! Form::open(['action' => ['PostsController@update', $post->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
				<div class="form-group">
					{{Form::label('title', 'Title')}}
					{{Form::text('title', $post->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}
				</div>
				<div class="form-group">
					{{Form::label('destination', 'Destination')}}
					{{Form::text('destination', $post->destination, ['class' => 'form-control', 'placeholder' => 'Destination'])}}
				</div>
				<div class="form-group">
					{{Form::label('location', 'Location')}}
					{{Form::text('location', $post->location, ['class' => 'form-control', 'placeholder' => 'location'])}}
				</div>
				<div class="form-group">
					{{Form::label('body', 'Body')}}
					{{Form::textarea('body', $post->body, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body Text'])}}
				</div>
				<div class="form-group well">
					{{Form::label('cover_Image', 'Upload Cover Image')}}
					{{Form::file('cover_image')}}
				</div>
				<div class="form-group well">
					<a href="#" id="upload_widget_opener">Upload multiple images</a>
				</div>
				<div id="Added_Resources">
				</div>
				<div id="Added_Resources_public_id">
				</div>
				<div id="Added_Resources_resource_type">
				</div>
				
				{{Form::hidden('_method','PUT')}}
				{{Form::submit('Submit', ['class'=>'btn btn-primary pull-right'])}}
			{!! Form::close() !!}
		</div>
		<div class="col-md-6">
			<!--Images from Cloudinary-->
			@include('cloudinaryRes.edit')
		</div>
	</div>
@endsection