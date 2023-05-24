<?php
$message = "";

if(isset($_GET["status"]))
{
	$stat_table = "";
	if(isset($_GET["table"]))
	{
		$stat_table = $_GET["table"];
		$tbl_stat_table = "tbl_".$stat_table;
		//$stat_table = ucwords($stat_table);
		$table_title = get_value_condition("title_str","tbl_table","display_name='".$tbl_stat_table."'");
	}
	
	$status = $_GET["status"];
	if($status == "failed")
	{
		$message = '<div class="alert alert-danger">
  <strong> Failed! </strong> Action Failed!
</div>';
	}
	elseif($status == "added")
	{
		$message = '<div class="alert alert-success">
  <strong>Success!</strong> '.$table_title.' Added Successfully!
</div>';
	}
	elseif($status == "updated")
	{
		$message = '<div class="alert alert-success">
  <strong>Success!</strong> '.$table_title.' Updated Successfully!
</div>';
	}
	elseif($status == "deleted")
	{
		$message = '<div class="alert alert-success">
  <strong>Success!</strong> '.$table_title.' Deleted Successfully!
</div>';
	}
}
echo $message;
?>