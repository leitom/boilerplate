<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>User Account Activation</h2>

		<div>
			To activate your account on boilerplate.com, visit this url: {{ URL::to($path, array($token)) }}.
		</div>
	</body>
</html>