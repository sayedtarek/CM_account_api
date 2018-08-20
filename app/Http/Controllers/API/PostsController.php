<?php


namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Posts;
use  Validator;


class PostsController extends BaseController  
{

public function index()
{
    # code...
    $posts = Posts::all();
    return $this->sendResponse($posts->toArray(), 'posts read succesfully');
}


public function store(Request $request)
{
    # code...
    $input = $request->all();
    $validator =    Validator::make($input, [
    'name'=> 'required',
    'details'=> 'required' 
    ] );

    if ($validator -> fails()) {
        # code...
        return $this->sendError('error validation', $validator->errors());
    }

    $post = Posts::create($input);
    return $this->sendResponse($post->toArray(), 'post  created succesfully');
    
}






public function show(  $id)
{
    $post = Posts::find($id);
    if (   is_null($post)   ) {
        # code...
        return $this->sendError(  'post not found ! ');
    }
    return $this->sendResponse($post->toArray(), 'post read succesfully');
    
}



// update book 
public function update(Request $request , Posts $post)
{
    $input = $request->all();
    $validator =    Validator::make($input, [
    'name'=> 'required',
    'details'=> 'required' 
    ] );

    if ($validator -> fails()) {
        # code...
        return $this->sendError('error validation', $validator->errors());
    }
    $post->name =  $input['name'];
    $post->details =  $input['details'];
    $post->save();
    return $this->sendResponse($post->toArray(), 'Post  updated succesfully');
    
}





// delete book 
public function destroy(Posts $post)
{
 
    $post->delete();

    return $this->sendResponse($post->toArray(), 'post  deleted succesfully');
    
}



    
}

