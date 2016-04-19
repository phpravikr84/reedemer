
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
    var site_path=$("#site_path").val();
    var add_url=main_site_url+'/user/dashboard#/repository/add';
    if($("#dir_id").val()!='')
    {
      a.new_dir_id = $("#dir_id").val();
    }
   // alert(JSON.stringify(portionId, null, 4)); 
    x.post("../directory/show").success(function(response){
      //alert("V");
      a.repo_details=response,
      a.file_path=site_path
    });
    //alert("C");
   // alert("a");
    //Load Calender when page load
   // $("#c_s_date").datepicker();

   x.get("../directory/alldirectory").success(function(response){
      a.cnames = response; 
      a.add_url = add_url;
     // a.repo_details=response,
     // a.file_path=site_path
     //alert(JSON.stringify(response, null, 4));
    });
    a.set_dir_id = function(dir_id){
      //a.dir_id=dir_id;
      $("#dir_id").val(dir_id);
        x.get("../directory/alllisting/"+dir_id).success(function(response){
         // alert(JSON.stringify(response, null, 4)); 
          a.repo_details=response
          //a.file_path=site_path
        });
    }; 
    a.add_folder = function(new_dir_id){

     a.repodetails.new_dir_id = $("#new_dir_id").val();
     //alert(JSON.stringify(a.repodetails, null, 4)); 
    // return false;
      //var dir_name=a.repodetails.dir_name;
        //http://localhost/reedemer/admin/public/directory/store
        x.post("../directory/store",a.repodetails).success(function(response){
          if(response=="success")
          {
              var main_site_url=$("#main_site_url").val();                
              var redirect_url=main_site_url+'/user/dashboard#/repository/list';

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

    a.update_status = function(itemId){
      //a.details.id=itemId;
      x.get("../directory/updatestatus/"+itemId).success(function(response){
      });
    }


    //console.log('data :: '+JSON.stringify(a.repodetails.dir_name, null, 4)); 
    a.delete_folder = function(itemId){
      var main_site_url=$("#main_site_url").val();   

      if(confirm("Are you sure?"))
      {    
        $(".delete_row").hide();
        $("td#row_"+itemId).parent()
        .replaceWith('<tr><td colspan="5" class="center"><img src="'+main_site_url+'/images/loader.gif" /></td></tr>');   
        // return false;
        x.get("../directory/delete/"+itemId).success(function(response){

          if(response=='success')
          {
            $("#error_div").hide();
            $("#show_message").slideDown();
            $("#success_div").html("Data deleted successfully. <br />Please wait,we will reload this page.");
            $("#success_div").show();              

            setTimeout(function() { 
              window.location.reload(); 
            }, 5000); 
                        
          }
          // var redirect_url=main_site_url+'/user/dashboard#/inventory/list';
          // alert(itemId);
          // $(".delete_row").show();
          // $('#row_'+itemId).hide();
          //$("#row_"+itemId).hide('500');
          //  window.location.href=redirect_url;
        })
      }
    }

    $('#send-btn').click(function(){  
      var token=$("#token").val(); 
      var data = new FormData($('form')[0]);
      data.append("dir_id",  $("#dir_id").val());  
      $.ajax({
        url: '../directory/upload',
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,        
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },        
        success: function(response){
          //alert(data);

          if(response=='success')
          {
            var main_site_url=$("#main_site_url").val();

            var redirect_url=main_site_url+'/user/dashboard#/repository/list';  

            $("#error_div").hide();
            $("#show_message").slideDown();
            $("#success_div").html("Data inserted successfully. <br />Please wait,we will redirect you to listing page.");
            $("#success_div").show();              

            setTimeout(function() { 
              window.location.href = redirect_url; 
            }, 5000); 
          }
        }
      });      
    }); 
    
   
}]);