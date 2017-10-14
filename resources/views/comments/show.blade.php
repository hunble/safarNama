<div class="container">
<h2>Comments</h2>
@if(count($comments) > 0)
	@foreach($comments as $comment)
		<div class="well">
			<div class="row">
				<p>{!!$comment->body!!}</p><hr>
				<small>By {{$comment->Commenter}} on {{$comment->created_at}}</small>
				@if(!Auth::guest())
					@if(auth()->user()->is_admin == true)
						{!!Form::open(['action' => ['CommentsController@destroy', $comment->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
							{{Form::hidden('_method', 'DELETE')}}
							{{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
						{!!Form::close()!!}
					@endif
				@endif
			</div>            
		</div>
	@endforeach
@else
	<p>No comments found</p>
@endif
</div>
