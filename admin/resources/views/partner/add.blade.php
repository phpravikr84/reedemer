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

			<form name="add_user" id="add_user" action="{{url()}}/partner/store" method="POST">
				<input type="hidden" name="logo_id" value="{{ $logo_id }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="um-row _um_row_1 ">
					<div class="um-col-1">
						@if($logo_id>0)
						<div class="um-field um-field-user_login um-field-text">
							<div class="um-field-label">
								<label for="company_name">Logo</label>
								<div class="um-clear"></div>
							</div>
							<div class="um-field-area">
								<img  width="200" src="{{url()}}/{{env('SITE_PATH')}}uploads/original/{{$logo_details['logo_name']}}" />
							</div>
						</div>
						@endif
						<div class="um-field um-field-user_login um-field-text">
							<div class="um-field-label">
								<label for="company_name">Company Name</label>
								<div class="um-clear"></div>
							</div>
							<div class="um-field-area">
								<input type="text" placeholder="Company Name" value="@if(old('company_name')){{old('company_name')}}@else {{$logo_details['logo_text']}}@endif" id="" name="company_name" class="um-form-field valid ">
							</div>
						</div>
						<div data-key="address" placeholder="Address" class="um-field um-field-last_name um-field-text">
							<div class="um-field-label">
								<label for="address">Address</label>
								<div class="um-clear"></div>
							</div>
							<div class="um-field-area">
								<input type="text" placeholder="" value="{{ old('address') }}" id="" name="address" class="um-form-field valid ">
							</div>
						</div>
						<div data-key="user_email" class="um-field um-field-user_email um-field-text">
							<div class="um-field-label">
								<label for="user_email-10786">E-mail</label>
								<div class="um-clear"></div>
							</div>
							<div class="um-field-area">
								<input type="text" placeholder="E-mail" value="{{ old('user_email') }}" id="" name="user_email" class="um-form-field valid ">
							</div>
						</div>
						<div data-key="address" class="um-field um-field-last_name um-field-text">
							<div class="um-field-label">
								<label for="web-address">Web Address(i.e. http://www.yourdomain.com)</label>
								<div class="um-clear"></div>
							</div>
							<div class="um-field-area">
								<input type="text" placeholder="Web Address" value="{{ old('web_address') }}" id="" name="web_address" class="um-form-field valid">
							</div>
						</div>
						<div data-key="address" class="um-field um-field-last_name um-field-text">
							<div class="um-field-label">
								<label for="password">Password(At least 6 charcter long)</label>
								<div class="um-clear"></div>
							</div>
							<div class="um-field-area">
								<input type="password" value="" placeholder="Password" id="" name="user_password" class="um-form-field valid ">
							</div>
						</div>

						<div data-key="retype-password" class="um-field um-field-last_name um-field-text">
							<div class="um-field-label">
								<label for="address">Retype Password</label>
								<div class="um-clear"></div>
							</div>
							<div class="um-field-area">
								<input type="password" placeholder="Retype Password" value="" id="confirm_user_password" name="confirm_user_password" class="um-form-field valid ">
							</div>
						</div>
						
					</div>
				</div>
				<p>
					<input type="checkbox" value="1" id="owner" name="owner">I  am the Owner of this Company
				</p>
				<p>				
					<input type="checkbox" value="1" id="create_offer_permission" name="create_offer_permission">I have been given permission on behalf of
					the company to create new offers and purchase redeemar products. 
				</p>
				<div class="um-col-alt">
					<div class="um-left um-half">
						<input type="submit" id="register" class="um-button" value="Register">
					</div>
					<div class="um-right um-half">
						
					</div>
					<div class="um-clear"></div>
				</div>
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
    	<p>
    		<button onclick="window.location='{{url()}}/auth/login'" type="button" class="btn btn-primary">Sign In</button>
    		<!-- <input type="button" id="sign_in" class="um-button" value="Sign In">-->
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

        

//    });
</script>
@endsection
