<?php
include ("functions/fn_main.php");
include ("functions/fn_connect.php");
$detail_query = select_db("tbl_detail", '*', "","(id=1)",2);
$details = mysqli_fetch_array($detail_query);

if(!isset($_SESSION)) { session_start(); }
$logged_in = loggedin("manager");
if($logged_in == FALSE){
	header("Location: login.php");
}else{
	$current_user = $_SESSION["manager"];
	$count = get_value_condition("count(*)","tbl_admin","(username_str='$current_user')");
	if($count >=1){
		$admin_query = select_db("tbl_admin", '*', "","(username_str='$current_user')",2);
		$admin = mysqli_fetch_array($admin_query);
	}else{
		redirect("login.php");
	}
}
if(!isset($_SESSION["manager"])){
	redirect("login.php");
}
function redirect($url){

      echo("<meta http-equiv='refresh' content='0;".$url."' />");
}
$detail_query = select_db("tbl_detail", '*', "","(id=1)",2);
$details = mysqli_fetch_array($detail_query);
	if(isset($_GET["table"])&&isset($_GET["q"]))
	{
		$qry = addslashes(strip_tags($_GET["q"]));
		$option_table = "tbl_".addslashes(strip_tags($_GET["table"]));
		echo get_options_like($option_table,0,$option_table,$qry,5);
	}
?>
