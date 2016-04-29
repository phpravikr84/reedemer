@extends('app')

@section('content')
<div class="container"> 
    <div id="products" class="row list-group col-md-8"> 
		<div class="um-form margin-right-10">
			@if ($errors->has())
				<div class="p-l-20 p-r-20 p-b-20">
					<div class="alert alert-danger">
						@foreach ($errors->all() as $error)
							{{ $error }}<br>        
						@endforeach
					</div>
				</div>
			@endif
			@if (Session::get('message'))
				<div class="p-l-20 p-r-20 p-b-20">
					<div class="alert alert-success">
						{{Session::get('message')}}
					</div>
				</div>
			@endif

			<form name="add_user" id="add_user" action="{{url()}}/partner/store" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="logo_id" value="">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="um-row _um_row_1 ">
					<div class="um-col-1">
						
						<p>Yet to implement this functionality</p>	
					</div>
				</div>				
				<!-- <div class="um-col-alt">
					<div class="um-left um-half">
						<input type="submit" id="upload" class="um-button" value="Upload File">
					</div>
					<div class="um-right um-half">
						
					</div>
					<div class="um-clear"></div>
				</div> -->
			</form>
		</div>       
    </div> 
    <div id="products" class="row list-group col-md-4"> 
    	<h2>New User ?</h2>
    	<p>
    		By creating an account you'll be able to move through the checkout process faster, view and track your orders, create offers and more.
    	</p>
    	<p>
    		Store owners, you will be able to customize your offers to redeemar and start building your loyalt program
    	</p>
    	<p>
    		Existing owners sign in
    	</p>
    </div>
</div>
@endsection
@section('styles')
<style>
</style>
@endsection
@section('scripts')
<script>
    // $(document).ready(function(){
    //     $("#register").click(function(){
    //         alert("a");
    //     });

        

    });
</script>
@endsection
