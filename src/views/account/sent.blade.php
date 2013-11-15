@section('content')
<div class="container">
    <div class="row">
    	<div class="panel panel-default">
		  <div class="panel-body">
		    Thank you {{ $user->userProfile->firstname }} {{ $user->userProfile->lastname }} for registering at our site!<br />
			An email with activation details are sent to your registered email address.
		  </div>
		</div>
	</div>
</div>
@stop