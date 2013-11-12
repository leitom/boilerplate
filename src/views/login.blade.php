@section('head.styles') @parent
{{ BoilerplateAsset::style('login.css') }}
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            
            @if (Session::has('loginError'))
            <div class="clear-fix">&nbsp;</div>
            <div class="alert alert-danger">
              <span class="glyphicon glyphicon-warning-sign"></span> {{ Session::get('loginError') }}
            </div>
            @endif

            @if (Session::has('logoutMessage'))
            <div class="clear-fix">&nbsp;</div>
            <div class="alert alert-info">
              <span class="glyphicon glyphicon-info-sign"></span> {{ Session::get('logoutMessage') }}
            </div>
            @endif

            <div class="account-wall">
                <img class="profile-img" src="{{ BoilerplateAsset::image('login.png') }}" alt="">
                {{ Form::open(array('route' => 'app.sessions.store', 'class' => 'form-signin')) }}
                {{ Form::text('username', null, array('class' => 'form-control', 'placeholder' => trans('leitom.boilerplate::sessions.username'), 'required', 'autofocus')) }}
                {{ Form::password('password', array('class' => 'form-control', 'placeholder' => trans('leitom.boilerplate::sessions.password'), 'required')) }}
                <button class="btn btn-lg btn-primary btn-block" type="submit">{{ trans('leitom.boilerplate::sessions.signin') }}</button>
                <label class="checkbox pull-left">
                    {{ Form::checkbox('remember', '1', false) }}
                    {{ trans('leitom.boilerplate::sessions.remember_me') }}
                </label>
                <a href="#" class="pull-right need-help">{{ trans('leitom.boilerplate::sessions.forgot_password') }} </a><span class="clearfix"></span>
                {{ Form::close() }}
            </div>
            @if (Config::get('leitom.boilerplate::allowUserRegistrations'))
            <a href="#" class="text-center new-account">{{ trans('leitom.boilerplate::sessions.create_an_account') }} </a>
            @endif
        </div>
    </div>
</div>
@stop