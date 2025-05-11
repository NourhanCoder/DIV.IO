<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; //بنستورد كلاس File من Laravel علشان نقدر نستخدم دوال زي exists() و delete() لحذف الملفات من السيرفر

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'DESC')->paginate(); //عرض البوستات من الاحدث للاقدم
        return view('posts.index', ['posts' => $posts]);
    }

    public function home()
    {
        $posts = Post::orderBy('id', 'DESC')->paginate();
        return view('home', ['posts' => $posts]);
    }

    public function create()
    {
        $users = User::select('id', 'name')->get();
        $tags = Tag::select('id', 'name')->get();
        return view('posts.add', compact('users', 'tags'));
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
        // dd($request->tags);
        // sync بيحدّث العلاقة بين البوست والتاجز: يضيف الجديد ويحذف اللي مش متعلم
        // ربط التاجز المختارة بالبوست الحالي باستخدام جدول الربط (pivot table)
        $post->tags()->sync($request->tags);
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
        $users = User::select('id', 'name')->get();
        $tags = Tag::select('id', 'name')->get();
        return view('posts.edit', ['post' => $post, 'users' => $users, 'tags' => $tags]);
    }

    public function update($id, Request $request)
    {
        $post = Post::findOrFail($id);
        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id = $request->user_id;

        if ($request->hasFile('image')) {
            // حذف الصورة القديمة من فولدر التخزين
            $oldImagePath = storage_path('app/public/images/' . $post->image);
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }

            // حفظ الصورة الجديدة
            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('images', $imageName, 'public');
            $post->image = $imageName;
        }
        $post->save();

        $post->tags()->detach(); //هتمسح القديم و تضيف الجديد
        $post->tags()->sync($request->tags);
        return redirect('posts')->with('success', 'Post Updated Successfully');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // حذف الصورة من مجلد التخزين
        $imagePath = storage_path('app/public/images/' . $post->image); //بيكون المسار الكامل للصوره
        if ($post->image && File::exists($imagePath)) { //للتاكد من وجود صوره محفوظه و ان الصوره موجوده جوا المسار
            File::delete($imagePath); //لو الشرطين اتحققو بيتم الحذف
        }

        // فصل التاجز المرتبطة بالبوست (اختياري لكن نظافة بيانات)
        $post->tags()->detach();
        $post->delete(); //لحذف البوست نفسه
        return back()->with('success', 'Post Deleted Successfully');
    }
}
