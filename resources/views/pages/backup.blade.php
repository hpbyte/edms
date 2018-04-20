@extends('layouts.app')

@section('content')
<div class="row">
  <div class="section">
    <div class="col m1 hide-on-med-and-down">
      @include('inc.sidebar')
    </div>
    <div class="col m11 s12">
		<div class="row">
			<h3 class="flow-text"><i class="material-icons">backup</i> Backup Manager</h3>
			<div class="divider"></div>
		</div>
		<div class="row">
			<div class="card col m4 offset-m4 s10 offset-s1 z-depth-4 white darken-2">
				<div class="card-content">
					<p class="center"><a href="/backup/create" class="waves-effect waves-light btn-large teal darken-5"><i class="material-icons left">backup</i>Create Backup</a></p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="card white darken-5 z-depth-3">
				<div class="card-content">
				<table class="bordered striped responsive-table">
					<thead>
						<tr>
							<th>Location</th>
							<th>Name</th>
							<th>Size</th>
							<th>Last Modified</th>
							<th></th>
						</tr>
					</thead>

					<tbody>
					@if(count($backups) > 0)
						@foreach($backups as $b)
							<tr>
								<td>{{ $b['file_path'] }}</td>
								<td>{{ $b['file_name'] }}</td>
								<td>{{ round((int)$b['file_size']/1048576, 2).' MB' }}</td>
								<td>{{ \Carbon\Carbon::createFromTimeStamp($b['last_modified'])->formatLocalized('%d %B %Y, %H:%M') }}</td>
								<td>
									<a href="/backup/download?file_name={{ urlencode($b['file_name']) }}" class="btn teal darken-5 waves-effect waves-light"><i class="material-icons">file_download</i></a>
									<a href="/backup/delete?file_name={{ urlencode($b['file_name']) }}" class="btn red darken-5 waves-effect waves-light"><i class="material-icons">delete</i></a>
								</td>
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
@endsection
