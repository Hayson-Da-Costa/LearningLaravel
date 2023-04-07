<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostFormRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$posts = DB::select('SELECT * FROM posts WHERE id = :id', [2]);
        // $posts = DB::table('posts')->get();

        /** Chunk method used for Retrieving Data */
        // Post::chunk(25, function($posts){
        //     foreach($posts as $post)
        //     {
        //         echo $post -> title . '<br>';
        //     }

        // });

        return view('blog.index',[
            'posts' => Post::orderBy('updated_at','desc')->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostFormRequest $request)
    {
        /** Code written without PostFormRequest */
        /* $request->validate([
            'title'       => 'required|unique:posts|max:255',
            'excerpt'     => 'required',
            'body'        => 'required',
            'image'       => ['required', 'memes:jpg,png,jpeg','max:5048'],
            'min_to_read' => 'min:0|max:60'
        ]); */

        $request->validated();

        Post::create([
            'title'        => $request->title,
            'excerpt'      => $request->excerpt,
            'body'         => $request->body,
            'min_to_read'  => $request->min_to_read,
            'image_path'   => $this->storeImage($request),
            'is_published' => $request->is_published === 'on'
        ]);

        return redirect( route('blog.index') );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       return view('blog.show', [
        'posts' => Post::findOrFail($id)
       ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('blog.edit',[
            'post' => Post::where('id', $id)->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostFormRequest $request, string $id)
    {
        // dd($request->all());
        // dd($request->except(['_token', '_method']));
        
        /** Code written without PostFormRequest */
        /* $request->validate([
            'title' => 'required|max:255|unique:posts,title,' . $id,
            'excerpt' => 'required',
            'body' => 'required',
            'image' => ['memes:png,jpg,jpeg', 'max:5048'],
            'min_to_read' => 'min:0|max:60',
        ]); */

        // Post::where('id', $id)->update([
        //     'title'        => $request->title,
        //     'excerpt'      => $request->excerpt,
        //     'body'         => $request->body,
        //     'min_to_read'  => $request->min_to_read,
        //     'image_path'   => $request->image_path,
        //     'is_published' => $request->is_published === 'on'
        // ]);

        /** Code written after PostFormRequest */
        $request->validated();  
        
        Post::where('id', $id)->update(
            $request->is_published == 'on' 
                ? array_replace($request->except('_token', '_method'), ['is_published' => 1])
                : array_replace($request->except('_token', '_method'), ['is_published' => 0])
        );


        return redirect( route('blog.index') );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Post::destroy($id);

        return redirect (route('blog.index'))->with('message','Post has been deleted.');
    }

    private function storeImage($request)
    {
        $newImageName = uniqid() . '-' . $request->title . '.' . $request->image->extension();
        
        return $request->image->move(public_path('images'), $newImageName);
    }
}
