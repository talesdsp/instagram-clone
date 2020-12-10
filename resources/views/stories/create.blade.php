@extends('layouts.app')

@section('content')

<div class="container">

  <form action="/s" enctype="multipart/form-data" method="POST" >
    @csrf
    <div class="row">

      <div class="col-8 offset-2">

        <div class="row">
            <h1>Add New Story</h1>
        </div>

        <div class="form-group row">

        <div class="row">
            <input aria-label="add your stories here" type="file" class="form-control-file @error('caption') is-invalid @enderror" value="{{ old('story') }}" required id="story" name="story" />

            @error('story')
                <strong>{{ $message }}</strong>
            @enderror

        </div>


        <div class="row pt-4">
            <button class="btn btn-primary">Add new Story</button>
        </div>
      </div>

    </div>

  </form>

</div>

@endsection











{{-- @extends('layouts.app')

@section('content')

<div class="container">
  <div class="col-8 offset-2">
    <file-input></file-input>
  </div>
</div>

@endsection --}}