@extends('app')

@section('content')
    <h1 class="page-heading">Confirm</h1>
    {!! Form::open(['action' => 'NoticesController@store']) !!} <!-- // POST => /notices -->
        <div class="form-group">
            {!! Form::textarea('template', $template, ['class' => 'form-control']) !!}
        </div>
    
        <div class="form-group">
            {!! Form::submit('Deliver DMCA Notice Now', ['class' => 'btn btn-primary form-control']) !!}
        </div>
        
    {!! Form::close() !!}    
@endsection