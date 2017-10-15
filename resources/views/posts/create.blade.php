@extends('layouts.app')

@section('content')

<script src='//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>


    <a href="/home" class="btn btn-default">Go Back</a><hr>
    <h1>Create Post</h1>
    {!! Form::open(['action' => 'PostsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('title', 'Title')}}
            {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}
        </div>
        <div class="form-group">
            {{Form::label('destination', 'Destination')}}
            {{Form::text('destination', '', ['class' => 'form-control', 'placeholder' => 'Destination'])}}
        </div>
        <div class="form-group">
            {{Form::label('location', 'Location')}}
            {{Form::text('location', '', ['class' => 'form-control', 'placeholder' => 'location'])}}
        </div>
        <div class="form-group">
            {{Form::label('body', 'Body')}}
            {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body Text'])}}
        </div>
        <div class="form-group well">
            {{Form::label('cover_image', 'Cover Image')}}
			{{Form::file('cover_image')}}
        </div>
		<div class="form-group well">
			<hr>
			{{Form::label('pv_Res', 'Upload Video and Photo Resources')}}
			<br>
			<a href="#" id="upload_widget_opener">Upload multiple images</a>
		</div>
		<div id="Added_Resources">
		</div>
		<div id="Added_Resources_public_id">
		</div>		
		<div id="Added_Resources_resource_type">
		</div>
        {{Form::submit('Submit', ['class'=>'btn btn-primary pull-right'])}}
    {!! Form::close() !!}

@endsection