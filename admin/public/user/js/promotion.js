
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

    $( "#c_s_date" ).datepicker({         
        dateFormat:"mm/dd/yy",
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
   
   x.post("../inventory/list").success(function(data_response){              
        a.inventory_details = data_response; 
        a.file_path=site_path;  
    });           
  
    

  
}]);