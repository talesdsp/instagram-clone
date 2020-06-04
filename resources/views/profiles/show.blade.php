@extends('layouts.app')

@section('content')
<div class="container col-8">
    <div class="row pt-5" >
        <div class="col-3">
            <img class="w-100 rounded-circle" src="{{ $user->profile->profileImage() }}" alt="">
        </div>
        <div class="col-9">
            <div class="bio d-flex justify-content-between align-items-baseline">
                <h1>{{$user->username}}</h1>
                <a href="/p/create">add new post</a>
            </div>

        <a href="/{{$user->username}}/edit">Edit Profile</a>

            <div class="d-flex">
                <div class="pr-5"><strong>{{$user->posts->count()}}</strong> posts</div>
                <div class="pr-5"><strong>4k</strong> followers</div>
                <div class="pr-5"><strong>821</strong> following</div>
            </div>

            <div class="pt-4 font-weight-bold">{{$user->profile->title ?? ''}}</div>
            <div>{{$user->profile->description ?? ''}}</div>
            <div><a href="#" class="">{{$user->profile->url ?? ''}}</a></div>

        </div>
    </div>

    <div class="row pt-5">
        @foreach ($user->posts as $post)
        <div class="col-4 pb-5">
            <a href="/p/{{$post->id}}">
                <img width="100%"  src="/storage/{{$post->image}}" alt="">
            </a>
        </div>
        @endforeach
    </div>

</div>
@endsection
