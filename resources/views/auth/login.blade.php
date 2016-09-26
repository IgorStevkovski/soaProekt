@extends('app')

<link href="{{asset('css/login.css')}}" rel="stylesheet" type="text/css">
<script src="{!! asset('js/jquery-3.1.0.min.js') !!}" type="text/javascript"></script>
<script src="{!! asset('js/loginJS.js') !!}" type="text/javascript"></script>

@section('content')
				<div class="body">
					<div id="loginName">
						<div id="textLoginDiv">
							<span>Login Page</span>
						</div>
						<div id="linkRegisterDiv"><a href="auth/register" id="linkRegister">Register now!</a></div>
					</div>

					<div id="divFormID">
					<form  role="form"  method="POST" action="{{ url('/auth/login') }}" id="formID">
						{!! csrf_field() !!}

						<div class="form-groupa">
							<label id="labelEmail">E-Mail Address:</label>
							<div class="col-md-6">
								<input type="email" id="mail" class="form-control" name="email" value="{{ old('email') }}"><span id="resultEmail"></span>
							</div>
						</div>

						<div class="form-groupa">
							<label id="labelPass">Password:</label>
							<div class="col-md-6">
								<input type="password" id="passw" class="form-control" name="password"><span id="resultPass"></span>
							</div>
						</div>

						<div class="form-groupa">
							<div class="checkbox">
									<label id="labelCheckBox">
										<input type="checkbox" name="remember"> Remember Me
									</label>
							</div>
						</div>

						@if (count($errors) > 0)
							<div class="alert-errorInput" id="greski">
								<p><strong>Whoops!</strong> There were some problems with your input!</p>
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif

						<div class="form-groupaButton">
								<button type="submit"  class="btn-submit" id="btnSubmit">Login</button>
								{{--<a class="btn btn-link" href="{{ url('/password/email') }}">Forgot Your Password?</a>--}}
						</div>
					</form>
					</div>
					{{--<iframe id="karta" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d181139.35491205094!2d20.282511716591962!3d44.81540328988179!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x475a7aa3d7b53fbd%3A0x1db8645cf2177ee4!2sBelgrade%2C+Serbia!5e0!3m2!1sen!2s!4v1473979161535" width="500" height="250" frameborder="0" style="border:0" allowfullscreen></iframe>--}}
				</div>


@endsection
