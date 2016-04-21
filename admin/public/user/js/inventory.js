
"use strict";

var MyApp = angular.module("inventory-app", ["ngFileUpload"]);



MyApp.factory("fileToUpload", ["$http", function(h){

  var promise;
  var fileUpload = {
    uploadNewFileToUrl: function(file, uploadUrl, data) {
    //  alert("A");
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
    var update_id =$("#update_id").val();
    //$("#error_msg").hide('500');
    //alert(a.addInventory);
   // $('#add_inventory').prop('disabled', true);
   //alert("b");
   //$('input[type="submit"]').prop('disabled', true);
  //$('#add_inventory').prop('disabled', true);
  //$('#sell_price').keyup(function() {
  //    if($(this).val() != '') {
  //       $('#add_inventory').prop('disabled', false);
  //    }
  // });
  
  //var ext = $('#inventory_image').val().split('.').pop().toLowerCase();
  //if($.inArray(ext, ['jpg','jpeg']) == -1) {
  //    alert('invalid extension!');
  //}
   //var site_path=$("#site_path").val();
   //alert(site_path);
   x.post("../inventory/list",update_id).success(function(data_response){              
        a.inventory_details = data_response; 
        a.file_path=site_path;  
    });           
  
    a.addInventory = function(){             
      var file = a.myFile; 
      //console.log('data :: '+JSON.stringify(a.Inventory, null, 4));   
      $('#add_inventory').prop('disabled', true);
      $("#add_inventory").text('Saving..');     
      //var inventory_image = $('#inventory_image').val() ;
      //alert(inventory_image);
     // alert(a.Inventory.inventory_name);
     // alert(a.Inventory.sell_price);
     // alert(a.Inventory.cost);
      //if(a.Inventory.inventory_name=='undefined' || a.Inventory.sell_price=='undefined' || a.Inventory.cost =='undefined')
      //{
        //$("#success_div").html("Data inserted successfully.");
        //$("#msg_section").slideDown();
        //$("#error_div").hide();
      //  alert("ap");
      //  $("#show_message").slideDown();
      //  $("#success_div").html("Please insert all field.");
      //  $("#success_div").show();
      //}
      //alert(a.Inventory.);
      // var ext = $('#inventory_image').val().split('.').pop().toLowerCase();
      // if($.inArray(ext, ['jpg','jpeg']) == -1) {
      //   $("#show_message").slideDown();
      //   $("#error_div").html("Please upload only .jpg /.jpeg image.");
      //   $("#error_div").show();
      //   $("#success_div").hide();

      //   $('#add_inventory').prop('disabled', false);
      //   $("#add_inventory").text('Save');
      //   return false;
      // }
      

      var uploadUrl = "../inventory/uploadlogo";  
      fu.uploadNewFileToUrl(file, uploadUrl, a.Inventory).then(function(fdata){
          if($("#inventory_name").val()=='' || $("#sell_price").val()=='' || $("#cost").val()=='')
          {
              $("#error_div").hide();
              $("#show_message").slideDown();
              $("#error_div").html("Please insert all fields.");
              $("#error_div").show();
              $("#success_div").hide();

              $('#add_inventory').prop('disabled', false);
              $("#add_inventory").text('Save');
              return false;
          }
         // alert(fdata.data);
          var logo_name = fdata.data;
          //alert(logo_name);
          a.Inventory.inventory_image = logo_name; 
          var main_site_url=$('#main_site_url').val();

          x.post(main_site_url+"/inventory/addlogo",a.Inventory).success(function(response){
            if(response=='success')
            {
              var main_site_url=$("#main_site_url").val();
                                    
              var redirect_url=main_site_url+'/user/dashboard#/inventory/list';  

              $("#error_div").hide();
              $("#show_message").slideDown();
              $("#success_div").html("Data inserted successfully. <br />Please wait,we will redirect you to listing page.");
              $("#success_div").show();              

              setTimeout(function() { 
                window.location.href = redirect_url; 
              }, 5000); 
            }
            else if(response=='image_not')
            {
              $("#error_div").hide();
              $("#show_message").slideDown();
              $("#error_div").html("Unable to upload image. Please try again.");
              $("#error_div").show();
              $("#success_div").hide();
              return false;              
            }
            else
            {
              $("#error_div").hide();
              $("#show_message").slideDown();
              $("#error_div").html("Please insert all field.");
              $("#error_div").show();
              $("#success_div").hide();              
            }
            $('#add_inventory').prop('disabled', false);
            $("#add_inventory").text('Save');
          })
      });
    };


    a.updateInventory=function(){  
     // alert("V");
     // return false;
      var main_site_url=$('#main_site_url').val();
      $('#edit_inventory').prop('disabled', true);
      $("#edit_inventory").text('Saving..'); 

     
      var inventory_name=$('#inventory_name').val();
      var sell_price=$('#sell_price').val();
      var cost=$('#cost').val();

      //alert(c_s_date);
      a.inventory_details= [{
                            'inventory_name':inventory_name,
                            'sell_price':sell_price,
                            'cost':cost,
                            'id':update_id
                          }]; 
      //a.campaign_details.push('end_date':c_e_date); 

      // var c_name=$("#c_name").val();
      // var c_s_date=$("#c_s_date").val();
      // var c_e_date=$("#c_e_date").val();

      // var c_s_date_arr=$('#c_s_date').val().split('/');
      // var c_s_date = c_s_date_arr[2]+'-'+c_s_date_arr[0]+'-'+c_s_date_arr[1];
         
      // var c_e_date_arr=$('#c_e_date').val().split('/');
      // var c_e_date = c_e_date_arr[2]+'-'+c_e_date_arr[0]+'-'+c_e_date_arr[1];
      //a.c_name.push(c_name); 
      //a.Campaignedit.push(c_s_date); 
      //a.Campaignedit.push(c_e_date);
     // a.Campaign.c_e_date = c_e_date; 
     //alert()
    // alert(JSON.stringify(a.inventory_details,null,4));
    // return false;
      x.post(main_site_url+"/inventory/editinventory",a.inventory_details).success(function(response){
        var main_site_url=$("#main_site_url").val();                              
        var redirect_url=main_site_url+'/user/dashboard#/inventory/list';
        //alert(response);
       // return false;
        if(response=='success')
        {
          $("#update_id").val('');
          //return false;
          $("#error_div").hide();
          $("#show_message").slideDown();
          $("#success_div").html("Data updated successfully. <br />Please wait,we will redirect you to listing page.");
          $("#success_div").show(); 


          setTimeout(function() { 
            window.location.href = redirect_url; 
          }, 5000);
        }
        else if(response=='invalid_id')
        {
          $("#error_div").hide();
          $("#show_message").slideDown();
          $("#error_div").html("Error occoure! Please try again.");
          $("#error_div").show();
          $("#success_div").hide();

          setTimeout(function() { 
            window.location.href = redirect_url; 
          }, 2000);
        }
        else
        {
          $("#error_div").hide();
          $("#show_message").slideDown();
          $("#error_div").html("Please insert all field.");
          $("#error_div").show();
          $("#success_div").hide(); 
        }
        
      });
    }

    // Function for deleting a Inventory
    a.delete_inventory=function(itemId){   
    var main_site_url=$("#main_site_url").val();   
    
     if(confirm("Are you sure?"))
     {    
        $(".delete_row").hide();
        $("td#row_"+itemId).parent()
    .replaceWith('<tr><td colspan="5" class="center"><img src="'+main_site_url+'/images/loader.gif" /></td></tr>');   
       // return false;
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

    a.redirect_edit=function(itemId){  
   // alert(itemId) ;
   // return false;
      $("#update_id").val(itemId);
      //return false;
      var main_site_url=$("#main_site_url").val(); 
      var edit_url=main_site_url+'/user/dashboard#/inventory/edit/';    
      window.location.href = edit_url; 
    //  if(confirm("Are you sure?"))
    //  {  
    //    var main_site_url=$("#main_site_url").val();     

    //    $(".delete_row").hide();
    //    $("td#row_"+itemId).parent()
    // .replaceWith('<tr><td colspan="5" class="center"><img src="'+main_site_url+'/images/loader.gif" /></td></tr>');   
  
    //    x.get("../campaign/delete/"+itemId).success(function(response){
    //       window.location.reload();             
    //    })
    //  }
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