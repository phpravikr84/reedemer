
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
    
   
    x.post("../campaign/list").success(function(response){              
      //alert(JSON.stringify(response,null,4));
      a.campaign_list = response; 
      a.file_path=site_path;  
      //a.PromotionDetails.desC = "Winter vegetable pasta with white wine and";
    }); 

    x.get("../admin/dashboard/category").success(function(response_cat){              
      //alert(JSON.stringify(response_cat,null,4));
      a.cat_list = response_cat; 
     // a.file_path=site_path;  
    }); 

    x.post("../inventory/list").success(function(inventory_list){        
     // alert(JSON.stringify(inventory_list[0].id,null,4));
      a.inventory_list = inventory_list;   
      //$("#inventory_list").val($("#inventory_list option:first").val());

      //$('#inventory_list option:first-child').attr("selected", "selected");
      //a.inventory_id = a.inventory_list[0];
      
 
    }); 
   // $("#inventory_list option:last").attr("selected", true);

   
    
    //$("select#inventory_list").val('3')
   // alert("a");
    //alert($("#inventory_list").val());


   // x.post("../inventory/list").success(function(data_response){              
     // a.inventory_details = data_response;   

    //  a.ProductList = data_response;

      // a.ProductList = null;
      // //Declaring the function to load data from database
      // a.fillProductList = function () {
      //     x({
      //         method: 'POST',
      //         url: '../inventory/list',
      //         data: {}
      //     }).success(function (result) {
      //         a.ProductList = result.d;
      //         alert(JSON.stringify(a.ProductList,null,4));
      //     });
      // };
      // //Calling the function to load the data on pageload
      // a.fillProductList();


   // }); 


   

    a.get_inventory = function(){  
      //inventory_id={}   ;
      if (!angular.isUndefined(a.inventory_id)) {
        var inventory_id=a.inventory_id.id;

        x.post("../inventory/inventorydetails",inventory_id).success(function(data_item){ 
         // alert(JSON.stringify(data_item,null,4));
          a.inventory_item=data_item;
          a.file_path=site_path;
         // alert("B");
         $("#cost").val(data_item.cost);
         $("#selling_price").val(data_item.sell_price);
         var src=site_path+"../uploads/inventory/original/"+data_item.inventory_image;
         $(("#inventory_image")).attr("src", src);
         // a.inventory_item.inventory_cost=data_response.cost;
         // a.inventory_item.inventory_sell_price=data_response.sell_price;

        }); 

      }
      //else
      //{
       // alert("a");
     // }
      //alert(JSON.stringify(angular.isDefined(a.inventory_id),null,4));
      
    } 

    //a.result = a.someVal;
    a.offer_description = "";
    a.what_you_get = "";
    a.cost = "";
   
   // a.desC = 'bob';
    //a.PromotionDetails="bbbbbb";
    

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
  
    a.add_offer=function(){  
      alert(JSON.stringify(a.promotion, null, 4));
    }

}]);