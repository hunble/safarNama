<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

//Cloudinary Admin API
require "Utility\cloudinary_php-master\src\cloudinary.php";
require "Utility\cloudinary_php-master\src\api.php";

use App\CloudinaryRes;
use App\Post;
use App\User;
class CloudinaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

		\Cloudinary::config(array( 
			"cloud_name" => "hmxs40u75", 
			"api_key" => "818238713846353", 
			"api_secret" => "NeP1iDcZSQihpWGD-g0XMwbnkUA" 
		));



		$api = new \Cloudinary\Api();
		return array($api->resources(),$api->resources(array("resource_type" => "video")));
		return $result;
		
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$cloudinary = CloudinaryRes::find($id);
		$post = Post::find($cloudinary->post_id);
		
		// Check for correct user
        if(auth()->user()->id !==$post->user_id){
			if(auth()->user()->is_admin !== true){
				return redirect('/posts')->with('error', 'Unauthorized Page');
			}
        }
		
		\Cloudinary::config(array( 
			"cloud_name" => "hmxs40u75", 
			"api_key" => "818238713846353", 
			"api_secret" => "NeP1iDcZSQihpWGD-g0XMwbnkUA" 
		));
		
		$api = new \Cloudinary\Api();
		$api->delete_resources(array($cloudinary->public_id), array("resource_type" => $cloudinary->resource_type));	

		
		$cloudinary->delete();
		return redirect('/posts')->with('success','Resource Successfully Deleted');
    }
}
