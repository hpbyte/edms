@extends('layouts.app')

@section('content')
<div class="row">
  <div class="section">
    <div class="col m1 hide-on-med-and-down">
      @include('inc.sidebar')
    </div>
    <div class="col m11 s12">
      <div class="row">
        <h3 class="flow-text"><i class="material-icons">mode_edit</i> Edit Document
          <a href="/documents" class="btn waves-effect waves-light right tooltipped" data-position="left" data-delay="50" data-tooltip="Go Back"><i class="material-icons">arrow_back</i> Back</a>
        </h3>
        <div class="divider"></div>
      </div>
      <div class="row">
        <div class="col m8 s12">
          {!! Form::open(['action' => ['DocumentsController@update',$doc->id], 'method' => 'PATCH', 'enctype' => 'multipart/form-data', 'class' => 'col s12']) !!}
            {{ csrf_field() }}
          <div class="card">
            <div class="card-content">
              <div class="input-field">
                <i class="material-icons prefix">folder</i>
                {{ Form::text('name',$doc->name,['class' => 'validate', 'id' => 'name']) }}
                <label for="name">File Name</label>
                @if ($errors->has('name'))
                  <span class="red-text"><strong>{{ $errors->first('name') }}</strong></span>
                @endif
              </div>
              <br>
              <div class="input-field">
                <i class="material-icons prefix">description</i>
                {{ Form::text('description',$doc->description,['class' => 'validate', 'id' => 'description']) }}
                <label for="description">Description</label>
                @if ($errors->has('description'))
                  <span class="red-text"><strong>{{ $errors->first('description') }}</strong></span>
                @endif
              </div>
              <br>
              <div class="input-field">
                @if(is_null($doc->expires_at))
                {{ Form::checkbox('isExpire',1,true,['id' => 'isExpire']) }}
                @else
                {{ Form::checkbox('isExpire',1,false,['id' => 'isExpire']) }}
                @endif
                <label for="isExpire">Does Not Expire</label>
              </div>
              <br>
              <div class="input-field">
                @if(is_null($doc->expires_at))
                {{ Form::text('expires_at', '',['class' => 'datepicker', 'id' => 'expirePicker', 'disabled']) }}
                @else
                {{ Form::text('expires_at', $doc->expires_at,['class' => 'datepicker', 'id' => 'expirePicker']) }}
                @endif
                <label for="expirePicker">Expires At</label>
              </div>
              <br>
              <div class="input-field">
                <i class="material-icons prefix">class</i>
                {{ Form::select('category_id[]',$categories,$categories,['multiple' => 'multiple', 'id' => 'category']) }}
                <label for="category">Category (Optional)</label>
                @if ($errors->has('category'))
                  <span class="red-text"><strong>{{ $errors->first('category') }}</strong></span>
                @endif
              </div>
              <br>
              <div class="input-field">
                <p class="center">
                  {{ Form::submit('Save Changes',['class' => 'btn-large waves-effect waves-light']) }}
                </p>
              </div>
            </div>
          </div>
          {!! Form::close() !!}
        </div>
        <div class="col m4 hide-on-med-and-down">
          <div class="card-panel teal">
            <h4>Notice</h4>
            <p>
              <ul>
                <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</li>
              </ul>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
