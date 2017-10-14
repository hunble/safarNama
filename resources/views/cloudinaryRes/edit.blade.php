<!--Images from Cloudinary-->
<div class="row">
	<h2>Manage Photos and Videos</h2>
	<div class="well">
		<div class="row">
		@if(count($cloudinaryRes) > 0)
			@foreach($cloudinaryRes as $cRes)
				@if (strpos($cRes,"image")!== false)
					<div class="col-md-4">
						{!!Form::open(['action' => ['CloudinaryController@destroy', $cRes->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
							{{Form::hidden('_method', 'DELETE')}}
							{{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
						{!!Form::close()!!}<hr>
						<img src="{{$cRes->resURL}}" width="100%"></img><hr>
					</div>            
				@elseif(strpos($cRes,"video")!== false)
					<div class="col-md-4">
						{!!Form::open(['action' => ['CloudinaryController@destroy', $cRes->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
							{{Form::hidden('_method', 'DELETE')}}
							{{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
						{!!Form::close()!!}<hr>
						<video width="100%" controls autoplay>
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