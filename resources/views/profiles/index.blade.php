@extends('layouts.app')

@section('content')
<div class="container col-8">
    <div class="row pt-5" >
        <div class="col-3">
            <img width="100%" class="rounded-circle" src="https://images.pexels.com/photos/936317/pexels-photo-936317.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" alt="">
        </div>
        <div class="col-9">
            <div class="bio d-flex justify-content-between align-items-baseline">
                <h1>{{$user->username}}</h1>
                <a href="/p/create">add new post</a>
            </div>

            <div class="d-flex">
            <div class="pr-5"><strong>{{$posts->count()}}</strong> posts</div>
                <div class="pr-5"><strong>4k</strong> followers</div>
                <div class="pr-5"><strong>821</strong> following</div>
            </div>

            <div class="pt-4 font-weight-bold">{{$profile->title ?? ''}}</div>
            <div>{{$profile->description ?? ''}}</div>
            <div><a href="#" class="">{{$profile->url ?? ''}}</a></div>

        </div>
    </div>

    <div class="row pt-5">
        @foreach ($posts as $post)
        <div class="col-4 pb-5">
            <a href="p/${{post->id}}">
                <img width="100%"  src="/storage/{{$post->image}}" alt="">
            </a>
        </div>
        @endforeach
    </div>

</div>
@endsection
