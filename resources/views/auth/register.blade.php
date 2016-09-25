@extends('app')

<link href="{{asset('css/register.css')}}" rel="stylesheet" type="text/css">
<script src="{!! asset('js/jquery-3.1.0.min.js') !!}" type="text/javascript"></script>
<script src="{!! asset('js/registerJS.js') !!}" type="text/javascript"></script>

@section('content')


	<div class="body">
		<div class="panel-heading"><span>YuConnect- Register Form</span></div>

					<form class="form-horizontal" onsubmit="validacija();" id="formID" role="form" method="POST" action="{{ url('/auth/register') }}" enctype="multipart/form-data" files="true">
						{!! csrf_field() !!}

						<div class="form-groupName">
							<label class="labelName">Name</label>
							<div class="col-md-6">
								<input id="nameName" type="text" class="form-control" name="name" value="{{ old('name') }}"><span id="resultName"></span>
							</div>
						</div>

						<div class="form-group">
							<label class="labelEmail">E-Mail Address</label>
							<div class="col-md-6">
								<input type="email" id="mail" class="form-control" name="email" value="{{ old('email') }}"><span id="resultEmail"></span>
							</div>
						</div>

						<div class="form-groupPhoto">
							<label class="labelPhoto">Choose photo: <small>(optional)</small></label><br>
							<input type="file" name="photoToUpload" id="photoToUpload">
						</div>

						<div class="form-group">
							<label class="labelPass">Password</label>
							<div class="col-md-6">
								<input id="passw" type="password" class="form-control" name="password"><span id="resultPass"></span>
							</div>
						</div>

						<div class="form-group">
							<label class="labelRepeatPass">Confirm Password</label>
							<div class="col-md-6">
								<input id="repeatPassw" type="password" class="form-control" name="password_confirmation"><span id="resultRepeatPass"></span>
							</div>
						</div>

						@if (count($errors) > 0)
							<div id="errorInput">
								<p><strong>Whoops!</strong> There were some problems with your input.</p>
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif

						<div class="form-groupButton">
							<div class="col-md-6 col-md-offset-4">
								<button id="btnRegister" type="submit" class="btn btn-primary">
									Register
								</button>
							</div>
						</div>
					</form>
		</div>

@endsection
