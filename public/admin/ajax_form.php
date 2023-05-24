<?php
header('content-type:text/html;charset=utf-8');
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
$my_string = "";
$admin_type_idr = get_value_condition("admin_type_idr","tbl_admin","username_str = '". $_SESSION["manager"]."'");
if ( (isset( $_GET[ "table" ] ) && isset($_GET["id"]) && $_GET["id"] > 0) || $_GET["new"]){
		$cn = $_GET["table"];
		$table_name = "tbl_".$cn;
		$table_id = get_value_condition("id","tbl_table","display_name_str= '". $table_name."'");
		if($_GET["new"]){
			$frm_id = 0;
		}else{
			$frm_id = $_GET["id"];
		}
		
		$frm_query = load_data($table_name,0);	
		$ctr = 0;
		$my_string  .= '<input type="hidden" name="subform_mark_mrk" value="1" />';
			while($frm_row 	= mysqli_fetch_array($frm_query))
			{
				$frm_field = $frm_row['cn'];
				if($frm_row['cc']!=NULL){
					$frm_comment = $frm_row['cc'];
				}else{
					$frm_comment = "NAN";
				}
				//echo $frm_field;
				$admin_type_idr = get_value_condition("admin_type_idr","tbl_admin","username_str = '". $_SESSION["manager"]."'");
			//get admin type
				$show_fields_str = get_value_condition("show_fields_str","tbl_admin_tables","(admin_type_idr=".$admin_type_idr.") AND 	(table_idr = ".$table_id.")");
				
				
				
			$sfs_array = "";
			$ufs_array = "";
			//echo $show_fields_str;
			if($show_fields_str != "*" && $show_fields_str != NULL){
				$sfs_array = explode(",",$show_fields_str );
				
				if (in_array($ctr, $sfs_array)){
					//echo $my_field;
					
					$my_string .= get_form_fields($frm_field,$frm_comment,$table_name,$frm_id);
				}
			}else{
				$my_string .= get_form_fields($frm_field,$frm_comment,$table_name,$frm_id);
			}
				$ctr++;
			}
			
		$my_string .= '
			</div>';
			echo $my_string;
	 }
	   
	   
?>
<script>
$(document).ready(function(e) {
    $( "select" ).select2();
	$( ".isr" ).each(function( index ) {
			var data_table = $(this).data("table");
			
			$(this).select2({
				placeholder: "Select " + data_table,
				minimumInputLength: 3,
				ajax: {
					url: 'option.php',
					dataType: "json",
					type: "GET",
					data: function (params) {
						var queryParameters = {
							q: params.term,
							table: data_table
						}
						return queryParameters;
					},
					processResults: function (data) {
						return {
							results: $.map(data, function (item) {
								return {
									text: item.display_name_str + " - " + ((item.customer_name_str != null) ? item.customer_name_str :'') + ((item.asset_description_str != null) ? item.asset_description_str :''),
									id: item.id
								}
							})
						};
					}
				}
			});
		});
		
});
</script>