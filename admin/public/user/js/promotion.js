
"use strict";

var MyApp = angular.module("promotion-app", ["ngFileUpload"]);



MyApp.factory("fileToUpload", ["$http", function(h){

  var promise;
  var fileUpload = {
    uploadNewFileToUrl: function(file, uploadUrl, data) {
      var fd = new FormData();
      fd.append('file', file);
      var postData = {
        transformRequest: angular.identity,
        headers: {'Content-Type': undefined},
        data:data
      };
      if ( !promise ) {
        // $http returns a promise, which has a then function, which also returns a promise
        promise = h.post(uploadUrl, fd, postData).success(function(response){          
           return response;
        }).error(function(){
          $("#show_error_msg").show();
        });
      }
      // Return the promise to the controller
      return promise;
    }
  };
  return fileUpload;
}]);


MyApp.controller('PromotionController',["$scope", "PlaceholderTextService", "ngTableParams", "$filter", "$http", "fileToUpload",function (a, b, c, d, x, fu) {          
    //a.dataLength={filtered:[]};
    //a.cnames = [];
    //a.inventory_details = [];   
    var site_path=$("#site_path").val();

    $( '#campaign_id' ).change(function() {       
        var campaign_id=$("#campaign_id").val();
        //alert(campaign_id);
        x.get("../campaign/campaigndetails/"+campaign_id).success(function(response_details){              
          //alert(JSON.stringify(response_details[0].start_date,null,4));
          //a.campaign_list = response; 
          //a.file_path=site_path;  
          //a.campaign_list = response_details; 
          //a.campaign_list.c_s_date="05/05/2016"
          //http://localhost/reedemer/admin/public/admin/dashboard/category

          $( "#c_s_date" ).datepicker({         
            dateFormat:"mm/dd/yy",
           // minDate:response_details[0].start_date,
            onSelect: function (selected) {
              var dt = new Date(selected);
              dt.setDate(dt.getDate() + 1);
              $("#c_e_date").datepicker("option", "minDate", dt);
            }

          });

          $( "#c_e_date" ).datepicker({
            dateFormat:"mm/dd/yy",
            onSelect: function (selected) {
              var dt = new Date(selected);
              dt.setDate(dt.getDate() - 1);
              $("#c_s_date").datepicker("option", "maxDate", dt);
            }
          });
        }); 

    });  

    
   
    x.post("../campaign/list").success(function(response){              
      //alert(JSON.stringify(response,null,4));
      a.campaign_list = response; 
      a.file_path=site_path;  
    }); 

    x.get("../admin/dashboard/category").success(function(response_cat){              
      //alert(JSON.stringify(response_cat,null,4));
      a.cat_list = response_cat; 
     // a.file_path=site_path;  
    }); 


    // $("input[type='button']").click(function(){
    // var radioValue = $("input[name='gender']:checked").val();
    // if(radioValue){
    // alert("Your are a - " + radioValue);
    // }
    // });     

   
    // Change total price value with no of redeemar change
    $( '#total_redeemar' ).keyup(function() {       
       var selectd_val=$('input[name="total_payment"]:checked').val();       
       var total_price=selectd_val*$("#total_redeemar").val();
              
       $("#total_redeemar_price").val(total_price);
    });   

    // Change total price value with radio button click
    $('input[name="total_payment"]').on('change', function() {
       var selectd_val=$('input[name="total_payment"]:checked').val();        
       var total_price=selectd_val*$("#total_redeemar").val();      
       
       $("#total_redeemar_price").val(total_price);
    });       
  
    $( '#category_id' ).change(function() {  
        var category_id=$( '#category_id' ).val();
        //alert(category_id);
        if(category_id){
          $.ajax({
          type:'GET',
          url:'../../partner/subcategory/'+category_id,
          //data:'parent_id='+category_id,
          success:function(html){
          //alert(site_path);
          var new_html="<option value=''>----</option>";
          for(var i=0; i<html.length; i++)
          {
          new_html+="<option value='"+html[i].id+"'>"+html[i].cat_name+"</option>";
          }
          //alert(JSON.stringify(new_html,null,4));
          $('#subcat_id').html(new_html);
          }

          }); 
        }else{
        $('#subcat_id').html('<option value="">Select state first</option>'); 
        }


    });

}]);