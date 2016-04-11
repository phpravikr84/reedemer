
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
    var site_path=$("#site_path").val();
    
    //Load Calender when page load
   // $("#c_s_date").datepicker();
    $( "#c_s_date" ).datepicker({ 
        //dateFormat:"mm-dd-yy"
        /*showOn: "button",
        buttonImage: site_path+"/images/calendar.gif",
        buttonImageOnly: true,
        buttonText: "Select date"*/

       // numberOfMonths: 2,
       dateFormat:"mm/dd/yy",
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() + 1);
            $("#c_e_date").datepicker("option", "minDate", dt);
        }

    });

    $( "#c_e_date" ).datepicker({     
        //dateFormat:"mm-dd-yy"
        /*showOn: "button",
        buttonImage: site_path+"/images/calendar.gif",
        buttonImageOnly: true,
        buttonText: "Select date"*/

       // numberOfMonths: 2,
       dateFormat:"mm/dd/yy",
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() - 1);
            $("#c_s_date").datepicker("option", "maxDate", dt);
        }
    });

   x.post("../campaign/list").success(function(data_response){         
        a.campaign_details = data_response; 
        a.file_path=site_path;  
       // alert(site_path);
        //a.campaign_length = data_response.length;  
        //console.log('data :: '+JSON.stringify(data_response.start_date, null, 4));
    }); 
    //total: a.data_response,
    //console.log('data :: '+JSON.stringify(total, null, 4));     
  
    a.addCampaign = function(){             
      var file = a.myFile;

       $('#add_campaign').prop('disabled', true);
       $("#add_campaign").text('Saving..');      

      // var c_name = $('#c_name').val();
      // var c_s_date = $('#c_s_date').val();
      // //var c_s_date = c_s_date_raw[2]+'-'+c_s_date_raw[0]+'-'+c_s_date_raw[1];
      
      // var c_e_date = $('#c_e_date').val();
      // //var c_e_date = c_e_date_arr[2]+'-'+c_e_date_arr[0]+'-'+c_e_date_arr[1];
      // var logo_name = $('#logo_name').val();
      
      // if(c_name=='' || c_s_date=='' || c_e_date=='' || file=='')
      // {
      //   $('#add_campaign').prop('disabled', false);
      //   $("#add_campaign").text('Save');

      //   a.show_error_msg =true;
      //   return false;
      // }

      var ext = $('#logo_name').val().split('.').pop().toLowerCase();
      if($.inArray(ext, ['jpg','jpeg']) == -1) {
        $("#show_message").slideDown();
        $("#error_div").html("Please upload only .jpg /.jpeg image.");
        $("#error_div").show();
        $("#success_div").hide();

        $('#add_campaign').prop('disabled', false);
        $("#add_campaign").text('Save');
        return false;
      }

      var uploadUrl = "../campaign/uploadlogo";  
      fu.uploadNewFileToUrl(file, uploadUrl, a.Campaign).then(function(fdata){
          var logo_name = fdata.data;
          var c_s_date_arr=$('#c_s_date').val().split('/');
          var c_s_date = c_s_date_arr[2]+'-'+c_s_date_arr[0]+'-'+c_s_date_arr[1];
         // alert(c_s_date);
         // return false;
          var c_e_date_arr=$('#c_e_date').val().split('/');
          var c_e_date = c_e_date_arr[2]+'-'+c_e_date_arr[0]+'-'+c_e_date_arr[1];

          if(c_s_date=='' || c_e_date=='' || $("#c_name").val()=='')
          {
              $("#error_div").hide();
              $("#show_message").slideDown();
              $("#error_div").html("Please insert all field.");
              $("#error_div").show();
              $("#success_div").hide();

              $('#add_campaign').prop('disabled', false);
              $("#add_campaign").text('Save');
              return false;
          }

          a.Campaign.campaign_image = logo_name; 
          a.Campaign.c_s_date = c_s_date; 
          a.Campaign.c_e_date = c_e_date; 
         // alert(logo_name);
          var main_site_url=$('#main_site_url').val();
           //  alert(main_site_url);
            // return false;
          //  console.log('data send :: '+JSON.stringify(a.Campaign, null, 4));  
           // return false;

          x.post(main_site_url+"/campaign/addlogo",a.Campaign).success(function(response){
            if(response=='success')
            {
              var main_site_url=$("#main_site_url").val();
                                    
              var redirect_url=main_site_url+'/user/dashboard#/campaign/list';                                   
             // window.location.href = redirect_url;  

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
            $('#add_campaign').prop('disabled', false);
            $("#add_campaign").text('Save');
          })
      });
    };

    // Function for deleting a campaign
    a.delete_campaign=function(itemId){     
     if(confirm("Are you sure?"))
     {       
       $(".delete_row").hide();
       $("td#row_"+itemId).parent()
    .replaceWith('<tr><td colspan="5" class="center"><img src="'+main_site_url+'/images/loader.gif" /></td></tr>');   
    //return false;
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