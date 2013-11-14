<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>User Account Activation</h2>
		<p>Hello, {{ $user->userProfile->firstname }} {{ $user->userProfile->lastname }} </p>
		<div>
			To activate your account on boilerplate.com, visit this url: {{ URL::route($path, array($token)) }}.
		</div>
	</body>
</html>