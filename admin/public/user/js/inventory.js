
"use strict";

var MyApp = angular.module("inventory-app", ["ngFileUpload"]);



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


MyApp.controller('InventoryController',["$scope", "PlaceholderTextService", "ngTableParams", "$filter", "$http", "fileToUpload",function (a, b, c, d, x, fu) {          
    a.dataLength={filtered:[]};
    a.cnames = [];
    a.inventory_details = [];

   x.get("../inventory/list").success(function(data_response){              
        a.inventory_details = data_response;  
    });           
  
    a.addInventory = function(){             
      var file = a.myFile;

      $('#add_inventory').prop('disabled', true);
      $("#add_inventory").text('Saving..');      

      var inventory_name = $('#inventory_name').val();
      var sell_price = $('#sell_price').val();
      var cost = $('#cost').val();
      var inventory_image = $('#inventory_image').val();
      
      if(inventory_name=='' || sell_price=='' || cost=='' || inventory_image=='')
      {
        $('#add_inventory').prop('disabled', false);
        $("#add_inventory").text('Save');

        a.show_error_msg =true;
        return false;
      }
      var uploadUrl = "../inventory/uploadlogo";  
      fu.uploadNewFileToUrl(file, uploadUrl, a.Inventory).then(function(fdata){
          var logo_name = fdata.data;
        
          x.get("../inventory/addlogo/"+inventory_name+"/"+sell_price+"/"+cost+"/"+logo_name).success(function(response){
            if(response=='success')
            {
              a.show_success_msg =true;
              a.show_error_msg =false;
              a.Inventory={};
            }
            else
            {
              a.show_success_msg =false;
              a.show_error_msg =true;
            }
            $('#add_inventory').prop('disabled', false);
            $("#add_inventory").text('Save');
          })
      });
    };

    // Function for deleting a Inventory
    a.delete_inventory=function(itemId){     
     if(confirm("Are you sure?"))
     {       
       x.get("../inventory/delete/"+itemId).success(function(response){
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