@extends('layouts.app')

@section('content')

    <div class="index-stories sticky flex">
        <a class="stories feed off ml-4 mb-4" href="/s/create">
            <img src="/storage/{{$user->profile->image}}" />
            <div class="plus-button">+</div>
        </a>

        @if(count($profilesWithStories['data'])>0)
            <stories-section :user="{{$user}}" :stories="{{json_encode($profilesWithStories)}}"></stories-section>
        @endif
    </div>

    @if(count($posts['data'])>0)
        <index-posts :posts="{{json_encode($posts)}}"></index-posts>
    @endif

    <recommend-profiles :profiles="{{json_encode($profilesIDoNotFollow)}}"></recommend-profiles>
@endsection