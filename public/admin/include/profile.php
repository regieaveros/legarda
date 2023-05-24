<?php
if(isset($_POST["submit"]))
	{
		$id = $_POST["id"];
		submit_form("tbl_admin",$id);
	}

	$admin_id = get_value_condition("id","tbl_admin","username_str = '". $_SESSION["manager"]."'");
	$query 	  = load_data("tbl_admin",0);
	
	
?>
<div class="container-fluid jumbotron p-5 fieldset">
    <div class="row">
        <div class="col-md-12">
        	<h2 class="table-title">Update Profile</h2>
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
			$table_admin_id = get_value_condition("id","tbl_table","display_name_str = 'tbl_admin'");
			$table_name = "tbl_admin";
			$show_fields_str = get_value_condition("show_fields_str","tbl_admin_tables","(admin_type_idr=".$admin_type_idr.") AND 	(table_idr = ".$table_admin_id.")");
			$sfs_array = "";
			//echo $show_fields_str;
			if($show_fields_str != "*" && $show_fields_str != NULL){
				$sfs_array = explode(",",$show_fields_str );
				
				if (in_array($ctr, $sfs_array)){
					//echo $my_field;
					check_table_field($my_field,$frm_comment,$table_name,$admin_id);
				}
			}else{
				check_table_field($my_field,$frm_comment,$table_name,$admin_id);
			}
			//echo $ctr;
			$ctr ++;	
        }
            }
        ?>
        <div class="form-group formbuttons">
            <a href="#" class="btn btn-primary" id="mysubmit_button"><i class="fa fa-plus"></i></i> Submit</a>
            <input id="submit" hidden class="btn btn-primary fa-plus" type="submit" name="submit" value="<?php echo $submit_string?>">
            <a href="index.php" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
        </div>
        </form>
        </div>
    </div>
</div>

<script>
$("#mysubmit_button").bind('click', function(event) {
		//alert("im here");
   $("#submit").click();
});
</script>
