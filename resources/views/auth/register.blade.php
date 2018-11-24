@extends('layouts.basic')

@section('header_script')
    <link href="/node_modules/select2/dist/css/select2.min.css" rel="stylesheet">
    <link href="{{ asset('css/util.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection


@section('content')

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-l-30 p-r-30 p-t-30 p-b-30">
                <form class="login100-form validate-form" role="form" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}
                    <span class="login100-form-title p-b-55">
						Register
					</span>

                    <div class="wrap-input100 validate-input m-b-16" data-validate = "Valid nick name is required">
                        <input class="input100" type="text" name="nick" placeholder="Nick Name" value="{{ old('nick') }}" required autofocus>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
							<span class="lnr lnr-user"></span>
						</span>
                    </div>
                    @if ($errors->has('nick'))
                        <div class="m-b-16">
                            <span class="help-block">
                                <strong>{{ $errors->first('nick') }}</strong>
                            </span>
                        </div>
                    @endif

                    <div class="wrap-input100 validate-input m-b-16" data-validate = "Valid slogan is required">
                        <input class="input100" type="text" name="slogan" placeholder="Slogan" value="{{ old('slogan') }}" required autofocus>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
							<span class="lnr lnr-star"></span>
						</span>
                    </div>
                    @if ($errors->has('slogan'))
                        <div class="m-b-16">
                            <span class="help-block">
                                <strong>{{ $errors->first('slogan') }}</strong>
                            </span>
                        </div>
                    @endif

                    <div class="wrap-input100 validate-input m-b-16" data-validate = "Valid email is required: ex@abc.xyz">
                        <input class="input100" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
							<span class="lnr lnr-envelope"></span>
						</span>
                    </div>
                    @if ($errors->has('email'))
                        <div class="m-b-16">
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        </div>
                    @endif

                    <div class="wrap-input100 validate-input m-b-16" data-validate = "Password is required">
                        <input class="input100" id="password" type="password" name="password" placeholder="Password" required>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
							<span class="lnr lnr-lock"></span>
						</span>
                    </div>

                    @if ($errors->has('password'))
                        <div class="m-b-16">
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        </div>
                    @endif

                    <div class="wrap-input100 validate-input m-b-16" data-validate = "Confirm password is required">
                        <input class="input100" id="password-confirm" type="password" name="password_confirmation" placeholder="Confirm password" required>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
							<span class="lnr lnr-lock"></span>
						</span>
                    </div>

                    <div class="container-login100-form-btn p-t-25">
                        <button type="submit" class="login100-form-btn">
                            Register
                        </button>
                    </div>

                    <div class="text-center w-full p-t-42 p-b-22">
						<span class="txt1">
							Or register with
						</span>
                    </div>

                    <a href="#" class="btn-face m-b-10">
                        <i class="fa fa-facebook-official"></i>
                        Facebook
                    </a>

                    <a href="#" class="btn-google m-b-10">
                        <img src="images/icons/icon-google.png" alt="GOOGLE">
                        Google
                    </a>

                    <div class="text-center w-full p-t-77">
						<span class="txt1">
							Is a member?
						</span>

                        <a class="txt1 bo1 hov1" href="{{route('login')}}">
                            Sign in now
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
