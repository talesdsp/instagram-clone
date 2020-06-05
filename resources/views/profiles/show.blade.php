@extends('layouts.app')

@section('content')
<div class="container col-8">
    <div class="row pt-5" >
        <div class="col-3">
            <img class="w-100 rounded-circle" src="{{ $user->profile->profileImage() }}" alt="">
        </div>
        <div class="col-9">
            <div class="bio d-flex justify-content-between align-items-baseline">
                
                <div class="d-flex align-items-center py-3">
                    <h3>{{$user->username}}</h3>
                    @if ((auth()->user() && $user->id != auth()->user()->id) ||!auth()->user())
                        <div id="follow-button" data-follows="{{$follows}}" data-username="{{$user->username}}"></div>
                    @endif
                </div>

                @can('update', $user->profile)
                    <a href="/p/create">New</a>
                @endcan

            </div>
            
            @can('update', $user->profile)
                <a href="/{{$user->username}}/edit">Edit Profile</a>
            @endcan

            <div class="d-flex">
                <div class="pr-5">
                    <strong>{{$postCount}}</strong> posts
                </div>
                <div id="followers" class="pr-5">
                    <strong>{{$followersCount}}</strong> followers
                </div>
                <div class="pr-5">
                    <strong>{{$followingCount}}</strong> following
                </div>
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
