@extends('layout.app')
@section('content')
    <div class="col-12">
        <a href="{{ route('tags.create') }}" class="btn btn-primary my-3">Add New Tag</a>
        <h1 class="p-3 border text-center my-3">All Tags</h1>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
        
                @include('inc.messages')
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Posts</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tags as $tag)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $tag->name }}</td>
                            <td>
                                @foreach ($tag->posts as $post)
                                <span class="badge bg-success my-1">{{$post->title}}</span>
                                   <br> 
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-info">Edit</a>
                            </td>
                            
                            <td>
                                <form action="{{ route('tags.destroy',$tag->id) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <input type="submit" value="Delete" class="btn btn-danger">
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
                    {{ $tags->links() }}
                </div>

            </div>
        @endsection