@extends('app')

@section('content')
<div class="container"> 
	<div class="well well-sm">
		<div class="col-md-4 col-xs-4">
        	<strong>Search for my logo</strong>
        </div>
	    <div class="searchform-wrapper">
			<div class="demo-grid-2 mdl-grid"> 
				<input type="text" name="search" class="search" value="" placeholder="Search Your Friends" autocomplete="off">	
			</div>	    	
	    </div>	    
    </div>

    <div class="demo-grid-2 mdl-grid">              
	  <div class="mdl-cell border-box mdl-cell--12-col friends" >                
	    <div id="myWorkContent"   >
	       <ul style="margin:0; padding:0">
	       	  @foreach($logo_details as $logo)
		          <li class="image_container friend_holder fl" id="{{$logo->logo_text}}">
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
	<div class="demo-grid-2 mdl-grid margin-top-10"> 
		<div id="logo_details_div" class="logo_div col-md-6 col-xs-6" >		
		<div id="logo_section">
			<div>
				<div><h2>Congratulations !</h2></div>
				<div><h4>We have found your logo</h4> </div>
				<div id="big_image">                        
					<img width="150" src="../../uploads/blank-img-1.png" id="logo_image_first" >
				</div>
			</div>  			           
			<div class="col-md-4 col-xs-4" id="rate_div"></div>
			
		</div>
		<div id="msg_section">
			<h4>Please choose your logo to see its rating</h4>
		</div> 		
		</div>
	</div>
	<div style="clear:both;"></div>
	<div class="demo-grid-2 mdl-grid margin-top-10"> 
		<div id="products" class="row list-group">
		@foreach($logo_details as $logo)
		<div class="col-md-4 col-xs-4">
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
@section('scripts')
<script>
	$(document).ready(function(){
		$(".search").keyup(function(){
			var str = $(".search").val();
			$(".friends .friend_holder").each(function(index){
				if($(this).attr("id")){
					if(!$(this).attr("id").match(new RegExp(str, "i"))){
						$(this).fadeOut("fast");
					}else{
						$(this).fadeIn("slow");
					}
				}
			});		
		});
	});

	$(document).ready(function(){
		$( "#search_logo" ).click(function() {
			//var filter=$("#filter").val();
		    var values = $("#live-search").serialize();
		    //alert(values);
			$.ajax({
			    url: "partner/search",
			    type: "post",
			    data: values ,
			    success: function (response) {
			       // you will get response from your php page (what you echo or print)                 

			    },
			    error: function(jqXHR, textStatus, errorThrown) {
			       console.log(textStatus, errorThrown);
			    }


			});
		});
	});

    $(document).ready(function(){
    	$("#logo_section").hide();
    	$("#msg_section").show();
        $("input[name='save_logo']").click(function(){
        //	$("#logo_section").show(500);
            var logo_id = $("input[name='company_logo_id']:checked").val();
            if(!logo_id)
            {
            	logo_id=0;
            }
            window.location.href='partner/add/'+logo_id;
            // if(logo_id){

            //     alert("Your are a - " + logo_id);

            // }

        });

        

    });

function show_big_image(image_id,image_name,rating_val) 
{   
   $("#logo_details_div").show(500);
   $("#msg_section").hide();
   $("#logo_section").show(500);
   $("#big_image").html('<img  width="200" src="../../uploads/original/'+image_name+'" />');  
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
