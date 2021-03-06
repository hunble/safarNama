<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Post;
use App\Comment;
use App\CloudinaryRes;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function __construct()
    {
        $this->middleware('auth',['except' => ['index', 'show']]);
    }
    public function index()
    {
		
		// Check for correct user
        if(auth()->user()->is_admin !== true ){
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }
		
		$users = User::orderBy('created_at','desc')->paginate(10);		
		return view('users.index')->with('users',$users);
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$user = auth()->user();
		// Check for correct user
        if(auth()->user()->id != $id){ 
			return redirect('/home')->with('error', 'Unauthorized Page');
        }

		return view('users.edit')->with('user',$user);
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
		$user = auth()->user();
		// Check for correct user
        if(auth()->user()->id != $id){ 
			return redirect('/home')->with('error', 'Unauthorized Page');
        }
		
		$this->validate($request,[
	        'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255'
		]);
		
		if($request->input('email')!=auth()->user()->email)
		{
			$this->validate($request,[

            'email' => 'unique:users'
		]);
		}

        $user = User::find($id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
		if($request->has('anonymity'))
		{
			$user->anonymity = true;
			$user->public_name = 'Anonymus User';
		}
		else
		{
			$user->anonymity = false;
			$user->public_name = $request->input('name');
		}
		
		if($request->input('password')!=''){
			$this->validate($request,[
				'password' => 'string|min:6',
			]);
			$user->password = bcrypt($request->input('password'));
		}
		$user->save();

		return redirect('/users/'.$id.'/edit')->with('success','Profile Updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$user = User::find($id);
		// Check for correct user
        if(auth()->user()->is_admin !== true ){
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }

		//Delete Res form Cloudinary
		\Cloudinary::config(array( 
			"cloud_name" => "hmxs40u75", 
			"api_key" => "658451473127219", 
			"api_secret" => "LrubYx1Dk9PZ45AxpFvZ61ynt_I" 
		));
		
		$posts =Post::where('user_id',$id)->get();
		foreach ($posts as $post)
		{
		    if($post->cover_public_id != 'cover_images/no-image_e4gwqf'){
				// Delete Image
				$api = new \Cloudinary\Api();
				$api->delete_resources(array($post->cover_public_id), array("resource_type" => 'image'));
			}		
		
			Comment::where('post_id', $post->id)->delete();
		
				
			$api = new \Cloudinary\Api();
			$cRes = CloudinaryRes::where('post_id', $post->id)->get();

			
			foreach ($cRes as $cr)
			{
				$api->delete_resources(array($cr->public_id), array("resource_type" => $cr->resource_type));	
			}

		
			CloudinaryRes::where('post_id', $post->id)->delete();
		}
		
		Post::where('user_id',$id)->delete();
		$user->delete();
		return redirect('/users')->with('success','User Deleted');
	}
}
