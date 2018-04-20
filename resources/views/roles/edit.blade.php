@extends('layouts.app')

@section('content')
<div class="row">
	<div class="section">
		<div class="col m1 hide-on-med-and-down">
		  @include('inc.sidebar')
		</div>
		<div class="col m11 s12">
			<div class="row">
				<h3 class="flow-text"><i class="material-icons">mode_edit</i> Roles + Permissions</h3>
				<div class="divider"></div>
			</div>
			<div class="row">
				<div class="col m7 offset-m2">
					{!! Form::open(['action' => ['RolesController@update', $role->id], 'method' => 'PUT']) !!}
					<div class="card z-depth-2 hoverable">
						<div class="card-content">
							<h5 class="indigo-text">Assign Roles With Permissions</h5>
							<br>
							<div class="input-field">
								<i class="material-icons prefix">assignment_ind</i>
								{{ Form::text('name',$role->name,['class' => 'validate', 'id' => 'role']) }}
								<label for="role">Role</label>
							</div>
							<br>
							<div class="input-field">
							  	<h6 class="teal-text">Available Permissions</h6>
							  	<br>	
							  	@foreach($permissions as $permission)
									<p>
									{{ Form::checkbox('permissions[]', $permission->id, $role->permissions, ['class' => 'filled-in', 'id' => $permission->id]) }}
									<label for="{{ $permission->id }}">{{ ucfirst($permission->name) }}</label>
									</p>
							  	@endforeach
						  	</div>
						  	<br>
							<div class="input-field">
								<p class="center">{{ Form::submit('Assign', ['class' => 'btn waves-effect waves-light']) }}</p>
							</div>
						</div>
					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection