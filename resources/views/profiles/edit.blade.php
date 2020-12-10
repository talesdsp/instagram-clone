@extends('layouts\app')

@section('content')
<div class="container">
  <form action="/{{ $user->username }}" enctype="multipart/form-data" method="POST" >
    @csrf
    @method('PUT')

    <div class="row">

      <div class="col-8 offset-2">

        <div class="row">
            <h1>Edit Profile</h1>
        </div>

        <div class="form-group row">

          <label for="name" class="col-md-4 col-form-label">{{ __('Name') }}</label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $user->profile->name }}" />

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>

        <div class="form-group row">

          <label for="bio" class="col-md-4 col-form-label">{{ __('Bio') }}</label>
            <input id="bio" type="text" class="form-control @error('bio') is-invalid @enderror" name="bio" value="{{ old('bio') ?? $user->profile->bio }}" />

            @error('bio')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>

        <div class="form-group row">

          <label for="url" class="col-md-4 col-form-label">{{ __('URL') }}</label>
            <input id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ old('url') ?? $user->profile->url}}" />

            @error('url')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>

        <div class="row">
          <label for="image" class="col-md-4 col-form-label">{{ __('Profile Image') }}</label>
          <input type="file" class="form-control-file @error('caption') is-invalid @enderror" value="{{ old('image') }}" id="image" name="image" />

          @error('image')
              <strong>{{ $message }}</strong>
          @enderror
        </div>

        <div class="row pt-4">
            <button class="btn btn-primary">Save profile</button>
        </div>

      </div>

    </div>

  </form>
</div>
@endsection
