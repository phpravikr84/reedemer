
"use strict";

var MyApp = angular.module("campaign-app", ["ngFileUpload"]);



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


MyApp.controller('CampaignController',["$scope", "PlaceholderTextService", "ngTableParams", "$filter", "$http", "fileToUpload",function (a, b, c, d, x, fu) {          
    a.dataLength={filtered:[]};
    a.cnames = [];
    a.campaign_details = [];

   x.get("../campaign/list").success(function(data_response){              
        a.campaign_details = data_response;  
    });           
  
    a.addCampaign = function(){             
      var file = a.myFile;

      $('#add_campaign').prop('disabled', true);
      $("#add_campaign").text('Saving..');      

      var c_name = $('#c_name').val();
      var c_s_date = $('#c_s_date').val();
      var c_e_date = $('#c_e_date').val();
      var logo_name = $('#logo_name').val();
      
      if(c_name=='' || c_s_date=='' || c_e_date=='' || file=='')
      {
        $('#add_campaign').prop('disabled', false);
        $("#add_campaign").text('Save');

        a.show_error_msg =true;
        return false;
      }
      var uploadUrl = "../campaign/uploadlogo";  
      fu.uploadNewFileToUrl(file, uploadUrl, a.Campaign).then(function(fdata){
          var logo_name = fdata.data;
          x.get("../campaign/addlogo/"+c_name+"/"+c_s_date+"/"+c_e_date+"/"+logo_name).success(function(response){
            if(response=='success')
            {
              a.show_success_msg =true;
              a.show_error_msg =false;
              a.Campaign={};
            }
            else
            {
              a.show_success_msg =false;
              a.show_error_msg =true;
            }
            $('#add_campaign').prop('disabled', false);
            $("#add_campaign").text('Save');
          })
      });
    };

    // Function for deleting a campaign
    a.delete_campaign=function(itemId){     
     if(confirm("Are you sure?"))
     {       
       x.get("../campaign/delete/"+itemId).success(function(response){
          window.location.reload();             
       })
     }
    }

    x.get("../admin/dashboard/show").success(function(response){
    
    for (var e = [], f = response.length-1, g = 1; f >= g; g++) e.push({                
            firstname: response[g].company_name,
            email: response[g].email,
            approve: response[g].approve,
            id: response[g].id,
            reedemer_company: response[g].reedemer_company

        });
    a.cnames = response[0];   
    a.data = e, a.tableParams = new c({
        page: 1,
        count: 100,
        sorting: {
            firstname: "asc"
        }
    }, {
        filterDelay: 50,
        total: e.length,
        getData: function(a, b) {
            var c = b.filter().search,
                f = [];
            c ? (c = c.toLowerCase(), f = e.filter(function(a) {
                return a.firstname.toLowerCase().indexOf(c) > -1
            })) : f = e, f = b.sorting() ? d("orderBy")(f, b.orderBy()) : f, a.resolve(f.slice((b.page() - 1) * b.count(), b.page() * b.count()))             
        }
    })
  })
}]);