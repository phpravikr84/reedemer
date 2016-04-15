
"use strict";

var MyApp = angular.module("logo-app", ["ngFileUpload"]);



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
        // console.log('data :: '+JSON.stringify(postData, null, 4)); 
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


MyApp.controller('LogoController',["$scope", "PlaceholderTextService", "ngTableParams", "$filter", "$http", "fileToUpload",function (a, b, c, d, x, fu) {          
    var site_path=$("#site_path").val();
    a.searchText   = '';     // set the default search/filter term          
    $("#logo_details_div").hide();
    $("#loading_div").hide();   

            
    x.get("../admin/dashboard/alllogo").success(function(data_response){              
        a.logo_details = data_response;
        a.file_path=site_path;       
       // console.log('data :: '+JSON.stringify(a.file_path, null, 4));           
    }); 

  
    a.add_logo = function(){
      var file = a.myFile;
      var logo_name=$("#logo_name").val() ;

      $('#add_logo').prop('disabled', true);
      $("#add_logo").text('Saving..'); 

      var ext = $('#logo_name').val().split('.').pop().toLowerCase();
      if($.inArray(ext, ['jpg','jpeg']) == -1) {
        
        // showing error message if image not upload or not .jpg type 
        $("#notification_success").hide();
        $("#notification_info").hide();
        $("#notification").slideDown();
        $("#notification_error").html("Please upload only .jpg /.jpeg image.");       

        $('#add_logo').prop('disabled', false);
        $("#add_logo").text('Upload');

        setTimeout(function() { 
          $("#notification").slideUp();
        }, 5000);      

        return false;
      }

      /*if($("#logo_text").val()=='')
      {
        // showing error message if logo text is blank 
        $("#notification_success").hide();
        $("#notification_info").hide();
        $("#notification").slideDown();
        $("#notification_error").html("Please type logo text.");       

        $('#add_logo').prop('disabled', false);
        $("#add_logo").text('Upload');

        setTimeout(function() { 
          $("#notification").slideUp();
        }, 5000);  
        return false;
      } */

      a.logo=[];
      var uploadUrl = "../admin/dashboard/uploadlogo";  
      fu.uploadNewFileToUrl(file, uploadUrl, logo_name).then(function(fdata){
        //alert("a");
          var logo_name = fdata.data;
          a.logo.logo_name=logo_name;
          //var logo_text = a.Logo.logo_text;
          var logo_text='demo';
          if($("#enhance_logo").prop("checked")==true)
          {
            var enhance_logo = 1;
          }
          else
          {
           var enhance_logo = 0; 
          }
          a.logo.logo_name=enhance_logo;

         // alert(logo_name);
         // return false;
         // alert(enhance_logo);
          //console.log('data :: '+JSON.stringify(a.logo, null, 4)); 
          //return false;

           x.get("../admin/dashboard/addlogo/"+logo_text+"/"+logo_name+"/"+enhance_logo).success(function(response_back){
            //x.get("../admin/dashboard/addlogo/").success(function(response_back){
            //alert(response_back);
            //return false;
            //console.log('data :: '+JSON.stringify(response_back, null, 4));  
            if(response_back.response=="success")
            {
                var main_site_url=$("#main_site_url").val();                
                var redirect_url=main_site_url+'/user/dashboard#/tables/logo';                                
               

                $("#notification_success").hide();
                $("#notification_error").hide();
                $("#notification").slideDown();
                $("#notification_info").html("Data inserted successfully. It can take maximum 5 minutes to receive your image rating.");
                $("#notification_info").show();              

                setTimeout(function() { 
                  $("#notification").slideUp();
                }, 5000);                                         
            }
          })         
          //console.log('data :: '+JSON.stringify(response_back, null, 4));           
      });
    };

    
    a.save_logo=function(){   
   // alert("a") ;
       var logo_details=a.userlogo;            
       //alert("a")   ;enhance_logo
       console.log('data :: '+JSON.stringify(logo_details, null, 4)); 
       return false;
    };

    a.delete_user_logo=function(){
      //alert("a") ;
      var itemId = $("#user_logo_id").val();      
      //console.log('data :: '+JSON.stringify(logo_details, null, 4)); 
      //return false;
      if(confirm("Are you sure?"))
      { 
        $("#logo_details_div").hide(500);
        x.get("../admin/dashboard/deletelogo/"+itemId).success(function(response){
          $("#error_div").hide();
          $("#show_message").slideDown();
          $("#success_div").html("Data deleted successfully. <br />Please wait,we will reload this page for you.");
          $("#success_div").show();              

          setTimeout(function() {         
            window.location.reload();  
          }, 5000);                  
        })
      }
    };

    a.show_rating=function(itemId){                
       var main_site_url=$('#main_site_url').val();
       $("#loading_div").show();  
       $("#rating_div").hide(); 
       $("#logo_details_div").hide(); 
       //$("#user_logo_id").val();
      // user_logo_id
       
       x.get("../admin/dashboard/logodetails/"+itemId).success(function(data_response){
            $("#logo_details_div").show();
            $("#loading_div").hide();  
            $("#rating_div").show(); 
            a.tracking_rating=data_response[0].tracking_rating;
            a.logo_name=data_response[0].logo_name;    
            //$("#user_logo_id").val(a.tracking_rating);               
            //a.user_logo_id=a.tracking_rating;            
            a.userlogo = {user_logo_id: itemId};
            $( "#rateYo" ).hide();
            $( "#rating_div" ).after( '<div id="rateYo"></div>' );
            $("#rateYo").rateYo({
                rating: a.tracking_rating,
                readOnly: true
            });
       });         
    };

    
}]);