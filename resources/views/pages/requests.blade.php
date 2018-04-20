@extends('layouts.app')

@section('content')
<style media="screen">
  .requests {
      display: flex;
      justify-content: flex-end;
      align-items: flex-end;
  }
  .reqBox1 {
    flex: 5
  }
  .reqBox2 {
    flex: 2;
  }
  .reqBox3 {
    flex: 1;
  }
</style>
<div class="row">
  <div class="section">
    <div class="col m1 hide-on-med-and-down">
      @include('inc.sidebar')
    </div>
    <div class="col m11 s12">
      <div class="row">
        <h3 class="flow-text"><i class="material-icons">notifications</i> Account Registration Requests</h3>
        <div class="divider"></div>
      </div>
      <div class="row">
        @if(count($users) > 0)
          @foreach($users as $user)
            <div class="card grey lighten-4 horizontal">
              <div class="card-image hide-on-med-and-down">
                <img src="/storage/images/sideytu1.jpg" height="140px">
              </div>
              <div class="card-stacked">
                <div class="card-content">
                  <div class="row requests">
                    <div class="reqBox1">
                      <p>Hi, I am <b>{{ $user->name }}</b> , my email is <b>{{ $user->email }}</b>.
                      <br>and I want to be one of the system users who belongs to the department of <b>{{ $user->department['dptName'] }}</b>.</p>
                    </div>
                    <div class="reqBox2">
                      <p class="blue-text">{{ $user->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="reqBox3">
                      {!! Form::open(['action' => ['RequestsController@update',$user->id], 'method' => 'PATCH']) !!}
                      {{ csrf_field() }}
                      <button type="submit" name="b1" class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Accepts"><i class="material-icons">add_circle</i></button>
                      {!! Form::close() !!}
                    </div>
                    <div class="reqBox3">
                      {!! Form::open(['action' => ['UsersController@destroy',$user->id], 'method' => 'DELETE']) !!}
                      {{ csrf_field() }}
                      <button type="submit" name="b2" class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Rejects"><i class="material-icons">remove_circle</i></button>
                      {!! Form::close() !!}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        @else
          <div class="card">
            <div class="card-content">
              <h5 class="teal-text">No Registeration Has Been Requested</h5>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
