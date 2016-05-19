
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
    var site_path=$("#site_path").val();

    $( "#c_s_date" ).datepicker({         
      dateFormat:"mm/dd/yy",          
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
      a.campaign_list = response; 
      a.file_path=site_path;       
    }); 

    x.get("../admin/dashboard/category").success(function(response_cat){ 
      a.cat_list = response_cat;        
    }); 

    x.post("../inventory/list").success(function(inventory_list){ 
      a.inventory_list = inventory_list;  
    }); 

    a.open_pop = function(item){  
    $('<div>').dialog({
            modal: true,
            open: function ()
            {
                //$(this).load('http://www.google.com');

                $.ajax({ url: 'http://localhost/reedemer/admin/public/promotion',
                         data: {action: 'test'},
                         type: 'get',
                         success: function(output) {
                                      //alert(output);
                                  }
                });

            },         
            height: 400,
            width: 400,
            title: 'Dynamically Loaded Page'
        });
    }

    a.choices = [{id: '1'}];
    a.addNewChoice = function() {
      var newItemNo = a.choices.length+1;
      a.choices.push({'id':newItemNo});
    };
      
    a.removeChoice = function() {
      var lastItem = a.choices.length-1;
      a.choices.splice(lastItem);
    };

    a.get_inventory = function(item, choices){
      var inventory_id=item;     
      x.post("../inventory/inventorydetails",inventory_id).success(function(data_item){        
        a.inventory_item=data_item;
        a.file_path=site_path;        
        var costId = "#cost"+choices;
        $(costId).val(data_item.cost);
        var imageDivId = "#selling_price"+choices;
        $(imageDivId).val(data_item.sell_price);
        var src=site_path+"../uploads/inventory/original/"+data_item.inventory_image;
        var inventoryImageId = "#inventory_image"+choices;
        $((inventoryImageId)).attr("src", src);        
      }); 
    }   

    a.offer_description = "";
    a.what_you_get = "";
    a.cost = "";

 
    a.include_price=function()
    {      
      // this function will get executed every time the #home element is clicked (or tab-spacebar changed)
      if($("#include_product_value").is(":checked")) // "this" refers to the element that fired the event
      {
        //var selling_price_class_items = $('.selling_price_class').length;
        
        // Sum Retails value price
        var total = 0;
        var $changeInputs = $('input.selling_price_class');
        $changeInputs.each(function(idx, el) 
        {
          total += Number($(el).val());
        });
        $('#retails_value').val(total);
        //$('#pay_value').val(total);
        
      }
    }

    a.set_discount=function()
    {
      //alert("b");
      var retails_value=$("#retails_value").val();
      var pay_value=$("#pay_value").val();

      var discount=parseFloat(retails_value)-parseFloat(pay_value);

      var value_calculate=$("input[name=value_calculate]:checked").val();

      if(value_calculate==2 || value_calculate==4 || value_calculate==6)
      {
        var total_discount=discount.toFixed(2);
        var total_discount_show='$'+total_discount;
      }
      if(value_calculate==1 || value_calculate==3 || value_calculate==5)
      {
        var total_discount=((discount/retails_value)*100).toFixed(2);
        var total_discount_show=total_discount+'%';
      }
      $("#off_value").val(total_discount);
      $("#discount_value").val(total_discount);
      $("#saving_value").val(total_discount);
      $("#save_value_show").html(total_discount_show);

     // alert(discount);
    }
 
   
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

  a.add_offer=function()
  {
   // alert(a.inventory_id);
     var inventoryId=null;
   //  var product_id=null;
     var product_id_str='';
     $(".inventory_class").each(function(){
        inventoryId = $(this).attr('id');
        //alert(inventoryId);
        var product_id=$("#"+inventoryId).val();
        //if(product_id_str)
        //{
        product_id_str+=product_id+',';
        //}

        // alert(product_id);
     });
    //$("")
    
    a.promotion_arr={};
    var campaign_id=$("#campaign_id").val();
    var category_id=$("#category_id").val();
    var subcat_id=$("#subcat_id").val();
    var offer_description=$("#offer_description").val();
    var total_redeemar=$("#total_redeemar").val();
    var total_redeemar_price=$("#total_redeemar_price").val();
    var c_s_date=$("#c_s_date").val();
    var c_e_date=$("#c_e_date").val();
    var total_payment=$("input[type='radio'][name='total_payment']:checked").val();
    var what_you_get=$("#what_you_get").val();
    var more_information=$("#more_information").val();


    var pay_value=$("#pay_value").val();
    var retails_value=$("#retails_value").val();
    var include_product_value=$("#include_product_value").val();    
    var value_calculate=$("input[type='radio'][name='value_calculate']:checked").val();
    var discount='';

    var product_id_str=product_id_str.replace(/^,|,$/g,'');

    //alert(product_id_str);

    //var inventory_id=$("#inventory_id").val();  
    // var selectArray = $('[id^=inventory_id]');
    // var ids = selectArray.map(function() {
    //     return this.id.replace("inventory_id['", "").replace("']", "");
    // }).get().join();
    // alert(ids); 
    //alert(JSON.stringify($('select[name=inventory_id]').val(), null, 4));

   // alert(value_calculate);
    if(value_calculate==1 || value_calculate==2)
    {
      var value_calculate=1;
      var off_value=$("#off_value").val();
      discount=off_value;
    }
    if(value_calculate==3 || value_calculate==4)
    {
      var value_calculate=2;
      var discount_value=$("#discount_value").val();
      discount=discount_value;
    }
    if(value_calculate==5 || value_calculate==6)
    {
      var value_calculate=3;
      var saving_value=$("#saving_value").val();
      discount=saving_value;
    }

    
    a.promotion_arr.campaign_id=campaign_id;
    a.promotion_arr.category_id=category_id;
    a.promotion_arr.subcat_id=subcat_id;
    a.promotion_arr.offer_description=offer_description;
    a.promotion_arr.total_redeemar=total_redeemar;
    a.promotion_arr.total_redeemar_price=total_redeemar_price;
    a.promotion_arr.c_s_date=c_s_date;
    a.promotion_arr.c_e_date=c_e_date;
    a.promotion_arr.total_payment=total_payment;
    a.promotion_arr.what_you_get=what_you_get;
    a.promotion_arr.more_information=more_information;

    a.promotion_arr.value_calculate=value_calculate;
    a.promotion_arr.pay_value=pay_value;
    a.promotion_arr.retails_value=retails_value;
    a.promotion_arr.include_product_value=include_product_value;
    a.promotion_arr.discount=discount;
    a.promotion_arr.product_id_str=product_id_str;

   // alert(JSON.stringify(a.promotion_arr, null, 4));

    // x.post("../promotion/storeoffer",a.promotion_arr).success(function(response){
    //   alert(response);
    // });
  }

}]);