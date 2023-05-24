<?php
function redirect($url){

      echo("<meta http-equiv='refresh' content='0;".$url."' />");
}
?>
<?php
include ("functions/fn_connect.php");
include ("functions/fn_main.php");

$message = "";
if (isset($_POST['time-in'])){
	if(isset($_POST['employee_id'])){
		$employee_id = $_POST["employee_id"];
		date_default_timezone_set('Asia/Manila');
		$time_in = date("H:i:s a");
		$time_in_date = date("Y-m-d");
		$time_in_query = insert_db("tbl_attendance","admin_idr,time_in_tim,date_dat",$employee_id.",'".$time_in."','".$time_in_date."'",2);
		
		if($time_in_query){
			redirect("attendance.php?status=success");
		}else{
			redirect("attendance.php?status=failed");
		}
	}else{
		redirect("attendance.php?status=failed");
	}
	//echo $time_in_query;
	//echo $employee_id;
}
if(isset($_GET["status"])){
	$status = $_GET["status"];
	if($status =="success"){
		$message = '<alert class="alert alert-success">Time In Succesful!</alert>';	
	}
	if($status =="failed"){
		$message = '<alert class="alert alert-danger">Time In Failed! Please Try Again</alert>';	
	}
}
if(isset($_GET["timeout"])){
	$timeout_id = addslashes(strip_tags($_GET["timeout"]));
	date_default_timezone_set('Asia/Manila');
	$time_out = date("H:i:s a");
	$timeout_query = update_db("tbl_attendance","time_out_tim = '".$time_out."'","id=$timeout_id",1);
	//echo $timeout_query;
}
?>
<?php
$detail_query = select_db("tbl_detail", '*', "","(id=1)",2);
$details = mysqli_fetch_array($detail_query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title><?=$details["website_name_str"];?> - Attendance Time Keeping</title>
  <link rel="icon" type="image/png" href="<?=$details["base_url_str"]?>admin/uploads/logo/favicon/<?php echo $details["favicon_log"]; ?>">
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  
</head>

<body id="time-in" class="bg-dark-brown" style="background-size:cover !important;background:url('<?=$details["base_url_str"];?>uploads/bg/<?=$details["bg_img"];?>');">
  <div class="container">
    <div class="card text-center bg-dark-50 card-login mx-auto mt-5">
      <div class="card-header bg-dark-50">
      <div class="img-container">
      <img src="<?=$details["base_url_str"];?>uploads/logo/logo/<?=$details["logo_log"];?>">
      </div>
	  <?=$details["website_name_str"];?> - Attendance Time Keeping
      
      </div>
      <div class="card-body">
        <form method="post">
          <div class="form-group">
            <label for="exampleInputEmail1">Enter Employee Name or ID</label>
            <select name="employee_id" class="form-control">
            	<option selected disabled>Search...</option>
                <?php
					$date_now = date("Y-m-d");
                	$employees_query = select_db("tbl_admin","*","","admin_type_idr=2 AND id NOT IN (SELECT admin_idr FROM tbl_attendance WHERE date_dat = '$date_now')",2);
					while($employee = mysqli_fetch_array($employees_query)){
				?>
                	<option value="<?=$employee["id"];?>"><?=$employee["display_name_str"];?></option>
                <?php
					}
				?>
            </select>
          </div>
          <input type="submit" name="time-in" class="form-control btn-info" value="Time In">
        </form>
        <div class="message-cont">
        <?=($message!=""?$message:"")?>
        </div>
        <div class="table-cont">
        <table class="table table-stripe">
        	<thead>
            	<tr>
                	<th>Employee</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
			<?php
				
				$time_query = select_db("tbl_attendance","*","","date_dat = '$date_now'",2);
				while($time = mysqli_fetch_array($time_query)){
					$time_in = $time["time_in_tim"];
					$time_out = $time["time_out_tim"];
					$timein_12hf  = date("g:i a", strtotime($time_in));
					
					if($time_out != '00:00:00'){
						$timeout_12hf  = date("g:i a", strtotime($time_out));
					}else{
						$timeout_12hf = "";	
					}
					
			?>
            	<tr>
                	<td><?=get_relative("tbl_admin",$time["admin_idr"]);?></td>
                    <td><?=$timein_12hf;?></td>
                    <td><?=$timeout_12hf;?></td>
                    <td><a class="btn btn-success" href="attendance.php?timeout=<?=$time["id"];?>">Time Out</a></td>
                </tr>
            <?php	
				}
			?>
            </tbody>
        </table>
        </div>
      </div>
    </div>
    
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
	<script>
  	$(document).ready(function(e) {
		 $("select").select2();
    });
  </script>
</body>

</html>
