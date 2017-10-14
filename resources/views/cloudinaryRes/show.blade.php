<!--Images from Cloudinary-->
<div class="row">
	<!--<h2>Photos Album</h2>-->
	<div class="well">
		<div class="row">
		@if(count($cloudinaryRes) > 0)
			@foreach($cloudinaryRes as $cRes)
				@if (strpos($cRes,"image")!== false)
					<div class="col-md-6">
						<img id="myImg" onclick="enlarge(this)" alt="{{$cRes->public_id}}" src="{{$cRes->resURL}}" width="100%"></img><br><br>
					</div>            
				@elseif(strpos($cRes,"video")!== false)
					<div class="col-md-6">
						<video width="100%" controls autoplay>
							<source src="{{$cRes->resURL}}" type="video/mp4"><br><br>
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
