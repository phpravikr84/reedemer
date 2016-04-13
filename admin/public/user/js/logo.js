
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
    });          
  
    a.add_logo = function(){
      var file = a.myFile;
      var logo_name=$("#logo_name").val()  
      
      var uploadUrl = "../admin/dashboard/uploadlogo";  
      fu.uploadNewFileToUrl(file, uploadUrl, logo_name).then(function(fdata){
          var logo_name = fdata.data;
          var logo_text="mmm";

          x.get("../admin/dashboard/addlogo/"+logo_text+"/"+logo_name).success(function(response_back){
           // alert(response_back);
            //console.log('data :: '+JSON.stringify(response_back, null, 4));  
            if(response_back.response=="success")
            {
                var main_site_url=$("#main_site_url").val();
                
                var redirect_url=main_site_url+'/user/dashboard#/tables/logo';                                   
               // window.location.href = redirect_url; 

                $("#error_div").hide();
                $("#show_message").slideDown();
                $("#success_div").html("Data inserted successfully. <br />Please wait,we will redirect you to listing page.");
                $("#success_div").show();              

                setTimeout(function() { 
                window.location.href = redirect_url; 
                }, 5000);                                          
            }
          })         
          //console.log('data :: '+JSON.stringify(response_back, null, 4));           
      });
    };



    a.show_rating=function(itemId){                
       var main_site_url=$('#main_site_url').val();
       $("#loading_div").show();  
       $("#rating_div").hide(); 
       $("#logo_details_div").hide(); 
       
       x.get("../admin/dashboard/logodetails/"+itemId).success(function(data_response){
            $("#logo_details_div").show();
            $("#loading_div").hide();  
            $("#rating_div").show(); 
            a.tracking_rating=data_response[0].tracking_rating;
            a.logo_name=data_response[0].logo_name;                   
            $( "#rateYo" ).hide();
            $( "#rating_div" ).after( '<div id="rateYo"></div>' );
            $("#rateYo").rateYo({
                rating: a.tracking_rating
            });
       });         
    };

    
}]);