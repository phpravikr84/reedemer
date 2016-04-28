@extends('app')

@section('content')
<div class="container"> 
	<div class="well well-sm">
        <strong>Search for my logo</strong>
        
    </div>   
    <div id="products" class="row list-group">
    	@foreach($logo_details as $logo)
        <div class="item  col-md-4 col-xs-4">
            <div class="thumbnail">
                <img class="group list-group-image" src="{{env('SITE_PATH')}}uploads/original/{{$logo->logo_name}}" alt="" />                
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
@section('styles')
<style>




</style>
@endsection
