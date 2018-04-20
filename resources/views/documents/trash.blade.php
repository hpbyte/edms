@extends('layouts.app')

@section('content')
<style>
  .trash-content {
    padding: 0 24px;
  }
  .trashBox {
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
  }
  .trashIcon {
    flex: 1;
  }
  .trashIcon i {
    width: 56px;
    height: 56px;
    padding-left: 16px;
    padding-top: 16px;
    background-color: black;
    color: #fff;
  }
  .trashInfo {
    flex: 2;
  }
  .trashAction {
    flex: 3;
  }
  .trashAction a {
    text-decoration: none;
    color: #fff;
  }
  .trashAction i {
    width: 45px;
    height: 45px;
    padding-left: 10px;
    padding-top: 10px;
    margin: auto 10px;
    background-color: #000;
  }
  .trashAction i:last-child {
    margin-right: 0;
  }
  .trashAction i:hover {
    background-color: #fff;
    color: #000;
    transition: 0.5s all;
  }
  /* --------------------- */
  @media (max-width: 480px) {
    .trash-content {
      padding: 5px 10px;
    }
    .trashIcon {
      display: none;
    }
  }
</style>
<div class="row">
  <div class="section">
    <div class="col m1 hide-on-med-and-down">
      @include('inc.sidebar')
    </div>
    <div class="col m11 s12">
      <div class="row">
        <h3 class="flow-text">
          <i class="material-icons">priority_high</i> Expired Documents
        </h3>
        <div class="divider"></div>
      </div>
    @if(count($trash) > 0)
      @foreach($trash as $t)
        <div class="card z-depth-2 red darken-1" style="margin: 7px 0">
          <div class="trash-content">
            <div class="row trashBox" style="margin: auto">
              <div class="trashIcon">
                @if($t->mimetype == "image/jpeg")
                <i class="material-icons">image</i>
                @elseif($t->mimetype == "video/mp4")
                <i class="material-icons">movie</i>
                @elseif($t->mimetype == "audio/mpeg")
                <i class="material-icons">music_video</i>
                @elseif($t->mimetype == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
                <i class="material-icons">folder</i>
                @else
                <i class="material-icons">folder_open</i>
                @endif
              </div>
              <div class="trashInfo">
                {{ $t->name }}
              </div>
              <div class="trashInfo">
                {{ $t->filesize }}
              </div>
              <div class="trashInfo">
                Expired Since {{ $t->expires_at }}
              </div>
              <div class="trashAction">
                <!-- DELETE using link -->
                {!! Form::open(['action' => ['DocumentsController@destroy', $t->id],
                'method' => 'DELETE', 'id' => 'form-delete-documents-' . $t->id]) !!}
                  <a href="documents/{{ $t->id }}"><i class="material-icons circle tooltipped" data-position="top" data-delay=50 data-tooltip="View Details">visibility</i></a>
                  <a href="documents/download/{{ $t->id }}"><i class="material-icons circle tooltipped" data-position="top" data-delay=50 data-tooltip="Download">file_download</i></a>
                  <a href="" class="data-delete" data-form="documents-{{ $t->id }}"><i class="material-icons circle tooltipped"  data-position="top" data-delay="50" data-tooltip="Delete Forever">delete_forever</i></a>
                  <a href="documents/restore/{{ $t->id }}"><i class="material-icons circle tooltipped" data-position="top" data-delay=50 data-tooltip="Restore">restore</i></a>
                {!! Form::close() !!}
              </div>
            </div>
          </div>
        </div>
      @endforeach
    @else
        <div class="card z-depth-2 red darken-1">
          <div class="card-content">
            <h5>Documents are not expired yet!</h5>
          </div>
        </div>
    @endif
    </div>
  </div>
</div>
@endsection
