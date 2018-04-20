@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col m8 offset-m2 s12">
      <div class="card hoverable">
        <div class="card-content">
          <span class="card-title">Login</span>
          <div class="divider"></div>
          <div class="section">
            <form action="{{ route('login') }}" method="POST">
              {{ csrf_field() }}

              <div class="input-field{{ $errors->has('email') ? ' has-error' : '' }}">
                <i class="material-icons prefix">email</i>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                <label for="email" class="active">E-mail Address</label>
                @if ($errors->has('email'))
                  <span class="red-text"><strong>{{ $errors->first('email') }}</strong></span>
                @endif
              </div>
              <div class="input-field{{ $errors->has('password') ? ' has-error' : '' }}">
                <i class="material-icons prefix">vpn_key</i>
                <input id="password" type="password" name="password" required>
                <label for="password" class="active">Password</label>
                @if ($errors->has('password'))
                  <span class="red-text"><strong>{{ $errors->first('password') }}</strong></span>
                @endif
              </div>
              <div class="input-field">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">Remember Me</label>
              </div>
              <br>
              <div class="input-field">
                <button type="submit" name="login" class="btn waves-effect waves-light">Login</button>
                <a class="right" href="{{ route('password.request') }}">
                    Forgot Your Password?
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
