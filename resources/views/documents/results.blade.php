@extends('layouts.app')

@section('content')
<style>
  .card-content2 {
    padding: 10px 7px;
  }
  .search {
    width: 30%;
    float: right;
  }
  @media (max-width: 768px) {
    .search {
      width: 50%;
    }
  }
  @media (max-width: 460px) {
    .search {
      width: 100%;
    }
  }
  /* --- for right click menu --- */
  *,
  *::before,
  *::after {
    box-sizing: border-box;
  }
  .task i {
    color: orange;
    font-size: 35px;
  }
  /* context-menu */
  .context-menu {
    padding: 0 5px;
    margin: 0;
    background: #f7f7f7;
    font-size: 15px;
    display: none;
    position: absolute;
    z-index: 10;
    box-shadow: 0 4px 5px 0 rgba(0,0,0,0.14), 0 1px 10px 0 rgba(0,0,0,0.12), 0 2px 4px -1px rgba(0,0,0,0.3);
  }
  .context-menu--active {
    display: block;
  }
  .context-menu_items {
    margin: 0;
  }
  .context-menu_item {
    border-bottom: 1px solid #ddd;
    padding: 12px 30px;
  }
  .context-menu_item:last-child {
    border-bottom: none;
  }
  .context-menu_item:hover {
    background: #fff;
  }
  .context-menu_item i {
    margin: 0;
    padding: 0;
  }
  .context-menu_item p {
    display: inline;
    margin-left: 10px;
  }
</style>
<div class="row">
  <div class="section">
    <div class="col m1 hide-on-med-and-down">
      @include('inc.sidebar')
    </div>
    <div class="col m11 s12">
      <div class="row">
        <h3 class="flow-text"><i class="material-icons">folder</i> Documents
        <a href="#" class="btn red waves-effect waves-light right tooltipped" data-position="left" data-delay="50" data-tooltip="Delete Selected Documents"><i class="material-icons">delete</i></a>
        @can('upload')
          <a href="/documents/create" class="btn waves-effect waves-light right tooltipped" data-position="left" data-delay="50" data-tooltip="Upload New Document"><i class="material-icons">file_upload</i></a>
        @endcan
        </h3>
        <div class="divider"></div>
      </div>
      <div class="card z-depth-2">
        <div class="card-content">
          <div class="row">
            <div class="left">
              <h6 class="flow-text orange-text">{{ count($results) }} Results</h6>
            </div>
            <div class="search input-field">
              <form action="/search" method="post" id="search-form">
                {{ csrf_field() }}
                  <i class="material-icons prefix">search</i>
                  <input type="text" name="search" id="search" placeholder="Search Here ...">
                  <label for="search"></label>
              </form>
            </div>
          </div>
          <br>
          <div class="row">
          @if(count($results) > 0)
            @foreach($results as $res)
            	@foreach($res as $r)
				        <div class="col m2 s6">
		              <a href="documents/{{ $r->id }}">
		                <div class="card hoverable indigo lighten-5
		 task" data-id="{{ $r->id }}">
		                  <input type="checkbox" class="filled-in" id="chk{{$r->id}}"><label for="chk{{$r->id}}"></label>
		                  <div class="card-content2 center">
		                    @if($r->mimetype == "image/jpeg")
		                    <i class="material-icons">image</i>
		                    @elseif($r->mimetype == "video/mp4")
		                    <i class="material-icons">movie</i>
		                    @elseif($r->mimetype == "audio/mpeg")
		                    <i class="material-icons">music_video</i>
		                    @else
		                    <i class="material-icons">folder</i>
		                    @endif
		                    <h6>{{ $r->name }}</h6>
		                    <p>{{ $r->filesize }}</p>
		                  </div>
		                </div>
		              </a>
		            </div>
            	@endforeach
            @endforeach
          @else
            <h5 class="teal-text">No Matches Found :(</h5>
          @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- right click menu -->
<div id="context-menu" class="context-menu">
  <ul class="context-menu_items">
    <li class="context-menu_item">
      <a href="#" class="context-menu_link" data-action="Edit">
        <i class="material-icons">open_with</i><p>Open</p>
      </a>
    </li>
    <li class="context-menu_item">
      <a href="#" class="context-menu_link" data-action="Edit">
        <i class="material-icons">share</i><p>Share</p>
      </a>
    </li>
    <li class="context-menu_item">
      <a href="#" class="context-menu_link" data-action="Edit">
        <i class="material-icons">edit</i><p>Edit</p>
      </a>
    </li>
    <li class="context-menu_item">
      <a href="#" class="context-menu_link" data-action="Delete">
        <i class="material-icons">delete</i><p>Delete</p>
      </a>
    </li>
  </ul>
</div>
@endsection
