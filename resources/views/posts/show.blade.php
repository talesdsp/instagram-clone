@extends('layouts.app')

@section('content')
<div class="container">  
    <div class="row justify-content-center ">
        <div class="col-6">
            <img src="/storage/{{$post->image}}" class="w-100">
        </div>
        <div class="col-4 pt-4">
            <div>
                <div class="d-flex align-items-center">
                    <div class="pr-3">
                        <img src="{{ $post->user->profile->profileImage() }}" class="rounded-circle w-100" style="max-width: 50px">
                    </div>

                    <div>
                        <div class="font-weight-bold">
                            <a href="/{{$post->user->username}}">
                                <span class="text-dark">{{$post->user->username}}</span>
                            </a>
                            
                            <a class="pl-3">Follow</a>
                        </div>
                    </div>
                </div>
                
                <hr/> 

                <p>
                    <a href="/{{$post->user->username}}">
                        <span class="font-weight-bold text-dark">{{$post->user->username}}</span>
                    </a>

                    {{$post->caption}}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection