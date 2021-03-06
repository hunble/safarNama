<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Post;
use App\Comment;
use App\CloudinaryRes;

//Cloudinary Admin API
//require "Utility\cloudinary_php-master\src\Cloudinary.php";
//require "Utility\cloudinary_php-master\src\Api.php";

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	 
    public function __construct()
    {
        $this->middleware('auth',['except' => ['index', 'show', 'search']]);
    }

    public function index()
    {
		$posts = Post::orderBy('created_at','desc')->paginate(6);
		
		return view('posts.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$this->validate($request,[
			'title' => 'required',
			'body' => 'required',
			'destination' => 'required',
			'location' => 'required',
			'cover_image' => 'image|nullable|max:1999'
		]);
	
	
	
	
        // Handle File Upload
        if($request->hasFile('cover_image')){
			//Hnadle Cove image
			\Cloudinary::config(array( 
			"cloud_name" => "hmxs40u75", 
			"api_key" => "658451473127219", 
			"api_secret" => "LrubYx1Dk9PZ45AxpFvZ61ynt_I" 
		));
			
			$fileNameToStore = \Cloudinary\Uploader::upload($request->file('cover_image'),array ('upload_preset'=>'cover_images'));
        } else {
			$fileNameToStore = array('secure_url'=>'https://res.cloudinary.com/hmxs40u75/image/upload/v1507740979/cover_images/no-image_e4gwqf.jpg','public_id'=>'cover_images/no-image_e4gwqf'); 
		}

		
		$post = new Post;
		$post->title = $request->input('title');
		$post->body = $request->input('body');
		$post->destination = $request->input('destination');
		$post->location = $request->input('location');
		$post->user_id = auth()->user()->id;
		$post->cover_image = $fileNameToStore['secure_url'];
		$post->cover_public_id = $fileNameToStore['public_id'];
		$post->save();

		//Enter Cloudinary ressource
		if($request->has('res')&&$request->has('res_public_id')&&$request->has('res_resource_type'))
		{
			$adress = $request->input('res');
			$res_public_id = $request->input('res_public_id');
			$res_resource_type = $request->input('res_resource_type');
			$i=0;
			foreach (array_combine($res_public_id,$adress) as $pub => $adr)	
			{
				$res_type = $res_resource_type[$i++];
				$res = new CloudinaryRes;
				$res->post_id = $post->id;  
				$res->resURL = $adr;
				$res->public_id = $pub;
				$res->resource_type = $res_type;
				$res->save();
			}
		}


		
		return redirect('/posts')->with('success','Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
		$comments = Comment::where('post_id',$id)->get();
		$cloudinaryRes = CloudinaryRes::where('post_id',$id)->get();
	
		//return $cloudinaryRes;
		return view('posts.show')->with(['post'=>$post,'comments'=>$comments,'cloudinaryRes'=>$cloudinaryRes]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
		$cloudinaryRes = CloudinaryRes::where('post_id',$id)->get();
		
		// Check for correct user
        if(auth()->user()->id !==$post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }

		return view('posts.edit')->with(['post'=>$post,'cloudinaryRes'=>$cloudinaryRes]);

	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		if(set_time_limit ( 20 )){}
		else return "max time not set";
		$this->validate($request,[
			'title' => 'required',
			'body' => 'required',
			'destination' => 'required',
			'location' => 'required',
			'cover_image' => 'image|nullable|max:1999'
		]);
		
				
        // Handle File Upload
        if($request->hasFile('cover_image')){
			//Hnadle Cove image
		\Cloudinary::config(array( 
			"cloud_name" => "hmxs40u75", 
			"api_key" => "658451473127219", 
			"api_secret" => "LrubYx1Dk9PZ45AxpFvZ61ynt_I" 
		));
			
			$fileNameToStore = \Cloudinary\Uploader::upload($request->file('cover_image'),array ('upload_preset'=>'cover_images'));
        } else {
			$fileNameToStore = array('secure_url'=>'https://res.cloudinary.com/hmxs40u75/image/upload/v1507743142/cover_images/no-image_c4wiya.jpg','public_id'=>'cover_images/no-image_c4wiya'); 
		}


		// Create Post
        $post = Post::find($id);

        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->destination = $request->input('destination');
        $post->location = $request->input('location');
        if($request->hasFile('cover_image')){
			if($post->cover_cover_public_id != 'cover_images/no-image_e4gwqf'){
				// Delete Image
				$api = new \Cloudinary\Api();
				$api->delete_resources(array($post->cover_public_id), array("resource_type" => 'image'));
			}
			$post->cover_image = $fileNameToStore['secure_url'];
			$post->cover_public_id = $fileNameToStore['public_id'];
		}
        $post->save();
		
		//Enter Cloudinary ressource
		if($request->has('res')&&$request->has('res_public_id')&&$request->has('res_resource_type'))
		{
			$adress = $request->input('res');
			$res_public_id = $request->input('res_public_id');
			$res_resource_type = $request->input('res_resource_type');
			$i=0;
			foreach (array_combine($res_public_id,$adress) as $pub => $adr)	
			{
				$res_type = $res_resource_type[$i++];
				$res = new CloudinaryRes;
				$res->post_id = $post->id;  
				$res->resURL = $adr;
				$res->public_id = $pub;
				$res->resource_type = $res_type;
				$res->save();
			}
		}
		
		return redirect('/posts/'.$post->id.'/edit')->with('success','Post Updated');
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$post = Post::find($id);
		// Check for correct user
        if(auth()->user()->id !==$post->user_id){
			if(auth()->user()->is_admin !== true){
				return redirect('/posts')->with('error', 'Unauthorized Page');
			}
        }

		//Delete Res form Cloudinary
		\Cloudinary::config(array( 
			"cloud_name" => "hmxs40u75", 
			"api_key" => "658451473127219", 
			"api_secret" => "LrubYx1Dk9PZ45AxpFvZ61ynt_I" 
		));
	
		
        if($post->cover_public_id != 'cover_images/no-image_e4gwqf'){
            // Delete Image
			$api = new \Cloudinary\Api();
		
			$api->delete_resources(array($post->cover_public_id), array("resource_type" => 'image'));
        }		
		
		Comment::where('post_id', $id)->delete();
		
				
		$api = new \Cloudinary\Api();

		$cRes = CloudinaryRes::where('post_id', $id)->get();

		
		foreach ($cRes as $cr)
		{
			$api->delete_resources(array($cr->public_id), array("resource_type" => $cr->resource_type));	
		}

		
		CloudinaryRes::where('post_id', $id)->delete();

		$post->delete();
		return redirect('/posts')->with('success','Post Deleted');
    }
	
	
	//Search for post    
	public function search($q)
	{
		
		return $posts = Post::whereRaw('LOWER(title) like ?', '%' .$q. '%')->get();
	}
}
