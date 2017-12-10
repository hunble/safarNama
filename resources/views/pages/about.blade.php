@extends('layouts.app')

@section('content')
	<div class="title m-b-md">
		About
	<div>
	<div class="well">
		<p><strong>Cloud Computing Assignment, Fall 2017</strong><br />
			General Instructions:<br />
			➔ The project is to be done in Heroku PAAS.<br />
			Objective:</p>

			<ul>
				<li>To be able to create, deploy and run a web application in PAAS. We will be using Heroku as PAAS provider.</li>
				<li>To be able to use Database, Picture and Video upload a service.</li>
			</ul>

			<p><br />
			Tasks:</p>

			<ul>
				<li>Create a web application in which traveller can register and update his/her profile.</li>
				<li>The traveller should be able to enter the destination Name and location where he/she is going.</li>
				<li>The traveller should be able to upload pictures.</li>
				<li>The traveller should be able to upload videos.</li>
				<li>The traveller&#39;s personal information should be kept hidden, while pictures and videos should be displayed to everyone on the web long with name and location of the destination\tourist spot.</li>
				<li>&nbsp;If the traveller wishes then he/she can allow his/her name to be shown in public along with pictures and videos.</li>
				<li>Unregistered users should be able to comments on the pictures or videos.</li>
				<li>Admin should be able to delete a registered user and the content uploaded by that person.</li>
				<li>Admin should also be able to delete comments for any item.</li>
			</ul>

			<p>Note:</p>

			<ol>
				<li>Use Postgres DB as a service for this project.</li>
				<li>You can use any addon in Heroku, to give picture upload and video functionality.</li>
			</ol>

	<div>
@endsection

