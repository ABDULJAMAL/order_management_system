$(document).ready(function() {
    
    $("#admin_home_cms").click(function(){
        $('input[type="checkbox"]').on('change', function() {    
            $('input[type="checkbox"]').not(this).prop('checked', false);
        });
    }); 
    $("#edit_button").click(function(){        
        $("input[type=checkbox]:checked").each(function(){
            var cms_place_name=$.trim($(this).closest('tr').children('td#cms_place_name').text());
            var image=$(this).closest('tr').children('td').children('img#image').attr("src");
            var no_image=$(this).closest('tr').children('td').children('p#no_image').text();
            var cms=$(this).closest('tr').children('td').children('input#cms').val();
            var cms_place=$(this).closest('tr').children('td').children('input#cms_place').val();
            var heading=$.trim($(this).closest('tr').children('td#heading').text());
            var sub_heading1=$.trim($(this).closest('tr').children('td#sub_heading1').text());
            $("#updadte_cms .cms_place_name").val(cms_place_name);
            if(no_image=='' || no_image==null)
            {
                $("#updadte_cms .image").attr('src',image);
                $("#file_upload").removeClass("hide");
            }
            else
            {
               $("#updadte_cms .image").attr('src',''); 
               $("#file_upload").addClass("hide");
            }
           /* if(sub_heading1=='' || sub_heading1==null)
            {
                $("#sub_heading1_modal").addClass("hide");                
            }
            else
            {
                $("#sub_heading1_modal").removeClass("hide");
            }*/
            $("#updadte_cms .heading").val(heading);
            $("#updadte_cms .sub_heading1").val(sub_heading1);
            $("#updadte_cms .cms_place").val(cms_place);
            $("#updadte_cms .cms").val(cms);
            $("#updadte_cms").modal()
        });            
    }); 
    $("#delete_button").click(function(){        
        $("input[type=checkbox]:checked").each(function(){
            var cms=$(this).closest('tr').children('td').children('input#cms').val();
            var rowToDelete = $(this).closest('tr');
                $.ajax({
                    url: siteUrl+"/admin/admin/delete_cms?row_id="+cms,
                    type: 'DELETE',
                        success:function(data){
                                $(rowToDelete).remove();
                        },
                        error: function(data){
                        }
                });
        });
    });
});
