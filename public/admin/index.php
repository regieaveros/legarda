<?php include ("functions/fn_connect.php");?>
<?php include ("functions/fn_main.php");?>

<?php
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, nicmust-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('content-type:text/html;charset=utf-8');
$detail_query = select_db("tbl_detail", '*', "","(id=1)",2);
$details = mysqli_fetch_array($detail_query);

$logged_in = loggedin("manager");
if($logged_in == FALSE){
	//header("Location: login.php");
	session_start();
	session_destroy();
	redirect("logout.php");
	//redirect("login.php");//echo 'RESULT 1';
}else{
	
	$current_user = $_SESSION["manager"];
	
	$count = get_value_condition("count(*)","tbl_admin","(username_str='$current_user')");
	
	if($count >=1){
		$admin_query = select_db("tbl_admin", '*', "","(username_str='$current_user')",2);
		$admin = mysqli_fetch_array($admin_query);
		$admin_type_idr = $admin["admin_type_idr"];
		$admin_id = $admin["id"];
		$admin_branch_idr = $admin["branch_idr"];
		
	}else{
		session_start();
		session_destroy();
		redirect("logout.php");

		//redirect("login.php");
		//echo 'RESULT 2';
	}
}

function redirect($url){

      echo("<meta http-equiv='refresh' content='0;".$url."' />");
}
if(isset($_GET["table"])){
	if(isset($_GET["notif_id"])){
		$notif_id = $_GET["notif_id"];
		update_db("tbl_admin_notifications","viewed_bol = 1","id=$notif_id",2);
	}
}

if(isset($_GET["table"]))
{
	$id 	= 0;
	if(isset($_GET["id"]))
	{
		$id = $_GET["id"];
	}
	$table 		= $_GET["table"];
	$table_name = "tbl_" . $_GET["table"]; 
}
?>
<?php
if(isset($_GET["table"])&&isset($_GET["id"])&&isset($_GET["yes"])&&isset($_GET["delete"]))
{
	
	$tb_name = $_GET["table"];
	//echo $tb_name;
	
	$table = "tbl_" . strtolower($_GET["table"]);
	$del_id = $_GET["id"];
	$del_query = delete_db($table,"id = ".$_GET["id"],2);
	
	redirect('index.php?table='.$_GET["table"]."&status=deleted");
	
}
?>
<!DOCTYPE html>
<html lang="en"><head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title><?=$details["website_name_str"];?> - Admin</title>
  <link rel="icon" type="image/png" href="<?=$details["base_url_str"]?>admin/uploads/favicon/<?php echo $details["favicon_img"]; ?>">

  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/help.css">

  <link rel="stylesheet" type="text/css" href="css/responsive.css">
  <link rel="stylesheet" type="text/css" href="css/jquery.autocomplete.css">
  <script src="js/jquery-3.3.1.min.js"></script>

  	<!-- Summernote -->
	<link href="summernote/dist/summernote-lite.css" rel="stylesheet" type="text/css" />
  
  <style>
  	.table-title, .form-container h2{
		border-bottom:solid 2px <?=$details["primary_col"];?>;
	}
  </style>
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
	<div class="loader-container">
        <img src="image/legarda-loading.gif" alt="Image" id="loader-image" />
      </div>
      
	<div class="app">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg fixed-top" id="mainNav" style="background:<?=$details["primary_col"];?>">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-topnav" id="exampleAccordion">
        <li id="logo" class="nav-logo" data-placement="right" title="Dashboard">
          <a class="nav-link" href="index.php">
            <span class="nav-link-text"><img src="<?=$details["base_url_str"]?>admin/uploads/logo/<?php echo $details["logo_img"]; ?>" alt=""/></span>
          </a>
          <div class="system-title"> <?=$details["website_name_str"]?></div>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto nav-right">
      	<li class="nav-user"><a href="index.php?profile"><?=$_SESSION["manager"];?></a></li>
      	<li class="notif-area" style="display:none;">
          <a href="#" class="nav-link" data-target="#notifications" data-toggle="collapse">
            <i class="fa fa-fw fa-bell"></i>
            <?php
			if(!isset($admin_id)){
				$admin_id = 0;
			}
            $notifs_query = select_db("tbl_admin_notifications","*","","admin_idr = ".$admin_id." AND viewed_bol=0",2);
			$notifs_count = 0;
			$notifs_count = mysqli_num_rows($notifs_query);
			$notifs_query = select_db("tbl_admin_notifications","*","","admin_idr = ".$admin_id."  AND viewed_bol=0 ORDER BY id DESC LIMIT 5",2);

			?>
            <div class="notif-span"><?=$notifs_count?></div>
          </a>
          
          <div id="notifications" class="collapse">
          	<?php
				if($notifs_count == 0){
					echo '<div>No new notifications</div>';
				}else{
					//echo mysqli_num_rows($notifs_query);
					while($notifs = mysqli_fetch_array( $notifs_query )){
						$table_name = get_value_condition("display_name_str","tbl_table","id=".$notifs["table_idr"]);
						$table_name = str_replace("tbl_","",$table_name);
						?>
							<a class="notifs" href="<?=$details["base_url_str"]?>index.php?table=<?=$table_name?>&notif_id=<?=$notifs["id"]?>"><?=$notifs["display_name_str"]?> - <?=$notifs["notification_str"];?></a>
						<?php	
					}
				}
			?>
          </div>
          
        </li>
        <li class="nav-item">
          <a href="logout.php" class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Logout</a>
        </li>
      </ul>
    </div>
  </nav>
  
  <div class="sidebar">
  	<div class="btn btn-toggler"><i class="fa fa-list"></i></div>
    <div class="sb-navs" style="background:<?=$details["secondary_col"];?>">
    <a class="nav-link" href="<?=$details["base_url_str"];?>admin/index.php">
        <i class="fa fa-fw fa-dashboard"></i> Dashboard
    </a>
<?php
	$group_arr = get_value_condition("group_arr","tbl_admin_type","(id = " . $admin["admin_type_idr"].")");
	if(!isset($group_arr)){
		$group_arr = "0";
	}
	$admin_groups = str_replace('-',',',$group_arr);  
	if(!isset($admin_groups) || $admin_groups == ""){
			$admin_groups = "0";
	}
	$load_tablesq = select_db("tbl_group", '*', "","id IN (".$admin_groups.") ORDER BY display_name_str ASC",2);
	//echo $load_tablesq;
	
	while($groups = mysqli_fetch_array($load_tablesq))
	{
		$group_name = $groups["display_name_str"];
		$group_display_name = str_replace("tbl_","",$group_name);
		$group_display_name = ucwords($group_display_name);	
		$new_group_display_name = $group_display_name;
?>
		<li id="nav-<?php echo $new_group_display_name; ?>" class="nav-item" data-placement="right" title="<?php echo $new_group_display_name; ?>">
	  <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#<?php echo $new_group_display_name; ?>" data-parent="#exampleAccordion">
		<i class="fa fa-fw <?=$groups["fa_icon_str"]?>"></i>
		<span class="nav-link-text"><?php echo $new_group_display_name; ?></span>
	  </a>
		

	  <ul class="topnav-second-level collapse" id="<?php echo $new_group_display_name; ?>">
	  <?php
	  
	  $load_tables = select_db("tbl_table", '*', "","(group_idr=".$groups["id"].") ORDER BY title_str ASC",2);
	while($tables = mysqli_fetch_array($load_tables))
	{
		$tablesq_name = $tables["display_name_str"];
		$display_name = str_replace("tbl_","",$tablesq_name);
		$display_name = ucwords($display_name);	
		$new_displayname = pluralize($display_name);
		
	
	  ?>
		<a href="index.php?table=<?php echo strtolower($display_name); ?>">
		<li>
		  <?=$tables["title_str"]?>
		</li>
		</a>
		<?php
	}
	

	$load_reports = select_db("tbl_admin_reports", '*', "","(group_idr=".$groups["id"]." AND admin_type_arr LIKE '%".$admin_type_idr."%' ) ORDER BY display_name_str ASC",2);
	//echo $load_reports;
	while($reports = mysqli_fetch_array($load_reports))
	{
		$report_id = $reports["id"];
	  ?>
		<a href="index.php?report=<?php echo strtolower($report_id); ?>">
		<li>
		  <?=$reports["display_name_str"]?>
		</li>
		</a>
		<?php
	}
		?>
		  
	  </ul>
	</li>
		<?php
	}
?>
    	
    </div>
    
  </div>
  <div class="content-wrapper <?=!isset($_GET["id"])?"mtbl-cont":""?>">
    <div class="container-fluid pad-0">
    <?php include ("include/status.php");?>
    <?php 
	if(isset($_GET["max"])){
		echo compute_total($_GET["max"]);
	}
	function compute_total($max){
		$total = 0;
		for($x = 1; $x <=$max;$x++){
			$total = $total + $x;
		}
		return $total;
	}
	if(isset($_GET["table"]))
	{
		if(isset($_GET["table"])&&isset($_GET["new"]))
		{
			include ("include/table_form.php");
		}
		else if(isset($_GET["id"])&&isset($_GET["update"]))
		{
			include ("include/table_form.php");
		}
		else if(isset($_GET["id"])&&isset($_GET["view"]))
		{
			include ("include/table_view.php");
		}
		else
		{
			include ("include/table_table.php");
		}
	}
	else if(isset($_GET["help"])){
		include ("include/help.php");
	}
	else if(isset($_GET["excel"])){
		include ("include/excel.php");
	}
	else if(isset($_GET["report"])){
			include ("include/reports.php");
	}
	else if(isset($_GET["profile"])){
			include ("include/profile.php");
	}else{
		$group_arr = get_value_condition("group_arr","tbl_admin_type","(id = " . $admin["admin_type_idr"].")");
		$admin_groups = str_replace('-',',',$group_arr);  
		echo '<h2 class="title"><i class="fa fa-dashboard"></i> Dashboard</h2><div class="row jumbotron">';
		if(!isset($admin_groups) || $admin_groups == ""){
			$admin_groups = "0";
		}
		$load_tablesq = select_db("tbl_group", '*', "","id IN (".$admin_groups.") AND(dashboard_display_bol=1) ORDER BY display_name_str ASC",2);
		//echo $load_tablesq;
		while($groups = mysqli_fetch_array($load_tablesq))
		{
			$group_name = $groups["display_name_str"];
			if($group_name != "Settings")
			{
			$group_display_name = str_replace("tbl_","",$group_name);
			$group_display_name = ucwords($group_display_name);	
			$new_group_display_name = $group_display_name;
			 // returns "s"
			?>
            <div class="dashboard-containers">
                <div class="card text-center shadow">
                <div class="card-header gray-5" style="background:<?=$groups["dashboard_col"];?>"><i class="fa <?=$groups["fa_icon_str"]?>"></i> <?php echo $new_group_display_name; ?></div>
                <div class="w-100 gray-3 p-1 text-white">
                	<p><?=$groups["description_lng"]?></p>
                </div>
                <div class="card-body">
                
				<?php
          $load_tables = select_db("tbl_table", '*', "","(group_idr=".$groups["id"].")",2);
		while($tables = mysqli_fetch_array($load_tables))
		{
			$tablesq_name = $tables["display_name_str"];
			$display_name = str_replace("tbl_","",$tablesq_name);
			$display_name = ucwords($display_name);	
		  ?>
          	<a class="btn gray-2 text-white pull-left" href="?table=<?php echo strtolower($display_name); ?>"> <?=$tables["title_str"]?></a>
			<?php
		}
            ?>
                
                </div>
                 
                </div>
            </div>
        </li>
            <?php
			}
		}
		echo '</div>';
	}
	?>

    </div>
    <div class="footer">
    	<div class="copyright"><?=$details["copyright_str"];?></div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="logout.php">Logout</a>
          </div>
        </div>
      </div>
    </div>
    
    <div class="modal fade" id="idrModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
          <table id="data-idr-content" class="table table-striped">
          </table>
          </div>

        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--(JQUERY 3rd Party Online)-->
  
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap4.min.js"></script>
    <!-- Custom scripts for all pages-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src="js/jquery.qrcode.min.js"></script>
<script src="js/jSignature.js"></script>
<script src="js/plugins/jSignature.CompressorBase30.js"></script>
<script src="js/plugins/jSignature.CompressorSVG.js"></script>
<script src="js/plugins/jSignature.UndoButton.js"></script> 
<script src="js/plugins/signhere/jSignature.SignHere.js"></script> 
<script type="text/javascript" src="js/qrcodelib.js"></script>
<script type="text/javascript" src="js/webcodecamjquery.js"></script>
<script type="text/javascript" src="js/mainjquery.js"></script>
<script src="js/jquery.autocomplete.js"></script>
<script src="js/binaryajax.js"></script>
<script src="js/exif.js"></script>
<script src="js/jquery.canvasResize.js"></script>
<script src="js/canvasResize.js"></script>

<script src="summernote/dist/summernote-lite.js"></script>

<script type="text/javascript">
	$(document).ready(function(e) {
		$('body').addClass("ready");
		$('.sel-frm').change(function(e) {
            var hidtext = $(this).data("hidtext");
			$("#"+hidtext).val($(this).val());
			console.log("#"+hidtext);
        });
		$('.frm-update').click(function(e) {
			console.log("im here");
            var data_target = $(this).data("target");
			var data_vtb = $(this).data("vtb");
			var data_sel = $(this).data("select");
			var data_table = $(this).data("tbl");
			var data_sel_id = $("#"+data_sel).val();
			var dataString = "table="+data_table+"&id="+data_sel_id;
			console.log(dataString);
			if($(this).hasClass("active")){
				$("#"+data_vtb).show();
				$("#"+data_sel).removeAttr("disabled");
				$("#"+data_target).removeClass("active");
				$(this).removeClass("active");
				$(this).html("Update");
			}else{
				$("#"+data_sel).attr('disabled', 'disabled');
				$("#"+data_sel).val(data_sel_id);
				$("#"+data_vtb).hide();
				$("#"+data_target).addClass("active");
				$(this).addClass("active");
				$(this).html("Cancel");
			}
			/* Get from elements values */
			$.ajax({
			 type: "GET",
			 url:"ajax_form.php",
			 data: dataString,
			 crossDomain: true,
			 cache: false,
			 beforeSend: function(){
				 //alert(dataString);
				  $('body').removeClass('ready');
			 },
			 success: function(data1){
				 $('body').addClass('ready');
				 //alert("success");
				 if(data1!="failed"){
					$("#" + data_target).html(data1);
					console.log("success");
				 }
				 else{
					 console.log("error");
				 }
				}
			});
        });
		$('.frm-new').click(function(e) {
			var data_target = $(this).data("target");
			var data_vtb = $(this).data("vtb");
			var data_sel = $(this).data("select");
			var data_table = $(this).data("tbl");
			var data_sel_id = $("#"+data_sel).val();
			var dataString = "table="+data_table+"&new=1";
			console.log(dataString);
			if($(this).hasClass("active")){
				$("#"+data_vtb).show();
				$("#"+data_sel).removeAttr("disabled");
				$("#"+data_target).removeClass("active");
				$(this).removeClass("active");
				$(this).html("New");
			}else{
				$("#"+data_sel).val(0);
				$("#"+data_sel).attr('disabled', 'disabled');
				$("#"+data_vtb).hide();
				$("#"+data_target).addClass("active");
				$(this).addClass("active");
				$(this).html("Cancel");
			}
			$.ajax({
			 type: "GET",
			 url:"ajax_form.php",
			 data: dataString,
			 crossDomain: true,
			 cache: false,
			 beforeSend: function(){
				 //alert(dataString);
				  $('body').removeClass('ready');
			 },
			 success: function(data1){
				 $('body').addClass('ready');
				 //alert("success");
				 if(data1!="failed"){
					$("#" + data_target).html(data1);
					console.log("success");
				 }
				 else{
					 console.log("error");
				 }
				}
			});
            
			
        });
		window.history.pushState(null, "", window.location.href);        
        window.onpopstate = function() {
            window.history.pushState(null, "", window.location.href);
        };
		$(document).on('change','.imgInp',function(e){
			var file = e.target.files[0];
			var imgtarget = $(this).data("target");
			var datatxt = $(this).data("txt");
			canvasResize(file, {
			  width: 1500,
			  height: 0,
			  crop: false,
			  quality: 100,
			  //rotate: 90,
			  callback: function(data, width, height) {
				  console.log("#"+datatxt);
			  $("#"+imgtarget).attr('src', data);
			  $("#"+datatxt).val(data);
			  }
			});
		});

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
						console.log("option.php?q="+params.term+"&table="+data_table);
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
		
		$('.readonly *').prop('disabled', true);
		
		var arg = {
		resultFunction: function(result) {
			var qrcode = result.code;
			//$('.scanner-body ul').append($('<li>' + result.format + ': ' + result.code + '</li>'));
			var status_id = $('#status_idr').val();
			
			var dataString = "";
			var target = $('.qra').data("target");
			if(status_id!= ''){
				dataString ="table="+target+"&qr="+qrcode+"&status_id="+status_id;	
			}else{
				dataString ="table="+target+"&qr="+qrcode;	
			}
			console.log("im here"+status_id);
			
			var data_url = "ajax_qr.php?"+dataString;
			console.log(data_url);
			alert(data_url);
			//alert(data_url);
			/* Get from elements values */
			$.ajax({
			 type: "GET",
			 url:"ajax_qr.php",
			 data: dataString,
			 crossDomain: true,
			 cache: false,
			 beforeSend: function(){
				 //alert(dataString);
				  $('body').removeClass('ready');
			 },
			 success: function(data1){
				 $('body').addClass('ready');
				 //alert("success");
				 if(data1!="failed"){
					$("#" + target).html(data1);
				 }
				 else{
					 
					//alert("Error! Username already Taken");
				 }
				}
			});
		}
		};
		$(".btn-scan-qr").click(function(e) {
			console.log("working scanner");
			var decoder = $('canvas.qr-scanner').init(arg).buildSelectMenu('select', 1); 
			setTimeout(function(){ decoder.play(); }, 500); 
		});
		
		
		var sgn = $('.sgn');;
		if(sgn.val()!=null){
			var sgn_val = sgn.val();
			//$(".jSignature").attr("id","myCanvas");
			$(".jSignature").addClass("hidden");
			//console.log(sgn_val);
		}
		$('.sgn-clear').click(function(e) {
			$(".show_sign").attr("src","");
            $("#signatureparent").jSignature("clear");
        	$(".jSignature").removeClass("hidden");
			$('.sgn-save').removeClass("active");
			$('.sgn-save').removeAttr("disabled");
		});
		$(document).on('click','.sgn-save:not(.active)',function(){
			$(this).addClass("active");
			$(this).attr("disabled","disabled");
		
			$(".jSignature").attr("id","myCanvas");
			$(".jSignature").addClass("hidden");
			var canvas = document.getElementById('myCanvas');
            var data_url = canvas.toDataURL();
			var data_target = $(this).data("target");
			$("#"+data_target).val(data_url);
			$(".show_sign").attr("src",data_url);
			
			
			//alert(data_target);
			canvas.width = canvas.width;
			//alert(data_url);
        });
		var vta =  $('.vta');
		if(vta.val()!=""){
			var ajaxRequest;
		 var target = vta.data("target");
		 
		 var id= vta.val();
		 

		$("#" + target).html('');
		var dataString ="table="+target+"&id="+id;
		
		var data_url = "ajax.php?"+dataString;
		console.log(data_url);
		//alert(data_url);
		/* Get from elements values */
		$.ajax({
		 type: "GET",
		 url:"ajax.php",
		 data: dataString,
		 crossDomain: true,
		 cache: false,
		 beforeSend: function(){
			 //alert(dataString);
			  $('body').removeClass('ready');
		 },
		 success: function(data1){
			 $('body').addClass('ready');
			 //alert("success");
			 if(data1!="failed"){
				$("#" + target).html(data1);
			 }
			 else{
				 
				//alert("Error! Username already Taken");
			 }
			}
		});
		}
    });
	$(document).on('change','.vta',function(){
		 var ajaxRequest;
		 var target = $(this).data("target");
		 var id = $(this).val();

		$("#" + target).html('');
		var dataString ="table="+target+"&id="+id;
		
		var data_url = "ajax.php?"+dataString;
		console.log(data_url);
		//alert(data_url);
		/* Get from elements values */
		$.ajax({
		 type: "GET",
		 url:"ajax.php",
		 data: dataString,
		 crossDomain: true,
		 cache: false,
		 beforeSend: function(){
			 //alert(dataString);
			  $('body').removeClass('ready');
		 },
		 success: function(data1){
			 $('body').addClass('ready');
			 //alert("success");
			 if(data1!="failed"){
				$("#" + target).html(data1);
			 }
			 else{
				 
				//alert("Error! Username already Taken");
			 }
			}
		});
	
			console.log("vta clicked");
	});
		$(document).on('click','.data-idr',function(){
            var id = $(this).data("idr");
			var table = $(this).data("table");
			var target = "data-idr-content";
			var dataString ="table="+table+"_idr"+"&id="+id;
			var data_url = "ajax.php?"+dataString;
			console.log(data_url);
			/* Get from elements values */
			$.ajax({
			 type: "GET",
			 url:"ajax.php",
			 data: dataString,
			 crossDomain: true,
			 cache: false,
			 beforeSend: function(){
				 //alert(dataString);
				  $('body').removeClass('ready');
			 },
			 success: function(data1){
				 $('body').addClass('ready');
				 //alert("success");
				 if(data1!="failed"){
					$("#" + target).html(data1);
				 }
				 else{
					 
					//alert("Error! Username already Taken");
				 }
				}
			});
        });
		
        var vtb =  $('.vtb');
		if(vtb.val()!=""){
			var ajaxRequest;
		 var target = vtb.data("target");
		 var id = vtb.val();

		$("#" + target).html('');
		var dataString ="table="+target+"&id="+id;

		var data_url = "ajax.php?"+dataString;
		//alert(data_url);
		/* Get from elements values */
		$.ajax({
		 type: "GET",
		 url:"ajax.php",
		 data: dataString,
		 crossDomain: true,
		 cache: false,
		 beforeSend: function(){
			 //alert(dataString);
			  $('body').removeClass('ready');
		 },
		 success: function(data1){
			 $('body').addClass('ready');
			 //alert("success");
			 if(data1!="failed"){
				$("#" + target).html(data1);
			 }
			 else{
				 
				//alert("Error! Username already Taken");
			 }
			}
		});
		}
    
	$(document).on('change','.vtb',function(){
		 var ajaxRequest;
		 var target = $(this).data("target");
		 var id = $(this).val();

		$("#" + target).html('');
		var dataString ="table="+target+"&id="+id;
		
		var data_url = "ajax.php?"+dataString;
		//alert(data_url);
		/* Get from elements values */
		$.ajax({
		 type: "GET",
		 url:"ajax.php",
		 data: dataString,
		 crossDomain: true,
		 cache: false,
		 beforeSend: function(){
			 //alert(dataString);
			  $('body').removeClass('ready');
			  
		 },
		 success: function(data1){
			 $('body').addClass('ready');
			 //alert("success");
			 if(data1!="failed"){
				$("#" + target).html(data1);
			 }
			 else{
				 
				//alert("Error! Username already Taken");
			 }
			}
		});
	
			console.log("vtb clicked");
	});
	$("#signatureparent").jSignature();
	
	$('.crt_add').click(function(e) {
		
		var target = $(this).data("target");
		var target_input = $("#cart_value_" + target);
		var curent_val = target_input.val();
		var selected_val = $("#cs_" + target).val();
		var selected_eqv = $("#select2-cs_" + target+"-container").html(); 
		var selected_qty = $("#ci_q_" + target).val();
		
		var append_val = selected_val + "-" + selected_qty + ",";
		var new_val = curent_val + append_val;
		$("#ci_q_" + target).val(1);
		
		var generated_item = '<div class="cart_item"><div class="ci_name">'+selected_eqv+'</div><div class="ci_qty">'+selected_qty+'</div><div class="ci_delete btn btn-danger" data-delval="'+append_val+'" data-target="'+target+'"> <i class="fa fa-trash"></i></div></div>';
        
		$("#"+target).append(generated_item);
		target_input.val(new_val);
    });
	$(document).on('click','.ci_delete',function(){
		var target = $(this).data("target");
		var delval = $(this).data("delval");
		var target_input = $("#cart_value_" + target);
		var curent_val = target_input.val();
		var new_val = curent_val.replace(delval,'');
		$(this).parent( ".cart_item").remove();
		target_input.val(new_val);
		console.log("Delete");
	});
	$('.btn-toggler').click(function(e) {
		var sbnav = $('.sb-navs');
		var toggler = $(this);
		
		if(sbnav.hasClass("active")){
			sbnav.removeClass("active");
		}else{
        	sbnav.addClass("active");
		}
    });
	function makeid() {
  var text = "";
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  for (var i = 0; i < 15; i++)
    text += possible.charAt(Math.floor(Math.random() * possible.length));

  return text;
}
	$('.qrc-btn').click(function(e) {
		var target_qrc = $(this).data("target");
		var new_id = $('.qrc-text').val();
		$(target_qrc).qrcode(new_id);
		$('.qrc-text').val(new_id);
		$(this).hide();
    });
	$('.nav-item').click(function(e) {
		$('.nav-item').removeClass("active");
		$(this).addClass("active");
    });
	 $( document ).ready(function() {
		 
		 
		$('.dtable').DataTable( {dom: 'Bfrtip',buttons: [ 'print']} );
		// DATA TABLES PLUGIN For small amount of Data
		
		
		 $("#search_box").keyup(function () {
    var value = this.value.toLowerCase().trim();

    $("table tr").each(function (index) {
        if (!index) return;
        $(this).find("td").each(function () {
            var id = $(this).text().toLowerCase().trim();
            var not_found = (id.indexOf(value) == -1);
            $(this).closest('tr').toggle(!not_found);
            return not_found;
        });
    });
});
		 var dataimg = $('#scdr').val();
		 var datafield = $('#scdr').attr('data-field');
		 get_scdr(dataimg,datafield);
		 
		 $('#scdr').change(function(e) {
			var dataimg = $('#scdr').val();
			 var datafield = $('#scdr').attr('data-field');
			 get_scdr(dataimg,datafield);
        });
		 
		 function get_scdr(dataimg,datafield)
		 {
			dataimg = dataimg.split('-');
			var my_img = dataimg[1];
			$('#cdr').attr('src',"uploads/" + datafield + "/" + my_img);
		}

	});
    </script>
    <script>
$( document ).ready(function(e) {
	$('*').click(function() {
		//alert("im here");
	$('.topnav-second-level.collapse').removeClass("show");
	});
	
	setTimeout(function() {
	var img = document.getElementById("cdr");
  	var cnvs = document.getElementById("myCanvas");
	  cnvs.style.position = "absolute";
	  cnvs.style.left = img.offsetLeft + "px";
	  cnvs.style.top = img.offsetTop + "px";
	  cnvs.style.width = img.width + "px";
	  cnvs.style.height = img.height + "px";
	  img.style.width = cnvs.style.width + "px";
	  img.style.height = cnvs.style.height + 15 + "px";
         getloc();
    }, 2000);

$('#cdr').click(function(e) {
	
	
	
    var offset = $(this).offset();
	var offx = (e.pageX - offset.left) / $(this).width();
	var offy = (e.pageY - offset.top) / $(this).height();
    //alert(offx + ', ' + offy);
  
  	$('#x_coordinate').val(offx.toFixed(4));
	$('#y_coordinate').val(offy.toFixed(4));
	//alert('Location Changed!');
	Draw(offx,offy);
	
});

$('#myCanvas').click(function(e) {
	
    var offset = $(this).offset();
	var offx = (e.pageX - offset.left) / $(this).width();
	var offy = (e.pageY - offset.top) / $(this).height();
    //alert(offx + ', ' + offy);
  
  	$('#x_coordinate').val(offx.toFixed(4));
	$('#y_coordinate').val(offy.toFixed(4));
	//alert('Location Changed!');
	Draw(offx,offy);
	
});

});
function getloc(){
	
	var offx = $('#x_coordinate').val();
	var offy = $('#y_coordinate').val();
	//alert('Location Changed!');
	Draw(offx,offy);
	//alert("im here");
}
function Draw(x,y){
  var img = document.getElementById("cdr");
  var cnvs = document.getElementById("myCanvas");
 
  cnvs.style.position = "absolute";
  cnvs.style.left = img.offsetLeft + "px";
  cnvs.style.top = img.offsetTop + "px";
  cnvs.style.width = img.width + "px";
  cnvs.style.height = img.height + "px";
  img.style.width = cnvs.style.width + "px";
  img.style.height = cnvs.style.height + 15 + "px";
  
  
  var ctx = cnvs.getContext("2d");
  ctx.clearRect(0, 0, cnvs.width, cnvs.height);
  ctx.beginPath();
  
  
  ctx.arc(x*(img.width/(img.width/100)), y*(img.height/(img.height/150)), 1, 0, 2 * Math.PI, false);
  ctx.lineWidth = 1;
  ctx.strokeStyle = '#f00';
  ctx.stroke();
}

$( document ).ready(function() {
    $(".nicEdit-main").html($(".nice-txt").val());
});


</script>


  </div>
  </div>
</body>

</html>
