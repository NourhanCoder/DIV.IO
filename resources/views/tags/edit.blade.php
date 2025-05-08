@extends('layout.app')
@section('content')
    <div class="col-12">
       <h1 class="my-3 text-center">Update Tag Info</h1>  
    </div>
  

            <div class="col-6 mx-auto">
                <form action="{{ route('tags.update', $tag->id) }}" method="POST" class="form border p-3">
                    @csrf
                    @method('PUT')
                    @include('inc.messages')
                    <div class="mb-3">
                        <label for="">Name</label>
                        <input type="text" name="name" id="" value="{{ $tag->name }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <input type="submit" value="save" id="" class="form-control bg-success text-white">
                    </div>
                </form>

            </div>
        @endsection