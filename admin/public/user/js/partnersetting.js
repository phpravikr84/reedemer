
"use strict";

var MyApp = angular.module("partnersetting-app", ["ngFileUpload","angularUtils.directives.dirPagination"]);



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


MyApp.controller('PartnersettingController',["$scope", "PlaceholderTextService", "ngTableParams", "$filter", "$http", "fileToUpload",function (a, b, c, d, x, fu) {          
    a.dataLength={filtered:[]};
    //a.cnames = [];
   // a.inventory_details = [];
    //alert("A");
    var site_path=$("#site_path").val();
    var update_id =$("#update_id").val();
    
   x.post("../partnersetting/list").success(function(data_response){              
        a.settings_details = data_response; 
        a.file_path=site_path;
    });    
  //  alert(JSON.stringify(a.settings_details, null, 4)) ;
  
    x.get("../partnersetting/allrange").success(function(range){              
      a.range_details = range; 
    }); 
    // show all uploaded logo in admin panel 
    if($("#range_id").val())
    {
        var old_price_range_id = $("#range_id").val();
    }
   
  //  a.old_price_range_id=old_price_range_id;

    


    a.updateSetting=function(){  
      var main_site_url=$('#main_site_url').val();
      $('#edit_inventory').prop('disabled', true);
      $('#cancel_redirect').prop('disabled', true);
      $("#edit_inventory").text('Saving..'); 
      var price_range_id = $("#price_range_id").val();
      var range_id = $("#range_id").val();
      
     
      
     
      a.settings_details.update_id=update_id;
      a.settings_details= [{
                             'price_range_id':range_id,
                             'update_id':update_id                             
                           }]; 

    //// alert(JSON.stringify(a.settings_details,null,4));
      //return false;
      x.post(main_site_url+"/partnersetting/update",a.settings_details).success(function(response){
        var main_site_url=$("#main_site_url").val();                              
        var redirect_url=main_site_url+'/user/dashboard#/settings/list';
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
        else if(response=='id_not_match')
        {
          $("#error_div").hide();
          $("#show_message").slideDown();
          $("#error_div").html("Some problem occoure! Please logout and login again.");
          $("#error_div").show();
          $("#success_div").hide(); 
        }        
        else
        {
          $("#error_div").hide();
          $("#show_message").slideDown();
          $("#error_div").html("Some problem occoure! Please check all input.");
          $("#error_div").show();
          $("#success_div").hide(); 

          $('#edit_inventory').prop('disabled', false);
          $("#edit_inventory").text('Save'); 
        }
        
      });
    }

    // Function for deleting a Inventory
    a.delete_setting=function(itemId){   
    var main_site_url=$("#main_site_url").val();   
    
     if(confirm("Are you sure?"))
     {  
    // alert(itemId)  ;
     return false;
        $(".delete_row").hide();
        $("td#row_"+itemId).parent()
    .replaceWith('<tr><td colspan="5" class="center"><img src="'+main_site_url+'/../images/loader.gif" /></td></tr>');   
       // alert(main_site_url+'/../images/loader.gif');
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
      var edit_url=main_site_url+'/user/dashboard#/settings/edit/';    
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

    /*a.cancel_redirect=function(){ 
      var main_site_url=$("#main_site_url").val();
      $("#update_id").val(''); 
      var redirect_url=main_site_url+'/user/dashboard#/inventory/list';
      window.location.href = redirect_url; 
    }*/

    a.cancel_redirect=function(folder_name){ 
        var main_site_url=$("#main_site_url").val();
        $("#update_id").val(''); 
        var redirect_url=main_site_url+'/user/dashboard#/'+folder_name+'/list';
        window.location.href = redirect_url; 
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