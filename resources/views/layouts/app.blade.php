<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/png" href="http://bloomingfounders.com/wp-content/uploads/2015/09/cropped-favicon.jpg"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Travelly') }}</title>

    <!-- Styles -->
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">

	<style>
	body { 
	background: url('http://ringvemedia.com/server/bg.jpg') no-repeat center center fixed; 
	  -webkit-background-size: cover;
	  -moz-background-size: cover;
	  -o-background-size: cover;
	  background-size: cover;
	}
	</style>
	@include('inc.enlarge_image')
</head>
<body >
    <div id="app">
		@include('inc.navbar')
		<div class='container'>
            @include('inc.messages')
			@yield('content')
		</div>
    </div>
	
    <!-- Scripts -->
    <script src="{{secure_asset('js/app.js') }}"></script>
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
	  { upload_preset: 'res_uploads', theme: 'minimal',sources: ['local'] , button_caption: 'Upload Images and video Resources', button_class: 'btn btn-primary'}, 
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
	// Get the modal
	var modal = document.getElementById('myModal');

	// Get the image and insert it inside the modal - use its "alt" text as a caption
	var img = document.getElementById('myImg');
	var modalImg = document.getElementById("img01");
	var captionText = document.getElementById("caption");

	function enlarge(x)
	{
		modal.style.display = "block";
		modalImg.src = x.src;
		captionText.innerHTML = x.alt;
	}
	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() { 
	modal.style.display = "none";
	}
	//Post Search Functionality
	function showResult(str) {
	  if (str.length==0) { 
		document.getElementById("list_suggestions").innerHTML="";
		option = document.createElement('OPTION');
		option.setAttribute('value',"Loading...");
		option.setAttribute('label',"abcdefghijklmopqrestuvwnyz");
		document.getElementById("list_suggestions").appendChild(option);
		return;
	  }
		document.getElementById("list_suggestions").innerHTML="";
		option = document.createElement('OPTION');
		option.setAttribute('value',"Loading...");
		option.setAttribute('label',"abcdefghijklmopqrestuvwnyz");
		document.getElementById("list_suggestions").appendChild(option);
	  if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	  } else {  // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  xmlhttp.onreadystatechange=function() {
		if (this.readyState==4 && this.status==200) {
			list_suggestion = document.getElementById("list_suggestions");
			list_suggestion.innerHTML='';
			suggestions=JSON.parse(this.responseText)
			i=0;
			suggestions.forEach(function(suggestion){
				i++;
				option = document.createElement('OPTION');
				link = window.location.origin+'/posts/'+suggestion['id'];
				option.setAttribute('value',link);
				option.setAttribute('label',suggestion['title']);
				list_suggestion.appendChild(option);

			});
			if(i==0)
			{
				document.getElementById("list_suggestions").innerHTML="";
				option = document.createElement('OPTION');
				option.setAttribute('value',"No Result Found");
				option.setAttribute('label',"abcdefghijklmopqrestuvwnyz");
				document.getElementById("list_suggestions").appendChild(option);
			}
				console.log(list_suggestion)
		}
	  }
	  xmlhttp.open("GET",window.location.origin+"/search/"+str,true);
	  xmlhttp.send();
	}

	
	</script>
</body>
</html>
