<h3>Create Comment</h3>
{!! Form::open(['action' => 'CommentsController@store', 'method' => 'POST']) !!}
	<div class="form-group">
		{{Form::label('Commenter', 'Commentator\'s Name')}}
		@if(!Auth::guest())
			{{Form::text('Commenter', Auth::user()->name, ['class' => 'form-control', 'placeholder' => 'Your Name'])}}
		@else
			{{Form::text('Commenter', '', ['class' => 'form-control', 'placeholder' => 'Your Name'])}}
		@endif
	</div>
	<div class="form-group">
		{{Form::label('body', 'Body')}}
		{{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Your Toughts'])}}
	</div>
	{{ Form::hidden('post_id', $post->id) }}
	{{Form::submit('Submit', ['class'=>'btn btn-primary pull-right'])}}
{!! Form::close() !!}