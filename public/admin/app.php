<?php include ("functions/fn_connect.php");?>
<?php include ("functions/fn_main.php");?>
<?php include ("functions/thumb.php");?>
<?php
$detail_query = select_db("tbl_detail", '*', "","(id=1)",2);
$details = mysqli_fetch_array($detail_query);
$d = $details;
$b = $d["base_url_str"];
$bi = $d["base_url_str"] . 'uploads/';

function redirect($url){
      echo("<meta http-equiv='refresh' content='0;".$url."' />");
}
function insert_form($table){
	$post_ctr = count($_POST);
	$file_ctr = count($_FILES);
	$fields = "";
	$values = "";
	$x = 0;
	$y = 0;
	foreach ($_FILES as $key => $value) {
		$my_field = $key;
		if(strpos($my_field,'_img'))
		{
			
					$img_field = strtolower(str_replace("_img","",$my_field));
					if (!file_exists("uploads/".strtolower($img_field))) {
					mkdir("uploads/".strtolower($img_field), 0777, true);
					}
					if (!file_exists("uploads/".strtolower($img_field)."/thumbs")) {
					mkdir("uploads/".strtolower($img_field)."/thumbs", 0777, true);
					}
					
					if($_FILES[$my_field]['name']!=NULL)
					{
						
						$image_id = $_POST["display_name_str"];
						$field_text = $_FILES[$my_field]['name'];
						//echo '<input type="text" value="'.$field_text.'" />';
						//echo $_FILES[$my_field]['name'];
						$image_name = $_FILES[$my_field]['name'];
						$image_size = $_FILES[$my_field]['size'];
						$image_temp = $_FILES[$my_field]['tmp_name'];
						$allowed_ext = array ('jpg', 'jpeg', 'png', 'gif');
						$image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
						$imageid = $image_id;
						$image_file = $imageid.'.'.$image_ext;
						//echo 'uploaded';
						//echo "uploads/".strtolower($img_field)."/";
						move_uploaded_file($image_temp,"uploads/".strtolower($img_field)."/".$image_file);
						create_thumb("uploads/".strtolower($img_field)."/", $image_file, "uploads/".strtolower($img_field)."/thumbs/");
						$fields .= $my_field;
						$values .= "'" . $image_file . "'";
						$fields .= ",";
						$values .= ",";
					}
					else
					{
						//echo '222';
						$fields .= $my_field;
						$values .= "'" . addslashes(strip_tags($_POST[$my_field])) . "'";
					}
				}
		else{
			echo ' im here2';
		}
	}
	
	foreach ($_POST as $key => $value) {
		$my_field = htmlspecialchars($key);
		//echo $my_field;

		if($x <$post_ctr-1){
		$fields .= htmlspecialchars($key);
		if($x != $post_ctr - 2)
			$fields .= ",";
		;
		$values .= "'".htmlspecialchars($value)."'";	
		if($x != $post_ctr - 2)

			$values .= ",";
		;
		$x ++;
		}
	} 
	//echo 'fields: '.$fields.'<br>';
	//echo 'values: '.$values.'<br>';
	insert_db($table,$fields,$values,2);
	//redirect("?sent");
	
}//END insert_form

function clean($string){
	return addslashes(strip_tags($string));
}

if(isset($_POST["new_audit"])){
	insert_form("tbl_audit");
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="icon" type="image/png" href="<?=$details["base_url_str"]?>admin/uploads/logo/favicon/<?php echo $details["favicon_log"]; ?>">
	<link rel="stylesheet" type="text/css" href="app_style.css">
    <link rel="stylesheet" type="text/css" href="app_responsiv.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <title>Froneri - App</title>
  </head>
  <body>
  	<div id="app">
    	<div class="app-nav">
        	<div class="an-logo">
            	<img src="<?=$details["base_url_str"]?>admin/uploads/logo/logo/<?php echo $details["logo_log"]; ?>" alt=""/>
            	<div class="an-title">Froneri Auditing App</div>
            </div>
            <div class="an-back">
            	<div data-target="#home-page" class="anb float-left"><i class="fa fa-arrow-left"></i> Go Back </div>
                <div data-target="#login" class="anb float-right"><i class="fa fa-door-open"></i> Exit</div>
            </div>
        </div>
    	<div id="home-page" class="page active">
        	<h2>Tap on an activity to start!</h2>
            <div data-target="#page1" class="anl shadow">New <i class="fa fa-plus-circle"></i></div>
            <div data-target="#page2" class="anl shadow">Edit <i class="fa fa-pen"></i></div>
            <div data-target="#page3" class="anl shadow">Sync <i class="fa fa-sync"></i></div>
            <div data-target="#page4" class="anl shadow">Get Version <i class="fa fa-arrow-right"></i></div>	
            <div data-target="#page5" class="anl shadow">Cancel <i class="fa fa-trash"></i></div>	
        </div>
        <div id="page1" class="page">
        	<h1>New Audit</h1>
            <form class="form" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Store Name</label>
               	<input type="text" name="store_name_str" class="form-control" /> 
            </div>
            <div class="form-group">
                <label>Store Photo</label>
               	<input type="file" name="store_img" class="form-control" /> 
            </div>
            <div class="form-group">
                <label>Choose Trade</label>
               	<div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="trade_str" value="Formal Trade">Formal Trade
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="trade_str" value="Convenience">General Trade
                  </label>
                </div> 
            </div>
            <div class="form-group">
                <label>Choose Trade Type</label>
               	<div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="trade_type_str" value="Convenience">Convenience
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="trade_type_str" value="Food Services">Food Services
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="trade_type_str" value="Fore court">Fore court
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="trade_type_str" value="Leisure">Leisure
                  </label>
                </div> 
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="trade_type_str" value="Supermarket">Supermarket
                  </label>
                </div>  
            </div>
            
            <div class="form-group">
                <label>Choose Store</label>
               	<div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="store_type_str" value="BP">BP
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="store_type_str" value="Cafe">Cafe
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="store_type_str" value="Caltex">Caltex
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="store_type_str" value="Casino">Casino
                  </label>
                </div> 
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="store_type_str" value="Checkers">Checkers
                  </label>
                </div>  
            </div>
            
            <div class="form-group">
            	<label>Get Current Location</label>
                <p>Please make sure to allow access to your location</p>
                <input readonly type="text" id="latitude" class="form-control" name="latitude_str" placeholder="latitude...">
                <input readonly type="text" id="longitude" class="form-control" name="longitude_str"  placeholder="longitude...">
                <p id="location"></p>
                <div class="btn btn-info get-location"> Get Location</div>
            </div>
            
            <div class="form-group">
                <label>What is the freezer user for?</label>
               	<div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="freezer_usage_str" value="Impulse">Impulse
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="freezer_usage_str" value="Take Home">Take Home
                  </label>
                </div> 
            </div>
            
            <div class="form-group">
                <label>What branding does the freezer have?</label>
               	<div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="freezer_brand_str" value="Dairymaid">Dairymaid
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="freezer_brand_str" value="Mondelez">Mondelez
                  </label>
                </div> 
            </div>
            
            <div class="form-group">
                <label>Brand Freezer type?</label>
               	<div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="freezer_type_str" value="Cool Diana 136l 2 Basket">Cool Diana 136l 2 Basket
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="freezer_type_str" value="Liebherr 145l 3 Basket">Liebherr 145l 3 Basket
                  </label>
                </div> 
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="freezer_type_str" value="Liebherr 254l 5 Basket">Liebherr 254l 5 Basket
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="freezer_type_str" value="Larp Upright">Larp Upright
                  </label>
                </div> 
            </div>
            
            <div class="form-group">
                <label>Freezer Photo</label>
               	<input type="file" name="freezer_img" class="form-control" /> 
            </div>
            
            <div class="form-group">
                <label>Freezer's Unique PPN Number</label>
               	<input type="text" name="freezer_ppn_number_str" class="form-control" /> 
            </div>
            
            <div class="form-group">
                <label>Nestle Plate Photo</label>
               	<input type="file" name="plate_img" class="form-control" /> 
            </div>
            
            <div class="form-group">
                <label>Get Barcode</label>
               	<input type="file" name="barcode_img" class="form-control" /> 
            </div>
            
            <div class="form-group">
                <label>Name This Audit</label>
               	<input type="text" name="display_name_str" class="form-control" /> 
            </div>
            
            <div class="form-group">
               	<input type="submit" name="new_audit" class="btn btn-success" value="Create" /> 
            </div>
            
            </form>
        </div>
        <div id="page2" class="page">
        	<h1>Edit Audits</h1>
            <div class="audit-container">
<?php
$audit_query = select_db("tbl_audit", '*', "","(1=1) ORDER BY id ASC",2);
while($audit = mysqli_fetch_array($audit_query)){
?>
            	<div class="audit">
                	<div class="audit-img"><img src="<?=$bi?>store/<?=$audit["store_img"];?>"></div>
                    <div class="audit-title"><?=$audit["display_name_str"];?></div>
                    <div class="audit-store"><?=$audit["store_name_str"];?></div>
                    <div class="audit-trade"><?=$audit["trade_str"];?></div>
                    <div class="audit-action"><i class="fa fa-pen"></i></div>
            	</div>
<?php
}
?>
            </div>
        </div>
        <div id="page3" class="page">
        	<h1>Sync Data</h1>
            <div class="btn btn-info btn-sync">Sync Data</div>
        </div>
        <div id="page4" class="page">
        	<h1>Update App</h1>
            <div class="btn btn-info btn-sync">Sync Data</div>
        </div>
        <div id="page5" class="page">
        	<h1>Delete Audits</h1>
            <div class="audit-container">
<?php
$audit_query = select_db("tbl_audit", '*', "","(1=1) ORDER BY id ASC",2);
while($audit = mysqli_fetch_array($audit_query)){
?>
            	<div class="audit">
                	<div class="audit-img"><img src="<?=$bi?>store/<?=$audit["store_img"];?>"></div>
                    <div class="audit-title"><?=$audit["display_name_str"];?></div>
                    <div class="audit-store"><?=$audit["store_name_str"];?></div>
                    <div class="audit-trade"><?=$audit["trade_str"];?></div>
                    <div class="audit-action"><i class="fa fa-trash"></i></div>
            	</div>
<?php
}
?>
            </div>
        </div>

    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  	<script>
		function sync(){
			alert("Data Synced!");
		}
		function update(){
			alert("App Version Succesfully Updated!");
		}
		$('.btn-sync').click(function(e) {
            sync();
        });
		$('.btn-update').click(function(e) {
            update();
        });
		$('.anl').click(function(e) {
		   $('.page').removeClass("active");
           var target = $(this).data("target");
		   $(target).addClass("active");
        });
		$('.anb').click(function(e) {
		   $('.page').removeClass("active");
           var target = $(this).data("target");
		   $(target).addClass("active");
        });
    	$(document).ready(function(e) {
            console.log("App Ready");
        });
		$('.get-location').click(function(e) {
            getLocation();
			alert("im here");
        });
		function showPosition(position) {
			$('#latitude').val(position.coords.latitude);
			$('#longitude').val(position.coords.longitude);
			$('#location').html('<div class="alert alert-success">Successfully Located!</div>');
		}
		function getLocation() {
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(showPosition);
			} else {
				
				$('#location').html('<div class="alert alert-warning">Geolocation is not supported by this browser.</div>');
			}
		}
		
    </script>
  </body>
</html>