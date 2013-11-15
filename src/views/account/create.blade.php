@extends('leitom.boilerplate::public_master')
@section('head.styles') @parent
{{ BoilerplateAsset::style('account.css') }}
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4 well well-sm">
            <legend><i class="glyphicon glyphicon-globe"></i> {{ trans('leitom.boilerplate::account.signup') }}</legend>
            
            @include('leitom.boilerplate::_partials.error_alert')

            {{ Form::open(array('route' => BoilerplateURL::route('account.store'), 'class' => 'form', 'role' => 'form')) }}
            <div class="row">
                <div class="col-xs-6 col-md-6">
                    {{ Form::text('firstname', null, array('class' => 'form-control', 'placeholder' => trans('leitom.boilerplate::user.firstname'), 'required' => 'required', 'autofocus' => 'autofocus')) }}
                </div>
                <div class="col-xs-6 col-md-6">
                    {{ Form::text('lastname', null, array('class' => 'form-control', 'placeholder' => trans('leitom.boilerplate::user.lastname'), 'required' => 'required')) }}
                </div>
            </div>
            {{ Form::text('email', null, array('class' => 'form-control', 'placeholder' => trans('leitom.boilerplate::user.email'), 'required' => 'required')) }}
            {{ Form::text('email_confirmation', null, array('class' => 'form-control', 'placeholder' => trans('leitom.boilerplate::user.email_re_enter'), 'required' => 'required')) }}
            {{ Form::text('username', null, array('class' => 'form-control', 'placeholder' => trans('leitom.boilerplate::user.username'), 'required' => 'required')) }}
            {{ Form::password('password', array('class' => 'form-control', 'placeholder' => trans('leitom.boilerplate::user.password'), 'required' => 'required')) }}
            {{ Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' => trans('leitom.boilerplate::user.password_re_enter'), 'required' => 'required')) }}
            <button class="btn btn-lg btn-primary btn-block" type="submit">{{ trans('leitom.boilerplate::account.signup') }}</button>
            {{ Form::close() }}
        </div>
    </div>
</div>
@stop