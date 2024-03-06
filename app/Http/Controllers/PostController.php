<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use ImgBB\Client as ImgBBClient;
use GuzzleHttp\Client;

class PostController extends Controller
{
    public function view() {
        if (!Auth::check()) {
            return redirect("login")->withSuccess('You are not allowed to access');
        }
        $posts = Post::all();
        return view('post.view')->with("posts",$posts);
    }

    public function add_form() {
        if (!Auth::check()) {
            return redirect("login")->withSuccess('You are not allowed to access');
        }
        return view('post.post_add');
    }

    public function add(Request $request) {
        if (!Auth::check()) {
            return redirect("login")->withSuccess('You are not allowed to access');
        }
        //dd($request);
        $user_id = Auth::user()->id;
        //dd($request->file('image'));
        $imagePath = $request->file('image')->getRealPath();
    $result = $this->uploadToImgBB($imagePath);

    // Handle the response as needed
    $imageUrl = $result['data']['url'];
        
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);
        
        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $user_id,
            'image_url' => $imageUrl
        ]);
        return redirect()->route('posts')->with('success','Post has been created successfully.');

    }
    function uploadToImgBB($imagePath) 
    {
        $apiKey = "fc1d3c23237171d88a5838891eb8be03";
        $url = 'https://api.imgbb.com/1/upload';
        $client = new \GuzzleHttp\Client();
    
        $response = $client->post($url, [
            'multipart' => [
                [
                    'name' => 'key',
                    'contents' => $apiKey,
                ],
                [
                    'name' => 'image',
                    'contents' => fopen($imagePath, 'r'),
                ],
            ],
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function edit_form($id) {
        if (!Auth::check()) {
            return redirect("login")->withSuccess('You are not allowed to access');
        }
        $post = Post::find($id);
        return view('post.post_edit')->with("post", $post);
    }

    public function edit(Request $request) {
        Post::where("id", $request->id)->first()->update(array('title'=>$request->title, 'description'=>$request->description));
        return redirect()->route('posts')->with('success', 'Post
         updated successfully');
    }
}
