@extends('layouts.app')

@section('content')
<div class="container">  
  
    @foreach ($posts as $post)
    
        <div class="row justify-content-center align-items-center flex-column pb-4">
            
            <div class="col-xl-5 col-lg-6 col-md-7 col-sm-12">

                <div class="d-flex align-items-baseline pb-2">
                    <div class="pr-3">
                        <a href="/{{$post->user->username}}">
                            <img src="{{ $post->user->profile->profileImage() }}" class="rounded-circle w-100" style="max-width: 40px">
                        </a>
                    </div>
    
                    <div>
                        <div class="font-weight-bold">
                            <a href="/{{$post->user->username}}">
                                <span class="text-dark">{{$post->user->username}}</span>
                            </a>
                            
                        </div>
                    </div>
                </div>
                                
                <a href="/p/{{$post->id}}">
                    <img src="/storage/{{$post->image}}" class="w-100">
                </a>
            </div>
        
            <div class="col-xl-5 col-lg-6 col-md-7 col-sm-12 pt-3">
                <p>
                    <a href="/{{$post->user->username}}">
                        <span class="font-weight-bold text-dark">{{$post->user->username}}</span>
                    </a>

                    {{$post->caption}}
                </p>
            
            </div>
        </div>
    
    @endforeach

    <div class="row col-12">
        {{$posts->links()}}
    </div>
    
</div>
@endsection