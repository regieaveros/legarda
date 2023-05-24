
<?php include ("functions/thumb.php");?>
<?php

if(isset($_GET["table"]))
{
	
	$id 	= 0;
	if(isset($_GET["id"]))
	{
		$id = $_GET["id"];
	}
	$table 		= $_GET["table"];
	$table_name = "tbl_" . $_GET["table"]; 
	
	$query 		= load_data($table_name,0);
	
}
$form_title = "";
$submit_string	 = "Submit";
if(isset($_GET["table"]))
{
	$table 			 = ucwords($_GET["table"]);
	$table_id = get_value_condition("id","tbl_table","display_name_str='tbl_".$table."'");
	$form_title = get_value_condition("title_str","tbl_table","display_name_str='tbl_".$table."'");
	if(isset($_GET["update"]))
	{
		$submit_string = "Submit";
		$form_title		 = "Update ".$form_title;
	}
	
}

?>
<?php
	$table 		= isset($table) 		? $table 		 : '';
	$table_name = isset($table_name) 	? $table_name	 : '';
?>
<?php
	if(isset($_POST["submit"]))
	{
		submit_form($table_name,$id);
	}
?>
<?php 
if(isset($_GET["table"]))
{
?>
<script>
$(document).ready( function() {
    	$(document).on('change', '.btn-file :file', function() {
		var input = $(this),
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [label]);
		});

		$('.btn-file :file').on('fileselect', function(event, label) {
		    
		    var input = $(this).parents('.input-group').find(':text'),
		        log = label;
		    
		    if( input.length ) {
		        input.val(log);
		    } else {
		        if( log ) alert(log);
		    }
	    
		});
	

			
	});
</script>

<div class="container-fluid jumbotron p-5 fieldset">
	<div class="form-container shadow">
    <div class="row">
    <div class="col-md-12 my-form">
    	<h2><?php echo str_replace("_"," ",$form_title); ?></h2>
        <form id="update_form" method="post" enctype="multipart/form-data">
		<?php 
        if(isset($query))
        {
		$ctr = 0;	
        while($row 	= mysqli_fetch_array($query))
        {
            $my_field = $row['cn'];
			if($row['cc']!=NULL){
				$frm_comment = $row['cc'];
			}else{
				$frm_comment = "NAN";
			}
			$admin_type_idr = get_value_condition("admin_type_idr","tbl_admin","username_str = '". $_SESSION["manager"]."'");
			//get admin type
			
			$show_fields_str = get_value_condition("show_fields_str","tbl_admin_tables","(admin_type_idr=".$admin_type_idr.") AND 	(table_idr = ".$table_id.")");
			$sfs_array = "";
			if($show_fields_str != "*" && $show_fields_str != NULL){
				$sfs_array = explode(",",$show_fields_str );
				
				if (in_array($ctr, $sfs_array)){
					//echo $my_field;
					check_table_field($my_field,$frm_comment,$table_name,$id);
				}
			}else{
				check_table_field($my_field,$frm_comment,$table_name,$id);
			}
	
			$ctr ++;	
        }
            }
        ?>
        <div class="form-group formbuttons">
            <a href="#" class="btn btn-primary" id="mysubmit_button"><i class="fa fa-plus"></i></i> Submit</a>
            <input id="submit" hidden class="btn btn-primary fa-plus" type="submit" name="submit" value="<?php echo $submit_string?>">
            <a href="index.php?table=<?php echo strtolower($table); ?>" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
        </div>
        </form>
    </div>
    </div>
    </div>
</div>
<?php
}
?>
<script>
$("#mysubmit_button").bind('click', function(event) {
		//alert("im here");
   $("#submit").click();
});

window.setInterval(function(){
  /// call your function here
  var i = 1;

  $(".nice-txt").val($(".nicEdit-main").html());
  //alert("im here");
  
}, i++);
</script>
<script src="js/nice-edit.js" type="text/javascript"></script>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {

	$('.myNicEditor').summernote();

});
//]]>

    $('.clear').click(function() {
        
    var delete_id = $(this).data("target");
	var delete_file = $(this).data("targetfile");
	
	//$('#'+delete_id).remove()
	$.ajax({
		type:'POST',
		url:'ajax_delete.php',
		data:{delete_file:delete_file},
    		success: function(data){
    			 if(data=="YES"){
    				 $('#'+delete_id).remove()
    			 }else{
    				 alert("Can't Delete");
    				 console.log(delete_file);
    			 }
    		}

		})
		
	});
	
	
	
	function previewImages() {

      var $preview = $('#preview').empty();
      if (this.files) $.each(this.files, readAndPreview);
    
      function readAndPreview(i, file) {
        
        if (!/\.(jpe?g|png|gif)$/i.test(file.name)){
          return alert(file.name +" is not an image");
        } // else...
        
        var reader = new FileReader();
    
        $(reader).on("load", function() {
          $preview.append($("<img/>", {src:this.result, height:160}));
        });
    
        reader.readAsDataURL(file);
        
      }
      
      $('#btn-clear').show();
    
    }
    
    $('#file-input').on("change", previewImages);
    $('#btn-clear').hide();
    
    $('#btn-clear').on('click', function(){
        $('#preview').html("");
        $('#btn-clear').hide();
    });
	

</script>