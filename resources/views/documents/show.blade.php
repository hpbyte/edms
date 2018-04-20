@extends('layouts.app')

@section('content')
<style media="screen">
  .btn-icons {
    display: flex;
    justify-content: center;
  }
  .btn-circle {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    color: #fff;
    padding-left: 16px;
    padding-top: 16px;
    margin: auto 5px;
  }
  .btn-circle i:hover {
    color: #000;
    transition: 0.5s all;
  }
</style>
<div class="row">
  <div class="section">
    <div class="col m1 hide-on-med-and-down">
      @include('inc.sidebar')
    </div>
    <div class="col m11 s12">
      <div class="row">
        <h3 class="flow-text"><i class="material-icons">info</i> Document Information</h3>
        <div class="btn-icons">
          {!! Form::open() !!}
          <a href="/documents/{{ $doc->id }}/edit" class="btn-circle teal waves-effect waves-light tooltipped" data-position="left" data-delay="50" data-tooltip="Edit this"><i class="material-icons">mode_edit</i></a>
          <a href="/documents/open/{{ $doc->id }}" class="btn-circle blue darken-3 waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Open this"><i class="material-icons">open_with</i></a>
          {!! Form::close() !!}
          <!-- SHARE using link -->
          {!! Form::open(['action' => ['ShareController@update', $doc->id], 'method' => 'PATCH', 'id' => 'form-share-documents-' . $doc->id]) !!}
          @can('shared')
          <a href="#" class="btn-circle purple waves-effect waves-light data-share tooltipped" data-position="top" data-delay="50" data-tooltip="Share this" data-form="documents-{{ $doc->id }}"><i class="material-icons">share</i></a>
          @endcan
          {!! Form::close() !!}
          <!-- DELETE using link -->
          {!! Form::open(['action' => ['DocumentsController@destroy', $doc->id],
          'method' => 'DELETE', 'id' => 'form-delete-documents-' . $doc->id]) !!}
          @can('delete')
          <a href="#" class="btn-circle red waves-effect waves-light data-delete tooltipped" data-position="right" data-delay="50" data-tooltip="Delete this" data-form="documents-{{ $doc->id }}"><i class="material-icons">delete</i></a>
          @endcan
          {!! Form::close() !!}
        </div>
      </div>
      <div class="col s12 m11">
        <div class="card horizontal hoverable">
          <div class="card-image hide-on-med-and-down">
            <img src="/storage/images/sideytu1.jpg" height="650px">
          </div>
          <div class="card-stacked">
            <div class="card-content">
              @if($doc->isExpire == 2)
                <h5 class="red-text">
                  <i class="material-icons">error_outline</i> This Document Has Expired!
                </h5>
                <p class="red-text">Please consider disposal or restoration of this document.</p>
              @endif
              <ul class="collapsible" data-collapsible="accordion">
                <li>
                  <div class="collapsible-header active"><i class="material-icons">folder</i>Document Name</div>
                  <div class="collapsible-body"><span class="teal-text">{{ $doc->name }}</span></div>
                </li>
                <li>
                  <div class="collapsible-header"><i class="material-icons">description</i>Description</div>
                  <div class="collapsible-body"><span class="teal-text">{{ $doc->description }}</span></div>
                </li>
                <li>
                  <div class="collapsible-header"><i class="material-icons">account_circle</i>Owner</div>
                  <div class="collapsible-body"><span class="teal-text">{{ $doc->user['name'] }}</span></div>
                </li>
                <li>
                  <div class="collapsible-header"><i class="material-icons">group</i>Department</div>
                  <div class="collapsible-body"><span class="teal-text">{{ $doc->user->department['dptName'] }}</span></div>
                </li>
                <li>
                  <div class="collapsible-header"><i class="material-icons">class</i>Category</div>
                  <div class="collapsible-body">
                    <span class="teal-text">
                      <ul>
                        @foreach($doc->categories()->get() as $cate)
                        <li>{{ $cate->name }}</li>
                        @endforeach
                      </ul>
                    </span>
                  </div>
                </li>
                <li>
                  <div class="collapsible-header"><i class="material-icons">date_range</i>Expires At</div>
                  <div class="collapsible-body">
                    <span class="teal-text">
                      @if($doc->isExpire)
                        {{ $doc->expires_at }}
                      @else
                        No Expiration is set
                      @endif
                    </span>
                  </div>
                </li>
                <li>
                  <div class="collapsible-header"><i class="material-icons">date_range</i>Uploaded At</div>
                  <div class="collapsible-body"><span class="teal-text">{{ $doc->created_at->toDayDateTimeString() }}</span></div>
                </li>
                <li>
                  <div class="collapsible-header"><i class="material-icons">date_range</i>Updated At</div>
                  <div class="collapsible-body"><span class="teal-text">{{ $doc->updated_at->toDayDateTimeString() }}</span></div>
                </li>
                <li>
                  <div class="collapsible-header"><i class="material-icons">info_outline</i>MetaData</div>
                  <div class="collapsible-body">
                    <span class="teal-text">
                      <ul>
                        <li>Size : {{ $doc->filesize }} </li>
                        <li>Type : {{ $doc->mimetype }}</li>
                        <li>Last Modified : {{ \Carbon\Carbon::createFromTimeStamp(Storage::lastModified($doc->file))->formatLocalized('%d %B %Y, %H:%M') }}</li>
                      </ul>
                    </span>
                  </div>
                </li>
              </ul>
            </div>
            <div class="card-action">
              <a href="/documents" class="teal-text">Back</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
