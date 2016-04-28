@extends('app')

@section('content')
<div class="container"> 
	<div class="well well-sm">
		<div class="col-md-4 col-xs-4">
        	<strong>Search for my logo</strong>
        </div>
	    <div class="searchform-wrapper">
	    	<form id="live-search" action="" class="styled" method="post">
	         <input type="text" class="text-input" id="filter" value="" />
        	 <span id="filter-count"></span>
	    	</form>
	    </div>
	    
    </div>

    <div class="demo-grid-2 mdl-grid">              
	  <div class="mdl-cell border-box mdl-cell--12-col">                
	    <div id="myWorkContent">
	       <ul style="margin:0; padding:0">
	       	  @foreach($logo_details as $logo)
	          <li class="image_container">
	            <div class="text_div">
	              <input type="radio" onclick="show_big_image('{{$logo->id}}','{{$logo->logo_name}}','{{$logo->tracking_rating}}');" value="{{$logo->id}}" name="company_logo_id" class="image_click checkboxs">
	            </div>
	            <div class="image_div">
	              <img  width="120" src="{{env('SITE_PATH')}}uploads/original/{{$logo->logo_name}}">
	            </div> 
	          </li>
	          @endforeach	         
	       </ul>                   
	   </div>
	  </div>
	</div>  
	<div class="demo-grid-2 mdl-grid"> 
		<input type="button" name="save_logo" id="save_logo" value="Save as my logo" />
	</div>
	<div class="demo-grid-2 mdl-grid"> 

	<div class="logo_div col-md-5 col-xs-5 ">
		<div class="mdl-cell border-box border-box mdl-cell--6-col">
			<div><h3>Logo Creator</h3></div>
			<div>
			<div class="center"><h3>Upload File</h3></div>
			<div>
				<p class="small"><small>JPG/JPEG formats</small></p>
				<p class="small"><small>2 MB Max File Size</small></p>                      
			</div>
			<div>
				<p>
					<input type = "file" ng-model="Logo.logo_name" file-model = "myFile" id="logo_name" />
				</p>
				<p><hr></p>
				<p class="small"> 
					By uploading the file, you certify that you own the copyright for these photos or are authorized by the 
					owner to make a photo-to-canvas reproduction. 
				</p>  
				<p class="small">                        
					<strong>My logo does not receive a minimum star rating.</strong>        
				</p>
				<p class="small" style="vertical-align:top;"> 
					<input type="checkbox" name="enhance_logo" id="enhance_logo" ng-model="Logo.enhance_logo" value="1" /><strong>Allow redeemar to professionaly enhance my logo for best result</strong>
				</p> 
				<div  class="m-t-30 pull-right" style="margin:0 5px 5px 0;">
					<div class="m-t-20">   
						<button id="add_logo"  ng-click = "add_logo()" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
							Upload
						</button>
					</div>
				</div>            
			</div>                   

			</div> 
		</div>
	</div>
	<div class="col-md-1 col-xs-1 ">&nbsp;	</div>       
	<div id="logo_details_div" class="logo_div col-md-6 col-xs-6" >		
		<div>
			<div>
				<div><h2>Congratulations !</h2></div>
				<div><h4>We have found your logo</h4> </div>
				<div id="big_image">                        
					<img width="150" src="../../uploads/blank-img-1.png" id="logo_image_first" >
				</div>
			</div>  			           
			<div class="col-md-4 col-xs-4" id="rate_div"></div>
			
		</div> 		
	</div>

    <!-- <div id="products" class="row list-group">
    	@foreach($logo_details as $logo)
        <div class="col-md-4 col-xs-4">
            <div class="thumbnail">
                <img class="group list-group-image" src="{{env('SITE_PATH')}}uploads/original/{{$logo->logo_name}}" alt="" />                
            </div>
        </div>
        @endforeach
    </div> -->
</div>

@endsection
@section('styles')
<style>
</style>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $("input[name='save_logo']").click(function(){
            var logo_id = $("input[name='company_logo_id']:checked").val();
            window.location.href='partner/add/'+logo_id;
            // if(logo_id){

            //     alert("Your are a - " + logo_id);

            // }

        });

        

    });

function show_big_image(image_id,image_name,rating_val) 
{   
   $("#logo_details_div").show(500);
   $("#big_image").html('<img  width="200" src="../uploads/original/'+image_name+'" />');  
   $("#rate_div").html('<div id="rateYo"></div>');
   $("#rateYo").rateYo({
	    rating: rating_val,
	    readOnly: true,
	    starWidth: "50px"
   });
}

// $( "#save_logo" ).click(function() {
//   alert( "Handler for .click() called." );
// });

</script>
@endsection
