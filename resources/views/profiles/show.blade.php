@extends('layouts.app')

@section('content')
<div class="container col-8">
    <profile :stories="{{json_encode(['data'=>$stories])}}" :same-user="{{(!Auth::check() ? 0 :auth()->user()->id == $user->id) ? 1: 0}}" :user="{{$user}}" :post-count="{{$postCount}}" :followers-count="{{$followersCount}}" :following-count="{{$followingCount}}" :follows="{{$follows ? 1 : 0}}"></profile>

    <div class="row pt-5">
        @foreach ($posts as $post)
        <div class="col-4 pb-5">
            <a href="/p/{{$post->id}}">
                <img width="100%"  src="/storage/{{$post->image}}" alt="">
            </a>
        </div>
        @endforeach
    </div>

    @if(!Auth::check())
        <log-banner></log-banner>
    @endif
</div>
@endsection
