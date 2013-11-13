@foreach($errors->all('<div class="alert alert-danger fade in"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>:message</div>') as $error)
	{{ $error }}
@endforeach