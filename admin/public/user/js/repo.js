
"use strict";

var MyApp = angular.module("repo-app", ["ngFileUpload"]);



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


MyApp.controller('RepoController',["$scope", "PlaceholderTextService", "ngTableParams", "$filter", "$http", "fileToUpload",function (a, b, c, d, x, fu) {          
    //a.dataLength={filtered:[]};
   // a.cnames = [];
   // a.campaign_details = [];
   // var site_path=$("#site_path").val();
    
    x.get("../directory/show").success(function(response){
      //alert("V");
    });
    //alert("C");
   // alert("a");
    //Load Calender when page load
   // $("#c_s_date").datepicker();
    a.add_folder = function(){
    // a.logo_details = a.repodetails;
      //var dir_name=a.repodetails.dir_name;
        //http://localhost/reedemer/admin/public/directory/store
        x.post("../directory/store",a.repodetails).success(function(response){
          if(response=="success")
          {
              var main_site_url=$("#main_site_url").val();                
              var redirect_url=main_site_url+'/user/dashboard#/repository/add';

              $("#error_div").hide();
              $("#show_message").slideDown();
              $("#success_div").html("Data inserted successfully. <br />Please wait,we will redirect you to listing page.");
              $("#success_div").show();              

              setTimeout(function() { 
                window.location.href = redirect_url; 
              }, 5000);                                        
          }
          else if(response=="error")
          {
              $("#error_div").hide();
              $("#show_message").slideDown();
              $("#error_div").html("Please insert all field.");
              $("#error_div").show();
              $("#success_div").hide();                                  
          }
          else if(response=="folder_exists")
          {
              $("#error_div").hide();
              $("#show_message").slideDown();
              $("#error_div").html("Folder you enter already exists. Please try with diffrent name.");
              $("#error_div").show();
              $("#success_div").hide();                                  
          }
      });
    // alert(JSON.stringify(dir_name, null, 4));
    }; 

    //console.log('data :: '+JSON.stringify(a.repodetails.dir_name, null, 4)); 
  
   
}]);