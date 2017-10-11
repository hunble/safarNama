<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/png" href="http://bloomingfounders.com/wp-content/uploads/2015/09/cropped-favicon.jpg"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
		@include('inc.navbar')
		<div class='container'>
            @include('inc.messages')
			@yield('content')
		</div>
    </div>
	
    <!-- Scripts -->
    <script src="{{ secure_asset('js/app.js') }}"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'article-ckeditor' );
    </script>	

	<!--Cloudinary-->
	<script src="//widget.cloudinary.com/global/all.js" type="text/javascript"> </script>
	<script>
	  cloudinary.setCloudName('hmxs40u75');
	</script>
	<script type="text/javascript"> 
	cloudinary.applyUploadWidget(document.getElementById('upload_widget_opener'), 
	  { upload_preset: 'aodkpzx9' }, 
	  function(error, result) {console.log(error, result)
		for (i = 0; i < result.length; i++) { 
			Added_Resources = document.getElementById('Added_Resources');
			
			var res = document.createElement("input");
			res.setAttribute("value",result[i]['secure_url']);
			res.setAttribute("name", "res[]");
			res.setAttribute("type", "hidden")
			Added_Resources.appendChild(res);
			
			Added_Resources_public_id = document.getElementById('Added_Resources_public_id');
			
			var res = document.createElement("input");
			res.setAttribute("value",result[i]['public_id']);
			res.setAttribute("name", "res_public_id[]");
			res.setAttribute("type", "hidden")
			Added_Resources_public_id.appendChild(res);

			Added_Resources_resource_type = document.getElementById('Added_Resources_resource_type');
			
			var res = document.createElement("input");
			res.setAttribute("value",result[i]['resource_type']);
			res.setAttribute("name", "res_resource_type[]");
			res.setAttribute("type", "hidden")
			Added_Resources_resource_type.appendChild(res);
			
		}
	  
	  });
	</script>
	
</body>
</html>
