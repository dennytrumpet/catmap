        /* <![CDATA[ */
            jQuery(document).ready(function() {     
                jQuery('#parent_cat').change(function(){
                    var parentCat=jQuery('#parent_cat').val();
                    // call ajax
                    jQuery.ajax({
                        url:"/wp-admin/admin-ajax.php",
                        type:'POST',
                        data:'action=category_select_action&parent_cat_ID=' + parentCat,
                        success:function(results)
                        {
                        jQuery("#sub_cat_div").html(results);
                        }
                     });
                });
                jQuery('#child_cat').change(function(){
                    var childCat=jQuery('#child_cat').val();
                    // call ajax
                    jQuery.ajax({
                        url:"/wp-admin/admin-ajax.php",
                        type:'POST',
                        data:'action=category_select_action&child_cat_ID=' + childCat,
                        success:function(results)
                        {
                        jQuery("#cat_post_div").html(results);
                        }
                     });
                });                          
            });     
        /* ]]> */