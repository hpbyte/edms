@extends('layouts.app')

@section('content')
<div class="row">
  <div class="section">
    <div class="col m1 hide-on-med-and-down">
      @include('inc.sidebar')
    </div>
    <div class="col m11 s12">
      <div class="row">
        <h3 class="flow-text"><i class="material-icons">group</i> Departments
          <button data-target="modal1" class="btn waves-effect waves-light modal-trigger right">Add New</button>
        </h3>
        <div class="divider"></div>
      </div>
      <div class="card z-depth-2">
        <div class="card-content">
          <table class="responsive-table bordered centered highlight">
            <thead>
              <tr>
                  <th>Name</th>
                  <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @if(count($departments) > 0)
                @foreach($departments as $dept)
                  <tr>
                    <td>{{ $dept->dptName }}</td>
                    <td>
                      <!-- DELETE using link -->
                      {!! Form::open(['action' => ['DepartmentsController@destroy', $dept->id],
                      'method' => 'DELETE',
                      'id' => 'form-delete-departments-' . $dept->id]) !!}
                      <a href="#" class="left"><i class="material-icons"></i></a>
                      <a href="/departments/{{ $dept->id }}/edit" class="center"><i class="material-icons">mode_edit</i></a>
                      <a href="" class="right data-delete" data-form="departments-{{ $dept->id }}"><i class="material-icons">delete</i></a>
                      {!! Form::close() !!}
                    </td>
                  </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="3"><h5 class="teal-text">No Department has been added</h5></td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<!-- Modal Structure -->
<div id="modal1" class="modal">
  <div class="modal-content">
    <h4>Add Department</h4>
    <div class="divider"></div>
    <div class="row">
      {!! Form::open(['action' => 'DepartmentsController@store', 'method' => 'POST', 'class' => 'col s12']) !!}
      <div class="input-field">
        {{ Form::text('dptName','', ['class' => 'validate', 'id' => 'dptName']) }}
        <label for="dptName">Department Name</label>
      </div>
      <div class="input-field">
        {{ Form::submit('Submit', ['class' => 'btn waves-effect waves-light']) }}
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>
@endsection
