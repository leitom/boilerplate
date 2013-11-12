<title>{{ $title }}</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

@section('head.styles')
{{ BoilerplateAsset::style('lib/bootstrap-3.0.2/bootstrap.min.css') }}
@show

@section('head.scripts')
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
{{ BoilerplateAsset::script('lib/html5shiv-3.7.0/html5shiv.min.js') }}
{{ BoilerplateAsset::script('lib/respond-1.3.0/respond.min.js') }}
<![endif]-->
@show