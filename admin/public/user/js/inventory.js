
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
   
    var site_path=$("#site_path").val();
    //$("#error_msg").hide('500');
    //alert(a.addInventory);
   // $('#add_inventory').prop('disabled', true);

   x.post("../inventory/list").success(function(data_response){              
        a.inventory_details = data_response; 
        a.file_path=site_path;  
    });           
  
    a.addInventory = function(){             
      var file = a.myFile;
     // alert("p");
     // a.Inventory = [];
     // if(a.Inventory=='undefined')
      //{
      //  alert("a");
      //  return false;
     // }
      //
    //  $('#add_inventory').prop('disabled', true);
    //  $("#add_inventory").text('Saving..');      

      // var inventory_name = $('#inventory_name').val();
      // var sell_price = $('#sell_price').val();
      // var cost = $('#cost').val();
     //  var inventory_image = $('#inventory_image').val();
     //  a.Inventory.inventory_image = inventory_image; 
      console.log('data :: '+JSON.stringify(a.Inventory, null, 4));
      
      // if(a.Inventory.inventory_name=='' || a.Inventory.sell_price=='' || a.Inventory.cost=='' || a.Inventory.inventory_image=='')
      // {
        //  $("#error_div").html("Please insert all field.");
        //      $("#msg_section").slideDown();
        //      $("#success_div").hide();
         // alert("a");
      //   $('#add_inventory').prop('disabled', false);
      //   $("#add_inventory").text('Save');

      //   a.show_error_msg =true;
      //   return false;
      // }
      var uploadUrl = "../inventory/uploadlogo";  
      fu.uploadNewFileToUrl(file, uploadUrl, a.Inventory).then(function(fdata){
          var logo_name = fdata.data;
          a.Inventory.inventory_image = logo_name; 
          var main_site_url=$('#main_site_url').val();

          x.post(main_site_url+"/inventory/addlogo",a.Inventory).success(function(response){
            if(response=='success')
            {
              var main_site_url=$("#main_site_url").val();
                                    
              var redirect_url=main_site_url+'/user/dashboard#/inventory/list';  

              
              $("#success_div").html("Data inserted successfully.");
              $("#msg_section").slideDown();
              $("#error_div").hide();

              setTimeout(function() { 
                window.location.href = redirect_url; 
              }, 5000); 

             // setTimeout("window.location.href = "+, 2000);

             // window.location.href = redirect_url; 
              //a.show_success_msg =true;
              //a.show_error_msg =false;
              //a.show_error_msg_img =false;
              //a.Inventory={};
            }
            else if(response=='image_not')
            {
              
              $("#error_div").html("Unable to upload image. Please try again.");
              $("#msg_section").slideDown();
              $("#success_div").hide();

              
              
             // alert("A");
             // a.show_success_msg =false;
             // a.show_error_msg =false;
             // a.show_error_msg_img =true;
             // a.Inventory={};
            }
            else
            {
              alert("a");
             // a.show_success_msg =false;
              //a.show_error_msg =true;
              //a.show_error_msg_img =false;
              //a.Inventory={};
             
              $("#error_div").html("Please insert all field.");
              $("#msg_section").slideDown();
              $("#success_div").hide();
            }
          //  $('#add_inventory').prop('disabled', false);
            //$("#add_inventory").text('Save');
          })
      });
    };

    // Function for deleting a Inventory
    a.delete_inventory=function(itemId){   
    var main_site_url=$("#main_site_url").val();   
    
     if(confirm("Are you sure?"))
     {    
        $(".delete_row").hide();
        $("td#row_"+itemId).parent()
    .replaceWith('<tr><td colspan="5" class="center"><img src="'+main_site_url+'/images/loader.gif" /></td></tr>');   
       x.get("../inventory/delete/"+itemId).success(function(response){
          window.location.reload();             
         // var redirect_url=main_site_url+'/user/dashboard#/inventory/list';
         // alert(itemId);
         // $(".delete_row").show();
         // $('#row_'+itemId).hide();
          //$("#row_"+itemId).hide('500');
         //  window.location.href=redirect_url;
       })
     }
    }

    x.post("../admin/dashboard/show").success(function(response){
    
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