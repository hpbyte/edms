@extends('layouts.app')

@section('content')
<div class="row">
  <div class="section">
    <div class="col m1 hide-on-med-and-down">
      @include('inc.sidebar')
    </div>
    <div class="col m11 s12">
      <div class="row">
        <h3 class="flow-text"><i class="material-icons">assignment_ind</i> Roles &amp; Permissions</h3>
        <div class="divider"></div>
      </div>
      <div class="row">
        <div class="col m8 s12">
          <div class="card z-depth-2 hoverable">
            <div class="card-content">
            <h5 class="indigo-text">Roles + Permissions</h5>
              <table class="responsive-table striped">
                <thead>
                  <tr>
                      <th>Role</th>
                      <th>Permissions</th>
                      <th></th>
                  </tr>
                </thead>

                <tbody>
                @if(count($roles) > 0)
                  @foreach($roles as $r)
                  <tr>
                    <td>{{ $r->name }}</td>
                    <td>{{ $r->permissions()->pluck('name')->implode(' ') }}</td>
                    <td><a href="roles/{{ $r->id }}/edit"><i class="material-icons">mode_edit</i></a></td>
                  </tr>
                  @endforeach
                @endif
                </tbody>
              </table>
            </div>
          </div>
          <!-- ====================== -->
          <div class="row">
            <div class="card col m5 s12 z-depth-2 indigo lighten-1">
              <div class="card-content">
                <h5 class="white-text">Notice</h5>
                <p class="grey-text text-lighten-2">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo velit alias, veniam mollitia tenetur molestiae amet soluta distinctio laboriosam nobis. Impedit ab perspiciatis, debitis, modi ipsam obcaecati accusamus porro voluptate.
                </p>
              </div>
            </div>
            <div class="col m7 s12">
              <div class="card z-depth-2 hoverable">
                <div class="card-content">
                <h5 class="indigo-text">Roles</h5>
                  <table class="striped">
                    <thead>
                      <tr>
                          <th>ID.</th>
                          <th>Role</th>
                      </tr>
                    </thead>

                    <tbody>
                    @if(count($roles) > 0)
                      @foreach($roles as $key => $role)
                      <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $role->name }}</td>
                      </tr>
                      @endforeach
                    @endif
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- ===================================================== -->
        <div class="col m4 s12">
          <div class="card z-depth-2 hoverable">
            <div class="card-content">
            <h5 class="indigo-text">Permissions</h5>
              <table class="striped">
                <thead>
                  <tr>
                      <th>ID.</th>
                      <th>Permission</th>
                  </tr>
                </thead>

                <tbody>
                @if(count($permissions) > 0)
                  @foreach($permissions as $key => $permission)
                  <tr>
                    <td>{{ $key++ }}</td>
                    <td>{{ $permission }}</td>
                  </tr>
                  @endforeach
                @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
