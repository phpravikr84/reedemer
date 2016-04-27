
"use strict";

var MyApp = angular.module("campaign-app", ["ngFileUpload","angularUtils.directives.dirPagination"]);



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


MyApp.controller('CampaignController',["$scope", "PlaceholderTextService", "ngTableParams", "$filter", "$http", "fileToUpload",function (a, b, c, d, x, fu) {          
    a.dataLength={filtered:[]};
    a.cnames = [];
    a.campaign_details = [];
    a.Campaignedit = [];
    var site_path=$("#site_path").val();
    var update_id =$("#update_id").val();
    // alert("p");
    
   // alert(update_id);
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

   // alert(update_id);
   x.post("../campaign/list",update_id).success(function(data_response){         
        a.campaign_details = data_response; 
        //a.c_start_date = campaign_details[0].start_date.split('-')[1]+'/'+campaign_details[0].start_date.split('-')[2]+'/'+campaign_details[0].start_date.split('-')[0];
        a.c_start_date = a.campaign_details[0].start_date.split('-')[1]+'/'+a.campaign_details[0].start_date.split('-')[2]+'/'+a.campaign_details[0].start_date.split('-')[0];
        a.c_end_date = a.campaign_details[0].end_date.split('-')[1]+'/'+a.campaign_details[0].end_date.split('-')[2]+'/'+a.campaign_details[0].end_date.split('-')[0];
        a.file_path=site_path;  
       // alert(site_path);
        //a.campaign_length = data_response.length;  
        //console.log('data :: '+JSON.stringify(data_response.start_date, null, 4));
    }); 
    //total: a.data_response,
    //console.log('data :: '+JSON.stringify(total, null, 4));     
  
    // a.reset_back= function(){
    //    alert("a");
    // }
    a.addCampaign = function(){
      $('#add_campaign').prop('disabled', true);
      $("#add_campaign").text('Saving..');      

      if($('#c_s_date').val()=='' || $('#c_e_date').val()=='' || $("#c_name").val()=='')
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
      var main_site_url=$('#main_site_url').val();
      var c_s_date_arr=$('#c_s_date').val().split('/');
      var c_s_date = c_s_date_arr[2]+'-'+c_s_date_arr[0]+'-'+c_s_date_arr[1];
         
      var c_e_date_arr=$('#c_e_date').val().split('/');
      var c_e_date = c_e_date_arr[2]+'-'+c_e_date_arr[0]+'-'+c_e_date_arr[1];
      a.Campaign.c_s_date = c_s_date; 
      a.Campaign.c_e_date = c_e_date; 
      
      
      x.post(main_site_url+"/campaign/addlogo",a.Campaign).success(function(response){
        var main_site_url=$("#main_site_url").val();                              
        var redirect_url=main_site_url+'/user/dashboard#/campaign/list'
        if(response=='success')
        {
          $("#error_div").hide();
          $("#show_message").slideDown();
          $("#success_div").html("Data inserted successfully. <br />Please wait,we will redirect you to listing page.");
          $("#success_div").show();              

          setTimeout(function() { 
            window.location.href = redirect_url; 
          }, 5000);
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
      });
    };

    // Function for deleting a campaign
    a.delete_campaign=function(itemId){     
     if(confirm("Are you sure?"))
     {  
       var main_site_url=$("#main_site_url").val();     

       $(".delete_row").hide();
       $("td#row_"+itemId).parent()
    .replaceWith('<tr><td colspan="5" class="center"><img src="'+main_site_url+'/../images/loader.gif" /></td></tr>');   
  //  return false;
       x.get("../campaign/delete/"+itemId).success(function(response){
          window.location.reload();             
       })
     }
    }

    

    a.redirect_edit=function(itemId){  
   // alert("a") ;
    //return false;
      $("#update_id").val(itemId);
      //return false;
      var main_site_url=$("#main_site_url").val(); 
      var edit_url=main_site_url+'/user/dashboard#/campaign/edit/';    
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
    a.updateCampaign=function(){  
      var main_site_url=$('#main_site_url').val();
      $('#edit_campaign').prop('disabled', true);
      $("#edit_campaign").text('Saving..'); 

      var c_s_date_arr=$('#c_s_date').val().split('/');
      var c_s_date = c_s_date_arr[2]+'-'+c_s_date_arr[0]+'-'+c_s_date_arr[1];
         
      var c_e_date_arr=$('#c_e_date').val().split('/');
      var c_e_date = c_e_date_arr[2]+'-'+c_e_date_arr[0]+'-'+c_e_date_arr[1];
      var c_name=$('#c_name').val();

      //alert(c_s_date);
      a.campaign_details= [{
                            'start_date':c_s_date,
                            'end_date':c_e_date,
                            'campaign_name':c_name,
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
    // alert(JSON.stringify(a.campaign_details,null,4));
    // return false;
      x.post(main_site_url+"/campaign/editcampaign",a.campaign_details).success(function(response){
        var main_site_url=$("#main_site_url").val();                              
        var redirect_url=main_site_url+'/user/dashboard#/campaign/list'
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

    a.cancel_redirect=function(){ 
      var main_site_url=$("#main_site_url").val();
      $("#update_id").val(''); 
      var redirect_url=main_site_url+'/user/dashboard#/campaign/list';
      window.location.href = redirect_url; 
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