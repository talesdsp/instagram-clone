@extends('layouts.app')

@section('content')
<div class="container">
    <post-info :auth-user="{{auth()->user() ? auth()->user(): json_encode(['id'=>'0'])}}" :same-user="{{(!Auth::check() ? 0 : auth()->user()->id == $user->id) ? 1 : 0}}" :profile="{{$profile}}" :user="{{$user}}" :post="post" :comments="{{json_encode($comments)}}"></post-info>

    @if(!Auth::check())
        <log-banner></log-banner>
    @endif

    <script type="application/javascript">
        window.post = @json($post);
    </script>
</div>
@endsection