@extends('layouts.app')

@section('content')
<div class="row">
  <div class="section">
    <div class="col m1 hide-on-med-and-down">
      @include('inc.sidebar')
    </div>
    <div class="col m11 s12 card">
      <div class="card-content">
        <video width="100%" height="500px" controls>
          <source src="{{ Storage::url($doc->file) }}" type="{{ $doc->mimetype }}">
          Your browser does not support the video tag.
        </video>
        <!-- <div class="video-container">
          <iframe src="{{ Storage::url($doc->file) }}" frameborder="0" allowfullscreen></iframe>
        </div> -->
      </div>
    </div>
  </div>
</div>
@endsection
