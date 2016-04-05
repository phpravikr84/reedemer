
"use strict";

var MyApp = angular.module("campaign-app", []);

MyApp.controller('CampaignController',["$scope", "PlaceholderTextService", "ngTableParams", "$filter", "$http", "fileUpload", function(a, b, c, d, x, fu){
	a.dataLength={filtered:[]};
    a.cnames = [];
    a.campaign_details = [];
  //  a.saveButtonText = "Save user";
   // a.isDisabled = false;
   $('#upload_button').prop('disabled', false);
   $("#upload_button").text('Save user');
    x.get("http://159.203.91.38/admin/public/index.php/campaign/list").success(function(data_response){              
        a.campaign_details = data_response;
        // alert(data_response);
        console.log('data :: '+JSON.stringify(data_response, null, 4));
    });           
  
    a.uploadFile = function(){
       var file = a.myFile;
      // $("#upload_button").hide();
       //a.saveButtonText = "Saving..";
      // a.isDisabled = true;
       $('#upload_button').prop('disabled', true);
       $("#upload_button").text('Saving..');
     //  return false;
       //alert("a");
     // console.log('data :: '+JSON.stringify(a.Redeemer, null, 4));
    //  console.log('image name :: '+JSON.stringify(a.myFile, null, 4));
      // console.dir(file);
      
       var uploadUrl = "../admin/dashboard/uploadlogo";

       // alert(company_id);
       fu.uploadFileToUrl(file, uploadUrl, a.Campaign );                            ;
    };
    a.delete_campaign=function(itemId){ 
     if(confirm("Are you sure?"))
     {  
        //var loder_name='loading_'+itemId;
        //var icon_name='del_icon_'+itemId;
       // a.'loading_'+itemId = false;   
       // a.icon_name = true;  
       // alert(itemId);
               
       x.get("../campaign/delete/"+itemId).success(function(response){
          //a.status=response;                 
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

        //console.log("data :: "+JSON.stringify(response, null, 4));

        /*var statusForItem = 'status'+response[g].id;
        console.log(statusForItem);
        if(response[g].status){
            a.statusForItem = response[g].status;
        } else {
            a.statusForItem = 0;
        }*/
      //  alert(response[0].company_name);
    a.cnames = response[0];
   // console.log("data :: "+JSON.stringify(response[0], null, 4));
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
             // alert(f.length);
        }
    })
  })
}]);