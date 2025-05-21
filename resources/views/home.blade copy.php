@extends('layout.app')
@section('content')

<div class="col-12">
    <h1 class="p-3 border text-center my-3">All Posts</h1>
</div>
@foreach ($posts as $post)
<div class="col-8 mx-auto">
    <div class="card">
        <div class="card-header">
            {{ $post->user->name}} - {{ $post->created_at->format ('Y-m-d') }}
        </div>
        <div class="card-body">
            <div class="card-img">
                <img src="{{ $post->image() }}" width="100%" height="400" alt="">
            </div>
            <h5 class="card-title">{{ $post->title }}</h5>
            <p class="card-text">{{Str::limit($post->description, 200)}}.</p>
            <a href="{{ url('posts/' . $post->id) }}" class="btn btn-primary">Show Post</a>
        </div>
    </div>
</div>
@endforeach
<div>
    {{ $posts->links() }}
</div>

@endsection
