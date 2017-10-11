@extends('layouts.app')

@section('content')
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
        <div class="form-group">
            {{Form::file('cover_image')}}
        </div>
		<div class="form-group">
			<a href="#" id="upload_widget_opener">Upload multiple images</a>
		</div>
		<div id="Added_Resources">
		</div>
		<div id="Added_Resources_public_id">
		</div>
		<div id="Added_Resources_resource_type">
		</div>
		
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
	
		<!--Images from Cloudinary-->
	<div class="row">
		<h2>Photos Album</h2>
		<div class="well">
			<div class="row">
			@if(count($cloudinaryRes) > 0)
				@foreach($cloudinaryRes as $cRes)
					@if (strpos($cRes,"image")!== false)
						<div class="col-md-6">
							<img src="{{$cRes->resURL}}" height="400" width="400"></img><hr>
							{!!Form::open(['action' => ['CloudinaryController@destroy', $cRes->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
								{{Form::hidden('_method', 'DELETE')}}
								{{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
							{!!Form::close()!!}<br><br>
						</div>            
					@elseif(strpos($cRes,"video")!== false)
						<div class="col-md-6">
							<video width="400" height="400" controls autoplay>
								<source src="{{$cRes->resURL}}" type="video/mp4">
							</video><hr>
							{!!Form::open(['action' => ['CloudinaryController@destroy', $cRes->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
								{{Form::hidden('_method', 'DELETE')}}
								{{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
							{!!Form::close()!!}<br><br>
						</div>            
					@endif
				@endforeach
			@else
				<p>No Album found</p>
			@endif	
			</div>
		</div>
	</div>


	
@endsection