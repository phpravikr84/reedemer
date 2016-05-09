@extends('app')

@section('content')
<div class="container"> 
	 @if($logo_details_unused->count() >0)
	<div class="well well-sm">
		<div class="col-md-4 col-xs-4">
        	<strong>Search for my logo</strong>
        </div>
	    <div class="searchform-wrapper">
			<div class="demo-grid-2 mdl-grid"> 
				<input type="text" name="search" class="search" value="" placeholder="Search Your Company" autocomplete="off">	
			</div>	    	
	    </div>	    
    </div>
   
    <div class="demo-grid-2 mdl-grid">              
	  <div class="mdl-cell border-box mdl-cell--12-col friends" >                
	    <div id="myWorkContent"   >
	       <ul style="margin:0; padding:0">
	       	  @foreach($logo_details_unused as $logo_unused)
		          <li style="cursor:pointer" class="image_container friend_holder fl" id="{{$logo_unused->logo_text}}" onclick="show_big_image('{{$logo_unused->id}}','{{$logo_unused->logo_name}}','{{$logo_unused->tracking_rating}}');">
		            <div class="image_div" id="image_div_{{$logo_unused->id}}" onclick="get_select({{$logo_unused->id}})">	
		            <label>    
		              <input type="radio"  value="{{$logo_unused->id}}" name="company_logo_id" class="image_click checkboxs">        	
		              <img  width="120" src="{{env('SITE_PATH')}}uploads/original/{{$logo_unused->logo_name}}">
		            </label>
		            </div> 
		          </li>
	          @endforeach	         
	       </ul>                   
	   </div>
	  </div>
	</div> 
	@endif 
	<div class="demo-grid-2 mdl-grid"> 
		@if($logo_details_unused->count() >0)
		<input type="button" name="save_logo_old" id="save_logo_old" value="Save as my logo" />
		@endif
		<input type="button" name="save_logo" id="save_logo" value="Register and upload logo" />
	</div>
	@if($logo_details_unused->count() >0)
	<div class="demo-grid-2 mdl-grid margin-top-10 details_div"> 
		<div id="logo_details_div" class="logo_div col-md-6 col-xs-6" >		
		<div id="logo_section">
			<div>
				<div><h2>Congratulations !</h2></div>
				<div><h4>We have found your logo</h4> </div>
				<div id="big_image">                        
					<img width="150" src="{{env('SITE_PATH')}}uploads/blank-img-1.png" id="logo_image_first" >
				</div>
			</div>  			           
			<div class="col-md-4 col-xs-4" id="rate_div"></div>
			
		</div>
		<div id="msg_section">
			<h4>Please choose your logo to see its rating</h4>
		</div> 		
		</div>
	</div>
	@endif
	<div style="clear:both;"></div>
	<div class="demo-grid-2 mdl-grid margin-top-10"> 
		<div id="products" class="row list-group">
		@foreach($logo_details as $logo)
		<div class="col-md-4 col-xs-4">
		    <div class="thumbnail">
		        <img class="group list-group-image" src="{{env('SITE_PATH')}}uploads/original/{{$logo->logo_name}}" alt="{{$logo->logo_text}}" width="150" />                
		    </div>
		</div>
		@endforeach
		</div>
	</div>

@endsection
@section('styles')
<style>
label > input{ /* HIDE RADIO */
  display:none;
}
label > input + img{ /* IMAGE STYLES */
  cursor:pointer;
  border:2px solid transparent;
}
label > input:checked + img{ /* (CHECKED) IMAGE STYLES */
  border:2px solid #f00;
}
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
            //var logo_id = $("input[name='company_logo_id']:checked").val();
            //if(!logo_id)
            //{
            	logo_id=0;
           // }
            window.location.href='partner/add/'+logo_id;
            // if(logo_id){

            //     alert("Your are a - " + logo_id);

            // }

        });

        

    });

    $(document).ready(function(){
    	$("#logo_section").hide();
    	$("#msg_section").show();
        $("input[name='save_logo_old']").click(function(){
        //	$("#logo_section").show(500);
            var logo_id = $("input[name='company_logo_id']:checked").val();         
            if(!logo_id)
            {
            	alert("Please select a logo.");
            	return false;
            }
            window.location.href='partner/add/'+logo_id;
            // if(logo_id){save_logo_old

            //     alert("Your are a - " + logo_id);

            // }

        });

        

    });

function show_big_image(image_id,image_name,rating_val) 
{   
   var site_path=$("#site_path").val();
  // alert(site_path);
   $("#logo_details_div").show(500);
   $("#msg_section").hide();
   $("#logo_section").show(500);
   $("#big_image").html('<img  width="200" src="'+site_path+'/uploads/original/'+image_name+'" width="150" />');  
   $("#rate_div").html('<div id="rateYo"></div>');
   $("#rateYo").rateYo({
	    rating: rating_val,
	    readOnly: true,
	    starWidth: "50px"
   });
}

function get_select(select_id)
{	
	$(".image_div").css({		
		'border':'',
		'box-shadow':'',
	})
	var select_id = '#image_div_'+select_id;
	$(select_id).css({		
		'border':'2px solid #8ec252',
		'box-shadow': '6px 6px 3px #888888'
	})
}
// $( "#save_logo" ).click(function() {
//   alert( "Handler for .click() called." );

// });





</script>
@endsection
