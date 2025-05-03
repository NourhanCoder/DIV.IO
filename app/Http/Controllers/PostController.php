<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'DESC')->paginate();
        return view('posts.index', ['posts' => $posts]);
    }

    public function home()
    {
        $posts = Post::paginate();
        return view('home', ['posts' => $posts]);
    }

    public function create()
    {
        $users = User::select('id', 'name')->get();

        return view('posts.add', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'min:3'],
            'description' => ['required', 'string', 'max:1500'],
            'user_id' => ['required', 'exists:users,id'],
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg,gif,webp']
        ]);

        //$image = $request->file('image')->store('public');  //لو هرفع الصوره بالمسار public
        //dd($image);
        
        //لو هرفع اسم الصوره بس من غير اي مسار ع الداتابيز
        $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->storeAs('images', $imageName, 'public');

        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id = $request->user_id;
        //$post->image = $image;
        $post->image = $imageName;
        $post->save();
        return back()->with('success', 'Post Added Successfully');
        // dd($request->all());
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', ['post' => $post]);
    }

    public function search(Request $request)
    {
        $q = $request->q;
        $posts = Post::where('description', 'LIKE', '%' . $q . '%')->get();
        return view('posts.search', ['posts' => $posts]);
    }



    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', ['post' => $post]);
    }

    public function update($id, Request $request)
    {
        $post = Post::findOrFail($id);
        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id = $request->user_id;
        $post->save();
        return redirect('posts')->with('success', 'Post Updated Successfully');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return back()->with('success', 'Post Deleted Successfully');
    }
}
