@extends('auth.layoutauth')
@section('content')

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
    <img src="{{asset('img/Group1.png')}}"  class="img"><br>
      <!-- <a href="/"><b>INKA</b> Smart Inventory</a> -->
    </div>
    <!-- /.login-logo -->
    <div class="card">
      @error('nip')
      <span class="alert alert-danger" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="input-group mb-3">
            <input type="" id="nip" class="form-control  @error('nip') is-invalid @enderror" name="nip" value="{{ old('nip') }}" required placeholder="NIP" autofocus>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>

          <div class="input-group mb-3">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">
            @error('password')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mb-1">
          <a href="/password/reset">I forgot my password</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->
  @endsection