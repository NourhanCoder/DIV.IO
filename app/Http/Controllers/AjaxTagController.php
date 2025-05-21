<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class AjaxTagController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$tags = Tag::all(); //في حالة مش هستخدم links in index file
        $tags = Tag::paginate(); //في حالة استخدام links
        return view('ajax-tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ajax-tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|min:3'
        ]);
        Tag::create($data);
        return response()->json(['status'=>'success','message'=>'data added successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tag = Tag::findOrFail($id);
       
        return view('ajax-tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $ajax_tag)
    {
       
        $request->validate([
            'name' => 'required|string|min:3'
        ]);
        // $tag->update(['name' => $request->name]);
        $ajax_tag->name = $request->name;
        $ajax_tag->save();
        return response()->json(['status'=>'success','message'=>'data updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $ajax_tag)
    {
        $ajax_tag->delete();
        return response()->json(['status'=>'success','message'=>'data deleted successfully']);
    }
}