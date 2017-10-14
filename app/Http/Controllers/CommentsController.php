<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth',['except' => ['index', 'show','store']]);
    }

	 
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('comments.create');
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
			'Commenter' => 'required',
			'body' => 'required',
			'post_id' => 'required'
		]);
		$comment = new Comment;
		$comment->Commenter = $request->input('Commenter');
		$comment->body = $request->input('body');
		$comment->post_id = $request->input('post_id');
		$comment->save();
		
		return redirect('/posts/'.$comment->post_id)->with('success','Comment Posted');    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = Comment::where('post_id',$id)->get();
		return $comment;
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
		$comment = Comment::find($id);
		// Check for correct user
        if(auth()->user()->is_admin !== true){
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }
		
		$comment->delete();
		return redirect('/posts')->with('success','Comment Deleted');
    }

}
