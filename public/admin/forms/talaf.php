<?php include ("../functions/fn_connect.php");?>
<?php include ("../functions/fn_main.php");?>
<?php
$detail_query = select_db("tbl_detail", '*', "","(id=1)",2);
$details = mysqli_fetch_array($detail_query);
$d = $details;
$b = $d["base_url_str"];
$bi = $d["base_url_str"] . 'uploads/';
if(isset($_GET["id"])){
	$id = $_GET["id"];
$requests_query = select_db("tbl_requests", '*', "","(id=".$id.")",2);
$r = mysqli_fetch_array($requests_query);
?>
<link rel="stylesheet" type="text/css" href="forms.css">

<div class="talaf-container" style="background-image:url('tala.jpg')">
<img src="<?=$b?>forms/tala.jpg">
	<div class="obj" id="cus_name"><?=get_value_condition("display_name_str","tbl_store", "id = '". $r["store_idr"] . "'");?></div>
    <div class="obj" id="cus_address"><?=get_value_condition("address_str","tbl_store", "id = '". $r["store_idr"] . "'");?></div>
    <div class="obj" id="cus_contact"><?=get_value_condition("contact_no_str","tbl_store", "id = '". $r["store_idr"] . "'");?></div>
	<div class="obj" id="cus_telephone"><?=get_value_condition("contact_no_str","tbl_store", "id = '". $r["store_idr"] . "'");?></div>
	<div class="obj" id="cus_contact_person"><?=get_value_condition("contact_person_str","tbl_store", "id = '". $r["store_idr"] . "'");?></div>
	
    <div class="obj" id="cus_remarks"><?=$r["remarks_lng"];?></div>
    <div class="obj" id="cus_deployment"><?=get_value_condition("display_name_str","tbl_deployment_type", "id = '". $r["deployment_type_idr"] . "'");?></div>
	<div class="obj" id="cus_asset"><?=get_value_condition("display_name_str","tbl_assets", "id = '". $r["assets_idr"] . "'");?></div>
	
</div>
<?php
}
?>