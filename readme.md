# Leitom/Boilerplate documentation
- Author Tommy Leirvik
- Email leirvik.tommy@gmail.com

### ps.: dont use this package yet, it's in development!

# Installation notes
- add Leitom\Boilerplate\BoilerplateServiceProvider to your provider array in config/app.php
- run php artisan migrate -package leitom/boilerplate
- run php artisan db:seed -package leitom/boilerplate

# Configurating auth
- Add Eloquent as the auth driver
- Use Leitom\Boilerplate\User as the model
- Set users as the table
- Dont use any filters on the auth part! app/filters.php

# Routes
- The default namespace for an application built uppon Leitom/Boilerplate is app
- example: app/login

# Views
- The view namespace for the boilerplate package is leitom.boilerplate
- usage in code: View::make(leitom.boilerplate::login);
- usage in templates: @extends('leitom.boilerplate::master');, @include('leitom.boilerplate::_partials.head');

# Boilerplate assets
- Boilerplate assets placeholders:
- in head there are on placeholder for styles and scripts called head.styles, head.scripts to add styles from any template:
- example: @section('head.styles') @parent <my style> @stop
- At the bottom of the master layout you have footer.scripts

# Boilerplate helpers

## Asset helper
- Boilerplate assets can be refered trough the BoilerplateAsset::function accessor
- example: BoilerplateAsset::style('lib/bootstrap-3.0.2/bootstrap.min.css');
- The asset helper can be reffered to with Boilerplate::<type>
- Supported types are style, script and image
- script and syle returns larvel HTML::script/style

## Url helper
- Boilerplate url helper can be refered trough the BoilerplateURL::function accessor
### Supported types:
- BoilerplateURL::route return a route with prefix set in configuration example: BoilerplateURL::route('sessions.store') // outputs app.sessions.store by default
- BoilerplateURL::routeTo return a route with prefix set in configuration as an url example: BoilerplateURL::routeTo('sessions.store') // outputs http://www.domain.com/app/sessions/store
- BoilerplateURL::to return a url with prefix set in configuration example: BoilerplateURL::to('new-account') // outputs http://www.domain.com/app/new-account by default