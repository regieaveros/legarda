<?php
function redirect($url){
      echo("<meta http-equiv='refresh' content='0;".$url."' />");
}
?>

<?php
include ("functions/fn_connect.php");
include ("functions/fn_main.php");
$detail_query = select_db("tbl_detail", '*', "","(id=1)",2);
$details = mysqli_fetch_array($detail_query);

$error ='';
$error2='';
session_start();
if (isset($_POST['login']))
{
	$username = addslashes(strip_tags($_POST['username']));
	$password = addslashes(strip_tags($_POST['password']));	
	if ($username&&$password)
	{
	$login = mysqli_query($con,"SELECT * FROM tbl_admin WHERE username_str='$username'");			
	if (mysqli_num_rows($login)!=0)
	{
		//code to login
		while ($row = mysqli_fetch_assoc($login))
		{
			$dbpassword = $row ['password_psw'];
			$admin_id = $row["id"];
			$admin_branch_idr = $row["branch_idr"];
			$password = md5($password);
		
			if ($password != $dbpassword)
			{
				$error = '<div class="alert alert-error fg-crimson bg-danger"><span class="mif-warning mif-ani-flash mif-ani-slow mif-2x"></span> Incorrect username or password</div>';
			}
			else
			{
			
			$_SESSION['manager']=$username;
			$_SESSION['admin_id'] = $admin_id;
			$_SESSION['admin_branch_idr'] = $admin_branch_idr;
			//echo 'test';
			//echo $admin_branch_idr;
			$session_id = session_id();
			$location_str = $details["base_url_str"]."admin/index.php?session_id=".$session_id;
			//echo $location_str;
			redirect($location_str);
			exit();
			}
		}
	}
	else
	{
	$error = '<div class="alert alert-error bg-danger"><span class="mif-blocked mif-ani-horizontal mif-ani-slow mif-2x"> </span> That user doesnt exist!</div>';
			
	}			
	}
	else
	$error = '<div class="alert alert-error bg-danger"><span class="mif-pencil mif-ani-float mif-ani-fast mif-2x"> </span> Please enter a username and password</div>';
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
  <title><?=$details["website_name_str"];?> - Admin Login</title>
  <link rel="icon" type="image/png" href="<?=$details["base_url_str"]?>admin/uploads/favicon/<?php echo $details["favicon_img"]; ?>">
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  
</head>

<body id="login" class="bg-dark-brown" style="background-size:cover !important;background:url('<?=$details["base_url_str"];?>admin/uploads/bg/<?=$details["bg_img"];?>');">
  <div class="container">
    <div class="card text-center bg-dark-50 card-login mx-auto mt-5">
      <div class="card-header bg-dark-50">
      <div class="img-container">
      <img src="<?=$details["base_url_str"];?>admin/uploads/logo/<?=$details["logo_img"];?>" height="100">
      </div>
	  <?=$details["website_name_str"];?> - Admin Login
      
      </div>
      <?php echo $error; ?>
      <div class="card-body">
        <form method="post">
          <div class="form-group">
            <label for="exampleInputEmail1">Username</label>
            <input class="form-control" name="username" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="Enter Username">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input class="form-control" name="password" id="exampleInputPassword1" type="password" placeholder="Password">
          </div>
          <input type="submit" name="login" class="form-control btn-info" value="Login">
        </form>
      </div>
    </div>
    
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  
</body>

</html>
