
<?php
function get_user_name($id, $return)
{
	include 'connectdb.php'; 
	$sql_string = "SELECT CONCAT(first_name, ' ', last_name) as name FROM tbl_users WHERE id = ".$id;
	$query = mysqli_query($con,$sql_string);
	while($get_row = mysqli_fetch_array($query))
	{
		$name = $get_row['name'];
	}
	if($return==1)
	{
		return $sql_string;
	}
	elseif($return==2)
	{
		return $name;
	}
	else
	{
		return 0;
	}
}

function get_shop_name($id, $return)
{
	include 'connectdb.php'; 
	$sql_string = "SELECT shop_name as name FROM tbl_services WHERE id = ".$id;
	$query = mysqli_query($con,$sql_string);
	while($get_row = mysqli_fetch_array($query))
	{
		$name = $get_row['name'];
	}
	if($return==1)
	{
		return $sql_string;
	}
	elseif($return==2)
	{
		return $name;
	}
	else
	{
		return 0;
	}
}

function get_category_name($id, $return)
{
	include 'connectdb.php'; 
	$sql_string = "SELECT category_name as name FROM tbl_categories WHERE category_id = ".$id;
	$query = mysqli_query($con,$sql_string);
	while($get_row = mysqli_fetch_array($query))
	{
		$name = $get_row['name'];
	}
	if($return==1)
	{
		return $sql_string;
	}
	elseif($return==2)
	{
		return $name;
	}
	else
	{
		return 0;
	}
}

function get_subcategory_name($id, $return)
{
	include 'connectdb.php'; 
	$sql_string = "SELECT subcategory_name as name FROM tbl_subcategories WHERE subcategory_id = ".$id;
	$query = mysqli_query($con,$sql_string);
	while($get_row = mysqli_fetch_array($query))
	{
		$name = $get_row['name'];
	}
	if($return==1)
	{
		return $sql_string;
	}
	elseif($return==2)
	{
		return $name;
	}
	else
	{
		return 0;
	}
}

?>