@extends('layouts.basic')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <div class="col-md-12">
                            <input id="email" placeholder="Your E-mail" type="email" class="form-control no-border-radius"  name="email" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <div class="col-md-12">
                            <input id="password" placeholder="Your Password" type="password" class="form-control no-border-radius"  name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group col-md-12 special-row">
                        <div class="col-md-6 left-side">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} id="account_remember_me">
                            <label for="account_remember_me">Remember Me</label>
                        </div>
                        <div class="col-md-6 right-side">
                            <a class="forgot-password btn-link pull-right" href="{{ route('password.request') }}">
                                Forgot Your Password?
                            </a>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-purple col-md-12">
                        Login
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
