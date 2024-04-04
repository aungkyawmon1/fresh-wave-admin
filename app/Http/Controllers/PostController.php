<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use ImgBB\Client as ImgBBClient;
use GuzzleHttp\Client;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Response;
use DB;

class PostController extends Controller
{
    public function view() {
        if (!Auth::check()) {
            return redirect("login")->withSuccess('You are not allowed to access');
        }
        $posts = Post::where("status", 1)->paginate(5);
        return view('post.view')->with(compact('posts'));
    }

    public function add_form() {
        if (!Auth::check()) {
            return redirect("login")->withSuccess('You are not allowed to access');
        }
        return view('post.post_add');
    }

    public function uploadMagazine (Request $request) {
        $file = $request->file('img_file');
        $file1 = $request->file('doc_file');
    
        $user_id = auth()->user()->id;
        $department_id = auth()->user()->id;
        $filename = $file->getClientOriginalName();
        $filename1 = $file1->getClientOriginalName();
        $file->storeAs('public/uploads', $filename);
        $file->storeAs('public/uploads', $filename1);
        Magazine::create([
            'user_id' => $user_id,
            'department_id' => $department_id,
            'academic_year_id' => 1,
            'file_url' => $filename1,
            'image_url' => $filename
        ]);
    }

    public function convertDocToHtml() {
       /* //dd(public_path('storage/uploads/COMP 1787 Coursework 23-24 T2 (1).docx'));
        $phpWord = IOFactory::load(public_path('storage/uploads/proposal_version2.docx'));
        // Get the contents as HTML
        dd("hello");
    $html = '';
    foreach ($phpWord->getSections() as $section) {
        foreach ($section->getElements() as $element) {
            $html .= $element->getText();
        }
    }
    return view('post.preview', ['htmlContent' => $html]);*/
    $name = "proposal_version2.docx";
    $file = $file = public_path('storage/uploads/proposal_version2.docx');
    $mimeType = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
    $header = array(
        'Content-Type' => $mimeType,
        'Content-Disposition' => 'attachment',
        'Content-lenght' => filesize($file),
        'filename' => $name,
    );

    // auth code
    return Response::download($file, $name, $header);
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
        return redirect()->route('posts')->with('success','Article has been created successfully.');

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
        return redirect()->route('posts')->with('success', 'Article
         updated successfully');
    }

    public function delete($id) {
        DB::table('posts')->where('id', '=', $id)->delete();
        return redirect()->route('posts')->with('success', 'Article deleted successfully');
    }
}
