  jQuery(document).ready(function(){

        if(jQuery('.button-large.copy-field').length){
            
            jQuery('.button-large.copy-field').bind('click', function() {
                    
                    //ids
                    var idVals = jQuery('#acf-field_5ddf9b161a49e').val();
                    var fromId = jQuery('#post_ID').val();                    

                    // options                    
                    var copyOptions = false;
                    
                    if(jQuery("#acf-field_5ddf9b471a49f-Optional-Extras").is(':checked')) 
                    {
                        var copyOptions = true;   
                    }
                    
                    //addons                    
                    var copyAddons = false;
                    
                   if(jQuery("#acf-field_5ddf9b471a49f-Product-Addons").is(':checked')) 
                    {
                        var copyAddons = true;   
                    }                    
                    
                    
                    var jqxhr = jQuery.ajax({
                      type: "POST",
                      url: "/wp-admin/admin.php?page=gvg_bulk_update&tab=copy_optional_upgrades", //"/copy-fh79y739yq3.php",
                      data: {
                          fromId: fromId,
                          idVals: idVals,
                          copyOptions: copyOptions,
                          copyAddons: copyAddons                                                    
                      }
                    })
                    .done(function() {
                        alert( "copied" );                        
                    })
                    .fail(function() {
                        alert( "error - failed to copy" );
                    });
            });
        }
    });