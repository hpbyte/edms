@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col m8 col-offset-m2">
            <div class="card">
                <div class="card-content">
                  <div class="card-title">Reset Password</div>
                  <div class="divider"></div>
                    @if (session('status'))
                        <script>
                          Materialize.toast("{{ session('status') }}");
                        </script>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="input-field{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email">E-Mail Address</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="red-text">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="input-field">
                            <button type="submit" class="btn waves-effect waves-light">
                                Send Password Reset Link
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
