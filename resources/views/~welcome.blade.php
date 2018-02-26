@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              @if(Session::has('success')) 
                <div class="text-center success-message" role="alert">
                  <strong>
                    {!! Session::get('success') !!}
                  </strong>
                </div>
              @endif 
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    Your Application's Landing Page.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
