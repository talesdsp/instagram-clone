@extends('layouts.app')

@section('content')
<div class="container">  
    <div class="row">
        <div class="col-8">
            <img src="/storage/{{$post->image}}" class="w-100">
        </div>
        <div class="col-4">
            <div>
                <div class="d-flex align-items-center">
                    <div class="pr-3">
                        <img src="/storage/{{$post->user->profile->image}}" class="rounded-circle w-100" style="max-width: 50px">
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