
"use strict";

var MyApp = angular.module("video-app", ["ngFileUpload","angularUtils.directives.dirPagination"]);



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


MyApp.controller('VideoController',["$scope", "PlaceholderTextService", "ngTableParams", "$filter", "$http", "fileToUpload",function (a, b, c, d, x, fu) {          
   // a.dataLength={filtered:[]};
    //a.cnames = [];
    //a.inventory_details = [];
    //$("#option-1").prop("checked", true);
    //$("#option-3").prop("checked", true);
   // alert("a");
   // $('#play_arrow').prop('disabled', true);
   
    var site_path=$("#site_path").val();
   // var update_id =$("#update_id").val();

   
    
   x.post("../video/list").success(function(data_response){              
        a.video_details = data_response; 
        a.file_path=site_path;  
        //alert(JSON.stringify(a.video_details,null,4));
    });       

    // $('.put_href').click(function() {
    //    var newurl = $('#video_url').val();
    //    alert(newurl);
    //    $('.put_href').attr('href', newurl);lgZBsWGaQY0?autoplay=1
    // });


    $(".put_href").click(function() {

        var provider=$('input[name=provider]:checked').val();
        var newurl = $('#video_url').val();
        if($('#video_url').val()=="")
        {
          $("#error_div").hide();
          $("#show_message").slideDown();
          $("#error_div").html("Please insert video URL.");
          $("#error_div").show();
          $("#success_div").hide();

          return false;
        }

        // if(newurl.indexOf('youtube') != -1){
        //     alert("youtube");
        // }
        // else if(newurl.indexOf('vimeo') != -1){
        //     alert("vimeo");
        // }
        // else
        // {
        //   alert("none");
        // }

        
        if(provider==1)
        {  
          if(newurl.indexOf('youtube') == -1){
              $("#error_div").hide();
              $("#show_message").slideDown();
              $("#error_div").html("Please enter valid youtube URL.");
              $("#error_div").show();
              $("#success_div").hide();

              return false;
          }

          var videoid = newurl.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
          var video_id=videoid[1];

          //alert(provider+'----'+video_id); 

          $(".put_href").attr("href","https://www.youtube.com/embed/"+video_id+"?autoplay=1");
        }
        if(provider==2)
        {
          //alert("B")       ;
          //var regExp = /https:\/\/(www\.)?vimeo.com\/(\d+)($|\/)/;

          if(newurl.indexOf('vimeo') == -1){
              $("#error_div").hide();
              $("#show_message").slideDown();
              $("#error_div").html("Please enter valid vimeo URL.");
              $("#error_div").show();
              $("#success_div").hide();

              return false;
          }

          var regExp = /(?:https?:\/{2})?(www\.)?vimeo.com\/(\d+)($|\/)/;
        //  var videoid = newurl.match(regExp);
          var match = newurl.match(regExp);
          var video_id=match[2];     

          //alert(provider+'----'+video_id); 
          //return false;
          $(".put_href").attr("href","https://player.vimeo.com/video/"+video_id+"?autoplay=1");    
        }

        // if(videoid != null) {
        // console.log("video id = ",videoid[1]);
        // } else { 
        // console.log("The youtube url is not valid.");
        // }
      //alert(video_id);
     // return false;
      // $(".put_href").attr("href","https://www.youtube.com/watch?v=rBUjxW0AHxs");
      
       
       //
       //alert("a");
    });
   
    // $('#video_url').change(function() {
    //   var newurl = $('#video_url').val();
    //   $('a.put_href').attr('href', newurl);
    // });

    a.addVideo = function(){      
      $('#add_video').prop('disabled', true);
      $("#add_video").text('Saving..');       
      var provider=$("input[name='provider']:checked").val();
      var status=$("input[name='status']:checked").val();
     
          if($("#video_url").val()=='')
          {
              $("#error_div").hide();
              $("#show_message").slideDown();
              $("#error_div").html("Please insert video URL.");
              $("#error_div").show();
              $("#success_div").hide();

              $('#add_video').prop('disabled', false);
              $("#add_video").text('Save');
              return false;
          }
         
          a.video.provider = provider; 
          a.video.status = status; 
          
          var main_site_url=$('#main_site_url').val();
       
          x.post(main_site_url+"/video/store",a.video).success(function(response){
           
            if(response=='success')
            {
              var main_site_url=$("#main_site_url").val();
                                    
              var redirect_url=main_site_url+'/user/dashboard#/video/list';  

              $("#error_div").hide();
              $("#show_message").slideDown();
              $("#success_div").html("Data inserted successfully. <br />Please wait,we will reload this page.");
              $("#success_div").show();              

              setTimeout(function() { 
               // window.location.reload();
                window.location.href = redirect_url; 
              }, 5000); 
            }     
            else if(response=='invalid_video')
            {
              $("#error_div").hide();
              $("#show_message").slideDown();
              $("#error_div").html("Invalid video URL.Please put youtube or vimeo video url only.");
              $("#error_div").show();
              $("#success_div").hide();         

              $('#add_video').prop('disabled', false);
              $("#add_video").text('Save');  
            }  
            else if(response=='invalid_url')
            {
              $("#error_div").hide();
              $("#show_message").slideDown();
              $("#error_div").html("Invalid video URL.");
              $("#error_div").show();
              $("#success_div").hide();         

              $('#add_video').prop('disabled', false);
              $("#add_video").text('Save');  
            }            
            else
            {
              $("#error_div").hide();
              $("#show_message").slideDown();
              $("#error_div").html("Please insert all field.");
              $("#error_div").show();
              $("#success_div").hide();              
            }
           // $('#add_inventory').prop('disabled', false);
           // $("#add_inventory").text('Save');
          })
      
    };


    a.make_default=function(itemId){ 
     // alert(itemId+'----');
      //return false;
       x.get("../video/mainvideo/"+itemId).success(function(response){
          a.status=response;                 
           if(response=='success')
            {
              $("#error_div").hide();
              $("#show_message").slideDown();
              $("#success_div").html("Data updated successfully. <br />Please wait,we will reload this page.");
              $("#success_div").show();              

              setTimeout(function() { 
                window.location.reload();
               // window.location.href = redirect_url; 
              }, 5000); 
            } 
            else
            {
              $("#error_div").hide();
              $("#show_message").slideDown();
              $("#error_div").html("Some error occoure.");
              $("#error_div").show();
              $("#success_div").hide();     

              setTimeout(function() { 
                window.location.reload();
               // window.location.href = redirect_url; 
              }, 5000);          
            }                
       })
    }

    // Function for deleting a Inventory
    a.delete_video=function(itemId){   
    var main_site_url=$("#main_site_url").val();   
    
     if(confirm("Are you sure?"))
     {    
        $(".delete_row").hide();
        $("td#row_"+itemId).parent()
    .replaceWith('<tr><td colspan="5" class="center"><img src="'+main_site_url+'/../images/loader.gif" /></td></tr>');   
       
       x.get("../video/delete/"+itemId).success(function(response){
          window.location.reload();             
       })
     }
    }    
}]);