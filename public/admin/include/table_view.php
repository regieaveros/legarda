
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
	$form_title		 = $table ." Form";
	if(isset($_GET["update"]))
	{
		$submit_string = "Submit";
		$form_title		 = "Update ".$table;
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
		function readURL(input) {
		    if (input.files && input.files[0]) {
		        var reader = new FileReader();
		        
		        reader.onload = function (e) {
		            $('#img-upload').attr('src', e.target.result);
		        }
		        
		        reader.readAsDataURL(input.files[0]);
		    }
		}

		$("#imgInp").change(function(){
		    readURL(this);
		}); 	
	});
</script>

<div class="container-fluid jumbotron p-5 fieldset">
    <div class="row">
    <div class="col-md-12 my-form">
    	<h2><?php echo $form_title; ?></h2>
        <form id="update_form" method="post" enctype="multipart/form-data">
		<?php 
        if(isset($query))
        {
			
        while($row 	= mysqli_fetch_array($query))
        {
            $my_field = $row['cn'];
            check_table_field($my_field,$table_name,$id);
			
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
<?php
}
?>
<script>
$("#mysubmit_button").bind('click', function(event) {
		//alert("im here");
   $("#submit").click();
});
$( document ).ready(function() {
	
    $(".nicEdit-main").html($(".nice-txt").val());
});
window.setInterval(function(){
  /// call your function here
  $(".nice-txt").val($(".nicEdit-main").html());
  
  
}, 1);
</script>
<script src="js/nice-edit.js" type="text/javascript"></script>
<script type="text/javascript">
//<![CDATA[
bkLib.onDomLoaded(function() {
    nicEditors.editors.push(
        new nicEditor({fullPanel : true}).panelInstance(
            document.getElementById('myNicEditor')
        )
    );
});
//]]>
</script>