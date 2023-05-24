	<?php

	function get_gallery($field, $value,$type) {

		$my_val = $value;
		$my_field = $field;
		$my_string = "";
		$image_extensions = array("png","jpg","jpeg","gif");

		// Target directory
		$dir = "admin/uploads/".strtolower($my_field);
		//echo $dir;
		if(is_dir($dir)){

			if($dh = opendir($dir)){
				$count = 1;

				// Read files
				$ctr = 1;
				$y = 0;
				while (($file = readdir($dh)) !== false){

					if($file != '' && $file != '.' && $file != '..'){

						// Thumbnail image path

						$thumbnail_path = "admin/uploads/".strtolower($my_field)."/".$file;

						// Image path
						$image_path = "admin/uploads/".strtolower($my_field)."/".$file;
						// Location path
						$location_path = "admin/uploads/".strtolower($my_field)."/";

						$thumbnail_ext = pathinfo($thumbnail_path, PATHINFO_EXTENSION);
						$image_ext = pathinfo($image_path, PATHINFO_EXTENSION);

						// Check its not folder and it is image file
						if(!is_dir($image_path) && 
						in_array($thumbnail_ext,$image_extensions) && 
						in_array($image_ext,$image_extensions)){

							//echo $image_path . " | " . $my_val . "<br/>";
							
							
							if(strpos($image_path,$my_val)){
   
                                    for($x=1;$x<=2;$x++){
                                        
                                        if($x == 1){
                                            $exten = '.jpg';
                                        }elseif($x==2){
                                            $exten = '.png';
                                        }
                                        
                                        $image_path_wnum = $location_path.$my_val.$y.$exten; //In Order
                                        if(file_exists($image_path_wnum)){
                                            
                                            if($type == 1) {
            									$my_string .= '
            										<div role="tabpanel" class="tab-pane fade in '.($ctr == 1?"active"
            										 	:"").'" id="pro-'.$ctr.'">
            										    <a href="'. $image_path_wnum .'" data-lightbox="image-'.$ctr.'" data-title="Legarda Place Properties - '.$ctr.'">
            										        <img src="'. $image_path_wnum .'" alt="">
            										    </a>
            										</div>
            										';
            								}
            								elseif($type == 2) {
            								    
            									$my_string .= '
            										<div class="pro-details-item">
            								            <a href="#pro-'.$ctr.'" data-toggle="tab"><img src="'. $image_path_wnum .'" alt=""></a>
            								        </div>
            										';
            								}
                                        
                                        } else {
                                            continue;
                                        }
                                       
                                    }
                                    
                                    $y=$y+1;
                                    $ctr++;
                            }
							
							
							
							
							
							// Break
							$count++;
						}
					}
				}
				closedir($dh);
			}
		}
		return $my_string;
	}

	function get_gallery_amenities($field, $value) {

		$my_val = $value;
		$my_field = $field;
		$my_string = "";
		$image_extensions = array("png","jpg","jpeg","gif");

		// Target directory
		$dir = "admin/uploads/".strtolower($my_field);
		//echo $dir;
		if(is_dir($dir)){

			if($dh = opendir($dir)){
				//$count = 1;

				// Read files
				while (($file = readdir($dh)) !== false){

					if($file != '' && $file != '.' && $file != '..'){

						// Thumbnail image path

						$thumbnail_path = "admin/uploads/".strtolower($my_field)."/".$file;

						// Image path
						$image_path = "admin/uploads/".strtolower($my_field)."/".$file;

						$thumbnail_ext = pathinfo($thumbnail_path, PATHINFO_EXTENSION);
						$image_ext = pathinfo($image_path, PATHINFO_EXTENSION);

						// Check its not folder and it is image file
						if(!is_dir($image_path) && 
						in_array($thumbnail_ext,$image_extensions) && 
						in_array($image_ext,$image_extensions)){

							//echo $image_path . " | " . $my_val . "<br/>";
								
							if(strpos($image_path,$my_val)){

								$my_string .= '
									{
								        "src":"'. get_value_condition("base_url_str","tbl_detail","id=1") . $thumbnail_path .'",
			                            "thumb":"'. get_value_condition("base_url_str","tbl_detail","id=1") . $thumbnail_path .'",
			                            "mobileSrc":"'. get_value_condition("base_url_str","tbl_detail","id=1") . $thumbnail_path .'", 
		                        	},
								';
								
							}
							// Break
							//$count++;
						}
					}
				}
				closedir($dh);
			}
		}
		return $my_string;
	}


	function compressImage($type,$source, $destination, $quality) {
	$info = getimagesize($source);

	if ($type == 'image/jpeg') 
		$image = imagecreatefromjpeg($source);

	elseif ($type == 'image/gif') 
		$image = imagecreatefromgif($source);

	elseif ($type == 'image/png') 
		$image = imagecreatefrompng($source);

	imagejpeg($image, $destination, $quality);
	}
	
	
	//echo $admin_id;
	function imageResize($imageSrc,$imageWidth,$imageHeight) {
		$newImageWidth =500;
		$newImageHeight =500;
	
		$newImageLayer=imagecreatetruecolor($newImageWidth,$newImageHeight);
		imagecopyresampled($newImageLayer,$imageSrc,0,0,0,0,$newImageWidth,$newImageHeight,$imageWidth,$imageHeight);
	
		return $newImageLayer;
	}
	
	function save_base64_image($base64_image_string, $output_file_without_extension, $path_with_end_slash="" ) {
		//usage:  if( substr( $img_src, 0, 5 ) === "data:" ) {  $filename=save_base64_image($base64_image_string, $output_file_without_extentnion, getcwd() . "/application/assets/pins/$user_id/"); }      
		//
		//data is like:    data:image/png;base64,asdfasdfasdf
		$splited = explode(',', substr( $base64_image_string , 5 ) , 2);
		$mime=$splited[0];
		$data=$splited[1];
	
		$mime_split_without_base64=explode(';', $mime,2);
		$mime_split=explode('/', $mime_split_without_base64[0],2);
		if(count($mime_split)==2)
		{
			$extension=$mime_split[1];
			if($extension=='jpeg')$extension='jpg';
			//if($extension=='javascript')$extension='js';
			//if($extension=='text')$extension='txt';
			$output_file_with_extension=$output_file_without_extension.'.'.$extension;
		}
		file_put_contents( $path_with_end_slash . $output_file_with_extension, base64_decode($data) );
		return $output_file_with_extension;
	}
	
	function loggedin($variable)
	{
		if(!isset($_SESSION)){
			session_start();
		}
		
		$loggedin = FALSE;
		if (isset($_SESSION[$variable]))
		{
			$loggedin = TRUE;
			return $loggedin;	
		}
	}
	function logout($redirect_page)
	{
		session_start();
		$_SESSION["manager"] = "";
		session_destroy();
		setcookie("manager","",time()-7200);
		header ("Location: ".$redirect_page);
	}
	function get_value_condition($field,$table,$condition,$return = 1)
	{
		$my_value = "";
		include ("fn_connect.php");
		$sql_string_field = 'SELECT ' . $field . ' as my_field FROM '.$table .' WHERE ('.$condition.')';
		
		if(isset($return)){
			if($return == 2){
				echo $sql_string_field;
			}
			
		}
		//
		if(isset($_SESSION[0])){
			$admin_id = $_SESSION["admin_id"];
		$sql_string_field = str_replace("'\$admin_id'","'".$admin_id."'",$sql_string_field);
		
		$admin_branch_idr = $_SESSION["admin_branch_idr"];
		$sql_string_field = str_replace("'\$admin_branch_idr'","'".$admin_branch_idr."'",$sql_string_field);
		
		}
		//echo $sql_string_field;
		$field_query = mysqli_query($con,$sql_string_field);
		if($field_query)
		{
			if(mysqli_num_rows($field_query) > 0)
			{
				while($field_row = mysqli_fetch_array($field_query))
				{
					$my_value = $field_row['my_field'];
				}
				
			}else{
				$my_value = "";
			}
		}
		return $my_value;
	}
	function linkerize($link)
	{
		return strtolower(str_replace(" ","-",$link));
	}
	function unlinkerize($link)
	{
		return ucwords(str_replace("-"," ",$link));
	}
	function pluralize($word)
	{
		$pluralized = "";
		if(substr($word, -1) == "y")
		{
			$pluralized = substr_replace($word, "", -1) . "ies";
		}
		elseif(substr($word, -2) == "ch")
		{
			$pluralized = $word . "es";
		}
		elseif(substr($word, -1) <> "s")
		{
			$pluralized = $word . "s";
		}
				
		return $pluralized;
		
	}
	function count_con($table,$condition){
		include ("fn_connect.php");
		$count = 0;
		$sql_string = "SELECT count(*) AS count FROM ".$table." WHERE (".$condition.")";
		$tbl_query = mysqli_query($con,$sql_string);
		
		//echo $sql_string;
		while($row = mysqli_fetch_array($tbl_query))
		{
			$count = $row['count'];
		}
		return $count;
	}
	function count_rows($table){
		include ("fn_connect.php");
		$count = 0;
		$sql_string = "SELECT count(*) AS count FROM ".$table;
		$tbl_query = mysqli_query($con,$sql_string);
		//echo $sql_string;
		while($row = mysqli_fetch_array($tbl_query))
		{
			$count = $row['count'];
		}
		return $count;
	}
	function load_dashboard($return)
	{
		include ("fn_connect.php");
		$sql_string = "SELECT TABLE_NAME 
	FROM INFORMATION_SCHEMA.TABLES
	WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='".$database_name."' ";
		$tbl_query = mysqli_query($con,$sql_string);
		if($return==1)
		{
			return $sql_string;
		}
		elseif($return==2)
		{
			return $tbl_query;
		}
		else
		{
			return 0;
		}
		//echo $tbl_query;
	}
	function submit_form($table,$id)
	{
		
		$query = load_data($table, 0);
		$my_string_sql = "";
		$field_count = mysqli_num_rows($query);
		if($id!=0)
		{
			
			while($row 	= mysqli_fetch_array($query))
			{
				
				$my_field = $row['cn'];
				
				$my_comment = $row['cc'];
				$is_image = 0;
				if(isset($_POST[$my_field])||strpos($my_field,'_bol')||strpos($my_field,'_gal')&&($my_field!='froneri_approved_bol')){
					
					if($my_field=="id"){
						continue;
					}
					elseif(strpos($my_field,'_img')){
						if($_POST[$my_field]!=NULL){
							$my_val = $_POST[$my_field];
							$image_id = $_POST["display_name_str"];
							
							$img_field = strtolower(str_replace("_img","",$my_field));
							if (!file_exists("uploads/".strtolower($img_field))) {
							mkdir("uploads/".strtolower($img_field), 0777, true);
							}
							if (!file_exists("uploads/".strtolower($img_field)."/thumbs")) {
							mkdir("uploads/".strtolower($img_field)."/thumbs", 0777, true);
							}
							$cur_file = save_base64_image($my_val,$image_id,"uploads/".strtolower($img_field)."/");
							$my_string_sql .= $my_field . " = '" . $cur_file. "'";
							if($field_count !=1){
								$my_string_sql .= ',';
							}
							//echo 'success';
						}
						else
						{
							//echo 'failed';
							continue;
						}
						$field_count = $field_count - 1;
						
					}
					elseif(strpos($my_field,'_gal'))
					{
						
						$is_image = 1;
						if($_FILES[$my_field]['name']!=NULL)
						{
							// Getting file name
							$image_id = $_POST["display_name_str"];
							//echo $image_id;
							$img_field = strtolower(str_replace("_gal","",$my_field));

							if (!file_exists("uploads/".strtolower($img_field))) {
							mkdir("uploads/".strtolower($img_field), 0777, true);
							}
							if (!file_exists("uploads/".strtolower($img_field)."/thumbs")) {
							mkdir("uploads/".strtolower($img_field)."/thumbs", 0777, true);
							}
							$imagecount =  count($_FILES[$my_field]['name']);
							//echo $imagecount;
							for ($x = 0; $x < $imagecount; $x++) {
								$image_name = $_FILES[$my_field]['name'][$x];
								$image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
								$filename = $image_id.$x.".".$image_ext;

								// Valid extension
								$valid_ext = array('png','jpeg','jpg');

								// Location
								$location = "uploads/".strtolower($img_field)."/".$filename;
								//echo $location."<br>";
								$thumbnail_location = "uploads/".strtolower($img_field)."/thumbs/".$filename;

								// file extension
								$file_extension = pathinfo($location, PATHINFO_EXTENSION);
								$file_extension = strtolower($file_extension);

								// Check extension
								if(in_array($file_extension,$valid_ext)){  

									// Upload file
									if(move_uploaded_file($_FILES[$my_field]['tmp_name'][$x],$location)){

										// Compress Image
										//echo 'im here';
										compressImage($_FILES[$my_field]['type'][$x],$location,$thumbnail_location,60);

										//echo "Successfully Uploaded";
									}

								}
								$my_string_sql .= $my_field . " = '" . $image_id . "'";
								if($field_count !=1)
								{
									$my_string_sql .= ',';
								}

							}
						}
						else
						{
							continue;
						}
						$field_count = $field_count - 1;

					}
					elseif(strpos($my_field,'_pdf'))
					{
					$is_image = 1;
					if($_FILES[$my_field]['name']!=NULL)
					{
						$img_field = strtolower(str_replace("_pdf","",$my_field));
						if (!file_exists("uploads/".strtolower($img_field))) {
						mkdir("uploads/".strtolower($img_field), 0777, true);
						}
						if (!file_exists("uploads/".strtolower($img_field)."/thumbs")) {
						mkdir("uploads/".strtolower($img_field)."/thumbs", 0777, true);
						}
						$image_id = $_POST["display_name_str"];
						$field_text = $_FILES[$my_field]['name'];
						//echo '<input type="text" value="'.$field_text.'" />';
						//echo $_FILES[$my_field]['name'];
						$image_name = $_FILES[$my_field]['name'];
						$image_size = $_FILES[$my_field]['size'];
						$image_temp = $_FILES[$my_field]['tmp_name'];
						$allowed_ext = array ('pdf');
						$image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
						$imageid = $image_id;
						$image_file = $imageid.'.'.$image_ext;
						
						//echo "uploads/".strtolower($img_field)."/";
						move_uploaded_file($image_temp,"uploads/".strtolower($img_field)."/".$image_file);
						
						$my_string_sql .= $my_field . " = '" . $image_file . "'";
						if($field_count !=1)
						{
							$my_string_sql .= ',';
						}
					}
					else
					{
						continue;
					}
					$field_count = $field_count - 1;
					
				}
					elseif(strpos($my_field,'_sgn'))
					{
						if($_POST[$my_field]!=NULL&&(strpos($_POST[$my_field],"base64")))
						{
							$my_val = $_POST[$my_field];
							$image_id = $_POST["display_name_str"];
							
							$img_field = strtolower(str_replace("_sgn","",$my_field));
							if (!file_exists("uploads/".strtolower($img_field))) {
							mkdir("uploads/".strtolower($img_field), 0777, true);
							}
							if (!file_exists("uploads/".strtolower($img_field)."/thumbs")) {
							mkdir("uploads/".strtolower($img_field)."/thumbs", 0777, true);
							}
							$cur_file = save_base64_image($my_val,$image_id,"uploads/".strtolower($img_field)."/");
							
							$my_string_sql .= $my_field . " = '" . $cur_file. "'";
							if($field_count !=1)
							{
								$my_string_sql .= ',';
							}
						}
						else
						{
							continue;
						}
						$field_count = $field_count - 1;
						
					}
					elseif(strpos($my_field,'_log'))
					{
						$is_image = 1;
						if($_FILES[$my_field]['name']!=NULL)
						{
							$img_field = strtolower(str_replace("_log","",$my_field));
							if (!file_exists("uploads/logo/".strtolower($img_field))) {
							mkdir("uploads/logo/".strtolower($img_field), 0777, true);
							}
							if (!file_exists("uploads/logo/".strtolower($img_field)."/thumbs")) {
							mkdir("uploads/logo/".strtolower($img_field)."/thumbs", 0777, true);
							}
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
							
							//echo "uploads/logo/".$img_field."/";
							move_uploaded_file($image_temp,"uploads/logo/".strtolower($img_field)."/".$image_file);
							create_thumb("uploads/logo/".strtolower($img_field)."/", $image_file, "uploads/logo/".strtolower($img_field)."/thumbs/");
							$my_string_sql .= $my_field . " = '" . $image_file . "'";
							if($field_count !=1)
							{
								$my_string_sql .= ',';
							}
						}
						else
						{
							continue;
						}
						$field_count = $field_count - 1;
						
					}
					elseif(strpos($my_field,'_cdr'))
					{
						$my_id = addslashes(strip_tags($_POST[$my_field]));
						$x = addslashes(strip_tags($_POST[$my_field.'_x']));
						$y = addslashes(strip_tags($_POST[$my_field.'_y']));
						$my_value = $my_id . ',' . $x . ',' . $y;
						$my_string_sql .= $my_field . " = '".$my_value."'";	
						if($field_count !=1)
						{
							$my_string_sql .= ',';
						}	
					}
					elseif(strpos($my_field,'_arr')||strpos($my_field,'_vta')||strpos($my_field,'_vsa'))
					{
							$my_value = "";
							$my_post = $_POST[$my_field];
							$count = count($my_post);
							$result_array = '';
							foreach ($my_post as $post){
								$result_array .= $post . '-';
							}
							
							$result_array = substr($result_array, 0, -1);
							$my_value .= $result_array;
							
							$my_string_sql .= $my_field . " = '".$my_value."'";	
							if($field_count !=1)
							{
								$my_string_sql .= ',';
							}	
					}
					elseif(strpos($my_field,'_bol'))
					{
						$my_value = 0;
						if(isset($_POST[$my_field]))
						{
							$my_value = 1;
						}
						$my_string_sql .= $my_field . " = '".$my_value."'";	
						if($field_count !=1)
						{
							$my_string_sql .= ',';
						}	
					}
					elseif(strpos($my_field,'_frm'))
					{
						if(isset($_POST[$my_field])){
							$my_value = addslashes(strip_tags($_POST[$my_field]));
						}else{
							$my_value = 0;
						}
						//echo $my_value;
						$frm_table = "tbl_" . str_replace('_frm','',$my_field);
						if(isset($_POST["display_name_str"])){
							$my_value = submit_subform($frm_table,$my_value);
						}
						
						$my_string_sql .= $my_field . " = '".$my_value."'";	
						if($field_count !=1)
						{
							$my_string_sql .= ',';
						}
						//echo 'my_value :' .$my_value;	
					}
					elseif(strpos($my_field,'_rch'))
					{
						$my_value = 0;
						if(isset($_POST[$my_field]))
						{
							$my_value = str_replace("'","’",$_POST[$my_field]);
						}
						$my_string_sql .= $my_field . " = '".$my_value."'";	
						if($field_count !=1)
						{
							$my_string_sql .= ',';
						}	
					}
					elseif(strpos($my_field,'_crt'))
					{
						$my_value = 0;
						if(isset($_POST["cart_value_".$my_field]))
						{
							$my_value = $_POST["cart_value_".$my_field];
						}
						$my_string_sql .= $my_field . " = '".$my_value."'";	
						if($field_count !=1)
						{
							$my_string_sql .= ',';
						}	
					}
					elseif(strpos($my_field,'_gal'))
					{
						$my_value = 0;
						if(isset($_POST[$my_field]))
						{
							$my_value = str_replace("'","’",$_POST[$my_field]);
						}
						$my_string_sql .= $my_field . " = '".$my_value."'";	
						if($field_count !=1)
						{
							$my_string_sql .= ',';
						}	
					}
					else
					{
						$is_image = 0;
						$my_string_sql .= $my_field . " = '" . addslashes(strip_tags($_POST[$my_field])) . "'";		
						if($field_count !=0)
						{
							$my_string_sql .= ',';
						}
						
					}
					$field_count = $field_count - 1;		
				}
			}
			
				$qry = update_db($table,$my_string_sql,"id = ".$id,1);
			
			
			
			$cur_user = $_SESSION["manager"];
			$cur_user_id = get_value_condition("id","tbl_admin","username_str='$cur_user'");
			date_default_timezone_set('Asia/Manila');
			$date_time = date("Y-m-d h:i:sa");
			
			$table_title = get_value_condition("title_str","tbl_table","display_name_str = '$table'");
			$log_qry = insert_db("tbl_admin_logs","admin_idr,activity_lng,date_dtm","'$cur_user_id','<b>". $cur_user . "</b> Updated <b>" . $table_title. "</b> (".addslashes($my_string_sql).")','$date_time'",2);
			//echo $log_qry;
			//echo $qry;
			$cur_table = str_replace("tbl_","",$table);
			redirect('index.php?table='.$cur_table."&status=updated");
		}
		else
		{
			$fields = "";
			$values = "";
			$notif_value = "";
			while($row 	= mysqli_fetch_array($query))
			{
				$my_field = $row['cn'];
				if($my_field != "id")
				{
					$field_count = $field_count - 1;
					if($my_field == 'display_name_str')
					{
						$fields .= $my_field;
						$values .= "'" . addslashes(strip_tags($_POST[$my_field])) . "'";
						$notif_value = addslashes(strip_tags($_POST[$my_field]));
					}
					elseif(strpos($my_field,'_gal'))
					{
						echo 'im here';
					$is_image = 1;
						// Getting file name
						$image_id = $_POST["display_name_str"];
						//echo $image_id;
						$img_field = strtolower(str_replace("_gal","",$my_field));

						if (!file_exists("uploads/".strtolower($img_field))) {
						mkdir("uploads/".strtolower($img_field), 0777, true);
						}
						if (!file_exists("uploads/".strtolower($img_field)."/thumbs")) {
						mkdir("uploads/".strtolower($img_field)."/thumbs", 0777, true);
						}
						$imagecount =  count($_FILES[$my_field]['name']);
						//echo $imagecount;

						echo 'im here 1';
						for ($x = 0; $x < $imagecount; $x++) {
							$image_name = $_FILES[$my_field]['name'][$x];
							$image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
							$filename = $image_id.$x.".".$image_ext;



							// Valid extension
							$valid_ext = array('png','jpeg','jpg');

							// Location
							$location = "uploads/".strtolower($img_field)."/".$filename;
							//echo $location."<br>";
							$thumbnail_location = "uploads/".strtolower($img_field)."/thumbs/".$filename;

							// file extension
							$file_extension = pathinfo($location, PATHINFO_EXTENSION);
							$file_extension = strtolower($file_extension);

							// Check extension
							if(in_array($file_extension,$valid_ext)){  

								// Upload file
								if(move_uploaded_file($_FILES[$my_field]['tmp_name'][$x],$location)){

									// Compress Image
									compressImage($_FILES[$my_field]['type'][$x],$location,$thumbnail_location,60);
									//echo 'compressed. im here x'. $x;
									//echo "Successfully Uploaded";
								}

							}


						}
							$fields .= $my_field;
							$values .= "'" . $image_id. "'";


				}
					elseif(strpos($my_field,'_img'))
					{
						$my_val = $_POST[$my_field];
						$image_id = $_POST["display_name_str"];
						
						$img_field = strtolower(str_replace("_img","",$my_field));
						if (!file_exists("uploads/".strtolower($img_field))) {
						mkdir("uploads/".strtolower($img_field), 0777, true);
						}
						if (!file_exists("uploads/".strtolower($img_field)."/thumbs")) {
						mkdir("uploads/".strtolower($img_field)."/thumbs", 0777, true);
						}
						$cur_file = save_base64_image($my_val,$image_id,"uploads/".strtolower($img_field)."/");
					
						$fields .= $my_field;
						$values .= "'" . $cur_file . "'";
					}
					elseif(strpos($my_field,'_sgn'))
					{
							$my_val = $_POST[$my_field];
							$image_id = $_POST["display_name_str"];
							
							$img_field = strtolower(str_replace("_sgn","",$my_field));
							if (!file_exists("uploads/".strtolower($img_field))) {
							mkdir("uploads/".strtolower($img_field), 0777, true);
							}
							if (!file_exists("uploads/".strtolower($img_field)."/thumbs")) {
							mkdir("uploads/".strtolower($img_field)."/thumbs", 0777, true);
							}
							$cur_file = save_base64_image($my_val,$image_id,"uploads/".strtolower($img_field)."/");
						
							$fields .= $my_field;
							$values .= "'" . $cur_file . "'";
						
					}
					elseif(strpos($my_field,'_log'))
					{
						$img_field = strtolower(str_replace("_log","",$my_field));
						if (!file_exists("uploads/logo/".$img_field)) {
						mkdir("uploads/logo/".$img_field, 0777, true);
						}
						if (!file_exists("uploads/logo/".$img_field."/thumbs")) {
						mkdir("uploads/logo/".$img_field."/thumbs", 0777, true);
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
							
							//echo "uploads/logo/".$img_field."/";
							move_uploaded_file($image_temp,"uploads/logo/".$img_field."/".$image_file);
							create_thumb("uploads/logo/".$img_field."/", $image_file, "uploads/logo/".$img_field."/thumbs/");
							$fields .= $my_field;
							$values .= "'" . $image_file . "'";
						}
						else
						{
							$fields .= $my_field;
							$values .= "'" . addslashes(strip_tags($_POST[$my_field])) . "'";
						}
					}
					elseif(strpos($my_field,'_bol'))
				{
					$my_value = 0;
					if(isset($_POST[$my_field]))
					{
						$my_value = 1;
					}
					$fields .= $my_field;
					$values .= "'" . $my_value . "'";
				}
					elseif(strpos($my_field,'_arr')||strpos($my_field,'_vta')||strpos($my_field,'_vsa'))
					{
						$my_post = $_POST[$my_field];
						$count = count($my_post);
						$result_array = '';
						foreach ($my_post as $post){
							$result_array .= $post . '-';
						}
						
						$fields .= $my_field;
						$result_array = substr($result_array, 0, -1);
						$values .= "'" . $result_array . "'";
					}
					elseif(strpos($my_field,'_frm'))
					{
						if(isset($_POST[$my_field])){
							$my_value = addslashes(strip_tags($_POST[$my_field]));
						}else{
							$my_value = 0;
						}
						$frm_table = "tbl_" . str_replace('_frm','',$my_field);
						$my_value = submit_subform($frm_table,$my_value);
						$fields .= $my_field;
						$values .= "'" . $my_value . "'";
					}
					elseif(strpos($my_field,'_rch'))
					{
						$my_value = 0;
						
						if(isset($_POST[$my_field]))
						{
							$my_value = $_POST[$my_field];
						}
						$fields .= $my_field;
						$values .= "'" . $my_value . "'";
					}
					elseif(strpos($my_field,'_gal'))
					{
						$my_value = 0;
						if(isset($_POST[$my_field]))
						{
							$my_value = $_POST[$my_field];
						}
						$fields .= $my_field;
						$values .= "'" . $my_value . "'";
					}
					elseif(strpos($my_field,'_cdr'))
					{
						$my_id = addslashes(strip_tags($_POST[$my_field]));
						$x = addslashes(strip_tags($_POST[$my_field.'_x']));
						$y = addslashes(strip_tags($_POST[$my_field.'_y']));
						$my_value = $my_id . ',' . $x . ',' . $y;
						$fields .= $my_field;
						$values .= "'" . $my_value . "'";
					}
					elseif(strpos($my_field,'_crt'))
					{
						$my_value = 0;
						if(isset($_POST["cart_value_".$my_field]))
						{
							$my_value = $_POST["cart_value_".$my_field];
						}
						$fields .= $my_field;
						$values .= "'" . $my_value . "'";
					}
					
					else
					{
						$fields .= $my_field;
						$values .= "'" . addslashes(strip_tags($_POST[$my_field])) . "'";
					}
					
					if($field_count !=0)
					{
						$fields .= ',';
						$values .= ',';
					}
				}
				else
				{
					$field_count = $field_count - 1;
				}
			}
			$result = insert_db($table,$fields,$values,2);
			$cur_table = str_replace("tbl_","",$table);
			
			$cur_user = $_SESSION["manager"];
			$cur_user_id = get_value_condition("id","tbl_admin","username_str='$cur_user'");
			date_default_timezone_set('Asia/Manila');
			$date_time = date("Y-m-d h:i:sa");
			$table_title = get_value_condition("title_str","tbl_table","display_name_str = '$table'");
			$table_id = get_value_condition("id","tbl_table","display_name_str = '$table'");
			$log_qry = insert_db("tbl_admin_logs","admin_idr,activity_lng,date_dtm","'$cur_user_id','<b>". $cur_user . "</b> Inserted Data to <b>" . $table_title. "</b> (".addslashes($values).")','$date_time'",1);
			//echo $result;
			//echo 'im here';
			
			$users_query = select_db("tbl_admin","*","","1=1",2);
			while($row_users = mysqli_fetch_array( $users_query )){
				$insert_notif = 0;
				$insert_notif = get_value_condition("insert_notifications_bol","tbl_admin_tables","admin_type_idr=".$row_users["admin_type_idr"]. " AND table_idr = ".$table_id);
				
				if($insert_notif == 1){
					$notify_title = "New " . $cur_table;
					$notify_admin_idr = $row_users["id"];
					$notify_table_idr = $table_id;
					$notify_str = "Inserted " . $notif_value. " to ". $table_title;
					$date_dat = date("Y-m-d");
					$notif_qry = insert_db("tbl_admin_notifications","display_name_str,admin_idr,table_idr,notification_str,date_dat","'".$notify_title."',".$notify_admin_idr.",".$notify_table_idr.",'".$notify_str."','".$date_dat."'",1);
				
					//echo $notif_qry;
					//echo '('.$row_users["username_str"]. "-" . $insert_notif . ")";
				}
			}
			
			
			redirect('index.php?table='.$cur_table."&status=added");
			
		}
		
		//echo $my_string_sql;
	}
	function submit_subform($table,$id)
	{
		
		include ("fn_connect.php");
		$query = load_data($table, 0);
		$my_string_sql = "";
		
		$tbl = str_replace('tbl_','',$table);
		$field_count = mysqli_num_rows($query);
		if($id!=0)
		{
			
			//echo "subform id:" .  $id;
			while($row 	= mysqli_fetch_array($query))
			{
				$my_field = $row['cn'];
				$is_image = 0;
				
				if($my_field =='id'){
					continue;
				}
				if(strpos($my_field,'_img')){
						if($_POST[$my_field]!=NULL){
							$my_val = $_POST[$my_field];
							$image_id = $_POST["display_name_str"];
							
							$img_field = strtolower(str_replace("_img","",$my_field));
							if (!file_exists("uploads/".strtolower($img_field))) {
							mkdir("uploads/".strtolower($img_field), 0777, true);
							}
							if (!file_exists("uploads/".strtolower($img_field)."/thumbs")) {
							mkdir("uploads/".strtolower($img_field)."/thumbs", 0777, true);
							}
							$cur_file = save_base64_image($my_val,$image_id,"uploads/".strtolower($img_field)."/");
							$my_string_sql .= $my_field . " = '" . $cur_file. "'";
							if($field_count !=1){
								$my_string_sql .= ',';
							}
						}
						else
						{
							continue;
						}
						$field_count = $field_count - 1;
						
					}
				elseif(strpos($my_field,'_pdf'))
				{
				$is_image = 1;
				if($_FILES[$my_field]['name']!=NULL)
				{
					$img_field = strtolower(str_replace("_pdf","",$my_field));
					if (!file_exists("uploads/".strtolower($img_field))) {
					mkdir("uploads/".strtolower($img_field), 0777, true);
					}
					if (!file_exists("uploads/".strtolower($img_field)."/thumbs")) {
					mkdir("uploads/".strtolower($img_field)."/thumbs", 0777, true);
					}
					$image_id = $_POST["display_name_str"];
					$field_text = $_FILES[$my_field]['name'];
					//echo '<input type="text" value="'.$field_text.'" />';
					//echo $_FILES[$my_field]['name'];
					$image_name = $_FILES[$my_field]['name'];
					$image_size = $_FILES[$my_field]['size'];
					$image_temp = $_FILES[$my_field]['tmp_name'];
					$allowed_ext = array ('pdf');
					$image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
					$imageid = $image_id;
					$image_file = $imageid.'.'.$image_ext;
					
					//echo "uploads/".strtolower($img_field)."/";
					move_uploaded_file($image_temp,"uploads/".strtolower($img_field)."/".$image_file);
					
					$my_string_sql .= $my_field . " = '" . $image_file . "'";
					if($field_count !=1)
					{
						$my_string_sql .= ',';
					}
				}
				else
				{
					continue;
				}
				$field_count = $field_count - 1;
				
			}
				elseif(strpos($my_field,'_sgn'))
				{
					$is_image = 1;
					if($_POST[$my_field]!=NULL)
					{
						$my_val = $_POST[$my_field];
						$image_id = $_POST["display_name_str"];
						
						$img_field = strtolower(str_replace("_sgn","",$my_field));
						if (!file_exists("uploads/".strtolower($img_field))) {
						mkdir("uploads/".strtolower($img_field), 0777, true);
						}
						if (!file_exists("uploads/".strtolower($img_field)."/thumbs")) {
						mkdir("uploads/".strtolower($img_field)."/thumbs", 0777, true);
						}
						$cur_file = save_base64_image($my_val,$image_id,"uploads/".strtolower($img_field)."/");
						
						$my_string_sql .= $my_field . " = '" . $cur_file. "'";
						if($field_count !=1)
						{
							$my_string_sql .= ',';
						}
					}
					else
					{
						continue;
					}
					$field_count = $field_count - 1;
					
				}	
				elseif($my_field == 'display_name_str')
				{
					$my_value = 0;
					if(isset($_POST[$my_field . "_" .$tbl]))
					{
						$my_value = $_POST[$my_field . "_" .$tbl] ;
					}
					$my_string_sql .= $my_field . " = '".$my_value."'";	
					if($field_count !=1)
					{
						$my_string_sql .= ',';
					}	
				}
				elseif(strpos($my_field,'_log'))
				{
					$is_image = 1;
					if($_FILES[$my_field]['name']!=NULL)
					{
						$img_field = strtolower(str_replace("_log","",$my_field));
						if (!file_exists("uploads/logo/".strtolower($img_field))) {
						mkdir("uploads/logo/".strtolower($img_field), 0777, true);
						}
						if (!file_exists("uploads/logo/".strtolower($img_field)."/thumbs")) {
						mkdir("uploads/logo/".strtolower($img_field)."/thumbs", 0777, true);
						}
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
						
						//echo "uploads/logo/".$img_field."/";
						move_uploaded_file($image_temp,"uploads/logo/".strtolower($img_field)."/".$image_file);
						create_thumb("uploads/logo/".strtolower($img_field)."/", $image_file, "uploads/logo/".strtolower($img_field)."/thumbs/");
						$my_string_sql .= $my_field . " = '" . $image_file . "'";
						if($field_count !=1)
						{
							$my_string_sql .= ',';
						}
					}
					else
					{
						continue;
					}
					$field_count = $field_count - 1;
					
				}
				elseif(strpos($my_field,'_cdr'))
				{
					$my_id = addslashes(strip_tags($_POST[$my_field]));
					$x = addslashes(strip_tags($_POST[$my_field.'_x']));
					$y = addslashes(strip_tags($_POST[$my_field.'_y']));
					$my_value = $my_id . ',' . $x . ',' . $y;
					$my_string_sql .= $my_field . " = '".$my_value."'";	
					if($field_count !=1)
					{
						$my_string_sql .= ',';
					}	
				}
				elseif(strpos($my_field,'_arr'))
				{
						$my_value = "";
						$my_post = $_POST[$my_field];
						$count = count($my_post);
						$result_array = '';
						foreach ($my_post as $post){
							$result_array .= $post . '-';
						}
						
						$result_array = substr($result_array, 0, -1);
						$my_value .= $result_array;
						
						$my_string_sql .= $my_field . " = '".$my_value."'";	
						if($field_count !=1)
						{
							$my_string_sql .= ',';
						}	
				}
				elseif(strpos($my_field,'_bol'))
				{
					$my_value = 0;
					if(isset($_POST[$my_field]))
					{
						$my_value = 1;
					}
					$my_string_sql .= $my_field . " = '".$my_value."'";	
					if($field_count !=1)
					{
						$my_string_sql .= ',';
					}	
				}
				elseif(strpos($my_field,'_frm'))
				{
					$my_value = 0;
					if(isset($_POST[$my_field]))
					{
						$my_value = $_POST[$my_field];
					}
					$my_string_sql .= $my_field . " = '".$my_value."'";	
					if($field_count !=1)
					{
						$my_string_sql .= ',';
					}	
				}
				elseif(strpos($my_field,'_rch'))
				{
					$my_value = 0;
					if(isset($_POST[$my_field]))
					{
						$my_value = str_replace("'","’",$_POST[$my_field]);
					}
					$my_string_sql .= $my_field . " = '".$my_value."'";	
					if($field_count !=1)
					{
						$my_string_sql .= ',';
					}	
				}
				elseif(strpos($my_field,'_gal'))
				{
					$my_value = 0;
					if(isset($_POST[$my_field]))
					{
						$my_value = str_replace("'","’",$_POST[$my_field]);
					}
					$my_string_sql .= $my_field . " = '".$my_value."'";	
					if($field_count !=1)
					{
						$my_string_sql .= ',';
					}	
				}
	
				else
				{
					$is_image = 0;
					$my_string_sql .= $my_field . " = '" . addslashes(strip_tags($_POST[$my_field])) . "'";		
					if($field_count !=0)
					{
						$my_string_sql .= ',';
					}
					
				}
				$field_count = $field_count - 1;
				
				
			}
			if($_POST["display_name_str_".$table]=="" && !isset($_POST["subform_mark_mrk"])){
				//echo "TRUE". $_POST["display_name_str_".$table];
				$qry = update_db($table,$my_string_sql,"id = 0",2);
			}else{
				//echo "FALSE";
				//echo $my_string_sql;
				$qry = update_db($table,$my_string_sql,"id = ".$id,2);
			}
				
			$cur_user = $_SESSION["manager"];
			$cur_user_id = get_value_condition("id","tbl_admin","username_str='$cur_user'");
			date_default_timezone_set('Asia/Manila');
			$date_time = date("Y-m-d h:i:sa");
			
			$table_title = get_value_condition("title_str","tbl_table","display_name_str = '$table'");
			$log_qry = insert_db("tbl_admin_logs","admin_idr,activity_lng,date_dtm","'$cur_user_id','<b>". $cur_user . "</b> Updated <b>" . $table_title. "</b> (".addslashes($my_string_sql).")','$date_time'",1);
			//echo $log_qry;
			//echo " subquery: " . $qry;
			$cur_table = str_replace("tbl_","",$table);
			
			return $id;	
		}
		else
		{
			$fields = "";
			$values = "";
			while($row 	= mysqli_fetch_array($query))
			{
				$my_field = $row['cn'];
				if($my_field != "id")
				{
					$field_count = $field_count - 1;
					
					if(strpos($my_field,'_img'))
					{
						$my_val = $_POST[$my_field];
						$image_id = $_POST["display_name_str"];
						
						$img_field = strtolower(str_replace("_img","",$my_field));
						if (!file_exists("uploads/".strtolower($img_field))) {
						mkdir("uploads/".strtolower($img_field), 0777, true);
						}
						if (!file_exists("uploads/".strtolower($img_field)."/thumbs")) {
						mkdir("uploads/".strtolower($img_field)."/thumbs", 0777, true);
						}
						$cur_file = save_base64_image($my_val,$image_id,"uploads/".strtolower($img_field)."/");
					
						$fields .= $my_field;
						$values .= "'" . $cur_file . "'";
					}
					elseif(strpos($my_field,'_sgn'))
					{
							$my_val = $_POST[$my_field];
							$image_id = $_POST["display_name_str"];
							
							$img_field = strtolower(str_replace("_sgn","",$my_field));
							if (!file_exists("uploads/".strtolower($img_field))) {
							mkdir("uploads/".strtolower($img_field), 0777, true);
							}
							if (!file_exists("uploads/".strtolower($img_field)."/thumbs")) {
							mkdir("uploads/".strtolower($img_field)."/thumbs", 0777, true);
							}
							$cur_file = save_base64_image($my_val,$image_id,"uploads/".strtolower($img_field)."/");
						
							$fields .= $my_field;
							$values .= "'" . $cur_file . "'";
						
						
					}
					elseif($my_field == 'display_name_str')
					{
						$my_value = 0;
						if(isset($_POST[$my_field . "_" .$tbl]))
						{
							$my_value = $_POST[$my_field . "_" .$tbl] ;
						}
						$fields .= $my_field;
						$values .= "'" . $my_value . "'";
					}
					elseif(strpos($my_field,'_log'))
					{
						$img_field = strtolower(str_replace("_log","",$my_field));
						if (!file_exists("uploads/logo/".$img_field)) {
						mkdir("uploads/logo/".$img_field, 0777, true);
						}
						if (!file_exists("uploads/logo/".$img_field."/thumbs")) {
						mkdir("uploads/logo/".$img_field."/thumbs", 0777, true);
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
							
							//echo "uploads/logo/".$img_field."/";
							move_uploaded_file($image_temp,"uploads/logo/".$img_field."/".$image_file);
							create_thumb("uploads/logo/".$img_field."/", $image_file, "uploads/logo/".$img_field."/thumbs/");
							$fields .= $my_field;
							$values .= "'" . $image_file . "'";
						}
						else
						{
							$fields .= $my_field;
							$values .= "'" . addslashes(strip_tags($_POST[$my_field])) . "'";
						}
					}
					elseif(strpos($my_field,'_bol'))
				{
					$my_value = 0;
					if(isset($_POST[$my_field]))
					{
						$my_value = 1;
					}
					$fields .= $my_field;
					$values .= "'" . $my_value . "'";
				}
					elseif(strpos($my_field,'_arr'))
					{
						$my_post = $_POST[$my_field];
						$count = count($my_post);
						$result_array = '';
						foreach ($my_post as $post){
							$result_array .= $post . '-';
						}
						
						$fields .= $my_field;
						$result_array = substr($result_array, 0, -1);
						$values .= "'" . $result_array . "'";
					}
					elseif(strpos($my_field,'_rch'))
					{
						$my_value = 0;
						
						if(isset($_POST[$my_field]))
						{
							$my_value = $_POST[$my_field];
						}
						$fields .= $my_field;
						$values .= "'" . $my_value . "'";
					}
					elseif(strpos($my_field,'_gal'))
					{
						$my_value = 0;
						if(isset($_POST[$my_field]))
						{
							$my_value = $_POST[$my_field];
						}
						$fields .= $my_field;
						$values .= "'" . $my_value . "'";
					}
					elseif(strpos($my_field,'_cdr'))
					{
						$my_id = addslashes(strip_tags($_POST[$my_field]));
						$x = addslashes(strip_tags($_POST[$my_field.'_x']));
						$y = addslashes(strip_tags($_POST[$my_field.'_y']));
						$my_value = $my_id . ',' . $x . ',' . $y;
						$fields .= $my_field;
						$values .= "'" . $my_value . "'";
					}
					elseif(strpos($my_field,'_crt'))
					{
						$my_value = 0;
						if(isset($_POST["cart_value_".$my_field]))
						{
							$my_value = $_POST["cart_value_".$my_field];
						}
						$fields .= $my_field;
						$values .= "'" . $my_value . "'";
					}
					
					else
					{
						$fields .= $my_field;
						$values .= "'" . addslashes(strip_tags($_POST[$my_field])) . "'";
					}
					
					if($field_count !=0)
					{
						$fields .= ',';
						$values .= ',';
					}
				}
				else
				{
					$field_count = $field_count - 1;
				}
			}
			//echo 'im here';
			$result = insert_db($table,$fields,$values,2);
			//echo $result;
			//$cur_insert_id = mysqli_insert_id($con);
			
			$cur_table = str_replace("tbl_","",$table);
			
			$cur_user = $_SESSION["manager"];
			$cur_user_id = get_value_condition("id","tbl_admin","username_str='$cur_user'");
			date_default_timezone_set('Asia/Manila');
			$date_time = date("Y-m-d h:i:sa");
			$table_title = get_value_condition("title_str","tbl_table","display_name_str = '$table'");
			$log_qry = insert_db("tbl_admin_logs","admin_idr,activity_lng,date_dtm","'$cur_user_id','<b>". $cur_user . "</b> Inserted Data to <b>" . $table_title. "</b> (".addslashes($values).")','$date_time'",1);
			//echo $result . "insert ID: " .$result;
			//echo 'im here';
			//NO Redirection Need on Sub Form
			return $result;
		}
		
		//echo $my_string_sql;
	}
	function get_field_value($field,$table,$id)
	{
		if($id!=0)
		{
			include ("fn_connect.php");
			$sql_string_field = 'SELECT ' . $field . ' as my_field FROM '.$table .' WHERE id = '.$id;
			//echo $sql_string_field . ' (im here)';
			$field_query = mysqli_query($con,$sql_string_field);
			if(mysqli_num_rows($field_query) > 0)
			{
				while($field_row = mysqli_fetch_array($field_query))
				{
					$my_field = $field_row['my_field'];
				}
				//echo $sql_string_field;
				return $my_field;
			}
		}
		//echo $id;
		//echo $sql_string_field;
	}
	function get_relative($table,$rel_id)
	{
		$result_string = "";
	
	//echo 'in get_relative';
		$option_query = select_db($table,"*","","(id=".$rel_id.")",2);
		//echo $option_query;
		//echo 'in get_relative';
		while($row_option = mysqli_fetch_array($option_query))
		{
			$id 			= $row_option['id'];
			$field_value 	= $row_option["display_name_str"];
			$result_string .= $field_value;
		}
		return $result_string;
	}
	function get_options_string($table,$my_val,$parent_table)
	{
		$admin_type_idr = get_value_condition("admin_type_idr","tbl_admin","username_str = '". $_SESSION["manager"]."'");
		$result_string = "";
		$table_id = get_value_condition("id","tbl_table","display_name_str = '".$table."'");
		$filter_str = get_value_condition("filter_str","tbl_admin_tables","(admin_type_idr=".$admin_type_idr.") AND (table_idr = ".$table_id.")");
		if(!$filter_str){
			$filter_str = "1=1";
		}
		$parent_table_idr = get_value_condition("id","tbl_table","display_name_str = '". $parent_table."'");
		$filter_field = get_value_condition("filter_sql_lng","tbl_table_field_filters","table_idr=".$parent_table_idr." AND LEFT(field_str,length(field_str)-4) = '".str_replace("tbl_","",$table)."'");
		if(!$filter_field){
			$filter_field = "1=1";
		}
		$no_null = get_value_condition("no_null_bol","tbl_table_field_filters","table_idr=".$parent_table_idr." AND LEFT(field_str,length(field_str)-4) = '".str_replace("tbl_","",$table)."'");
		
		$option_query = select_db($table,"*","","(".($filter_str)." AND ".($filter_field).")",2);
		//echo $filter_str;
		if($no_null == 0){
			$result_string .= '<option value="0"> None</option>';
		}
		while($row_option = mysqli_fetch_array($option_query))
		{
			$display_name_str 	= $row_option['display_name_str'];
			$selected			= "";
			$array = explode('-',$my_val);
			if($my_val == $display_name_str)
			{
				$selected = "selected";
			}
			//$result_string.= "im here";
			if(isset($row_option[2])){
				$row2  = $row_option[2];
				if(is_numeric($row2)){
					//$result_string.= $row2 . "imhere";
					//for idr searching code
				}
			} 
			$subdata = (isset($row_option[2]) && strlen($row_option[2])>3?' - ('.$row_option[2].')':'');
			
			$result_string .= '<option value="'.$display_name_str.'" '.$selected.'>'.utf8_decode($display_name_str.(isset($row_option[2]) && strlen($row_option[2])>3 && !strpos($row_option[2],'-')?' - ('.$row_option[2].')':'')).'</option>';
		}
		return $result_string;
	}
	function get_database_columns($table,$my_val)
	{
		$result_string = "";
		include ("fn_connect.php");
		$option_query = select_db("INFORMATION_SCHEMA.COLUMNS","COLUMN_NAME as cn, ordinal_position as id","","(TABLE_NAME = 	'".$table."' AND TABLE_SCHEMA = '".$database_name."') ORDER BY ORDINAL_POSITION ASC",2);
		//echo $option_query;
		if($no_null == 0){
			$result_string .= '<option value="0"> None</option>';
		}
		while($row_option = mysqli_fetch_array($option_query))
		{
			$id 				= $row_option['id'];
			$display_name_str 	= $row_option['cn'];
			$selected			= "";
			$array = explode('-',$my_val);
			if($my_val == $id)
			{
				$selected = "selected";
			}
			//$result_string.= "im here";
			if(isset($row_option[2])){
				$row2  = $row_option[2];
				if(is_numeric($row2)){
					//$result_string.= $row2 . "imhere";
					//for idr searching code
				}
			} 
			$subdata = (isset($row_option[2]) && strlen($row_option[2])>3?' - ('.$row_option[2].')':'');
			
			$result_string .= '<option value="'.$id.'" '.$selected.'>'.utf8_decode($display_name_str.(isset($row_option[2]) && strlen($row_option[2])>3 && !strpos($row_option[2],'-')?' - ('.$row_option[2].')':'')).'</option>';
		}
		return $result_string;
	}
	function get_options($table,$my_val,$parent_table,$return = 1)
	{
		$admin_type_idr = get_value_condition("admin_type_idr","tbl_admin","username_str = '". $_SESSION["manager"]."'");
		$result_string = "";
		$table_id = get_value_condition("id","tbl_table","display_name_str = '".$table."'");
		$filter_str = get_value_condition("filter_str","tbl_admin_tables","(admin_type_idr=".$admin_type_idr.") AND (table_idr = ".$table_id.")");
			if(!$filter_str){
				$filter_str = "1=1";
			}
		//echo $filter_str;
		
		$parent_table_idr = get_value_condition("id","tbl_table","display_name_str = '". $parent_table."'");
		$filter_field = get_value_condition("filter_sql_lng","tbl_table_field_filters","table_idr=".$parent_table_idr." AND LEFT(field_str,length(field_str)-4) = '".str_replace("tbl_","",$table)."'");
		$no_null = get_value_condition("no_null_bol","tbl_table_field_filters","table_idr=".$parent_table_idr." AND LEFT(field_str,length(field_str)-4) = '".str_replace("tbl_","",$table)."'");
		
		if(!$filter_field){
			$filter_field = "1=1";
		}
		
		
		
		if($return == 2){
			$option_query = select_db($table,"*","","(".($filter_str)." AND ".($filter_field).")",1);
			$result_string = $option_query;
			return $result_string;
		}
		else{
			$option_query = select_db($table,"*","","(".($filter_str)." AND ".($filter_field).")",2);
		}
		if($no_null == 0){
			$result_string .= '<option value="0"> None</option>';
		}
		while($row_option = mysqli_fetch_array($option_query))
		{
			$id 				= $row_option['id'];
			$display_name_str 	= $row_option['display_name_str'];
			$selected			= "";
			$array = explode('-',$my_val);
			if($my_val == $id)
			{
				$selected = "selected";
			}
			//$result_string.= "im here";
			if(isset($row_option[2])){
				$row2  = $row_option[2];
				if(is_numeric($row2)){
					//$result_string.= $row2 . "imhere";
					//for idr searching code
				}
			} 
			$subdata = (isset($row_option[2]) && strlen($row_option[2])>3?' - ('.$row_option[2].')':'');
			
			$result_string .= '<option value="'.$id.'" '.$selected.'>'.utf8_decode($display_name_str.(isset($row_option[2]) && strlen($row_option[2])>3 && !strpos($row_option[2],'-')?' - ('.$row_option[2].')':'')).'</option>';
		}
		return $result_string;
	}
	function get_options_like($table,$my_val,$parent_table,$qry,$limit)
	{
		//echo 'table' . $table . '<br/>';
		//echo 'my_val' . $my_val . '<br/>';
		//echo 'parent_table' . $parent_table . '<br/>';
		//echo 'qry' . $qry . '<br/>';
		//echo 'limit' . $table . '<br/>';
		
		$admin_type_idr = get_value_condition("admin_type_idr","tbl_admin","username_str = '". $_SESSION["manager"]."'");
		$result_string = "";
		$table_id = get_value_condition("id","tbl_table","display_name_str = '".$table."'");
		$filter_str = get_value_condition("filter_str","tbl_admin_tables","(admin_type_idr=".$admin_type_idr.") AND (table_idr = ".$table_id.")");
			if(!$filter_str){
				$filter_str = "1=1";
			}
		//echo $filter_str;
		
		$parent_table_idr = get_value_condition("id","tbl_table","display_name_str = '". $parent_table."'");
		$filter_field = get_value_condition("filter_sql_lng","tbl_table_field_filters","table_idr=".$parent_table_idr." AND LEFT(field_str,length(field_str)-4) = '".str_replace("tbl_","",$table)."'");
		$no_null = get_value_condition("no_null_bol","tbl_table_field_filters","table_idr=".$parent_table_idr." AND LEFT(field_str,length(field_str)-4) = '".str_replace("tbl_","",$table)."'");
		
		if(!$filter_field){
			$filter_field = "1=1";
		}
		;
		
		
		$q = $qry;
		$search_query = "";
		$table_name = str_replace("tbl_","",$table);
		$s_query = load_data( $table, 0 );	
		$s_row_count = mysqli_num_rows($s_query);
		
		$s_count = 0;
		while ( $s_row = mysqli_fetch_array( $s_query ) ){
			$search_query .= $s_row[ 'cn' ] . " LIKE '%".$q."%'";
			if($s_count < $s_row_count - 1){
				$search_query .= " OR ";
			}
			$s_count ++;
		}
	
	
		$option_query = select_db($table,"*","","(".($filter_str)." AND ".($filter_field).") AND (".($search_query).") LIMIT ".$limit,2);
		//echo $filter_str;
		while($r = mysqli_fetch_assoc($option_query))
		{
			$rows[] = $r;
		}
		return json_encode($rows);
	}
	function get_options_array($table,$my_val,$parent_table)
	{
		$admin_type_idr = get_value_condition("admin_type_idr","tbl_admin","username_str = '". $_SESSION["manager"]."'");
		$result_string = "";
		$filter_str = "1";
		
		$table_id = get_value_condition("id","tbl_table","display_name_str = '".$table."'");
			if(null !==(get_value_condition("filter_str","tbl_admin_tables","(admin_type_idr=".$admin_type_idr.") AND (table_idr = ".$table_id.")"))){
				$filter_str = get_value_condition("filter_str","tbl_admin_tables","(admin_type_idr=".$admin_type_idr.") AND (table_idr = ".$table_id.")");
				//echo 'im here';
				//echo $filter_str;
				if(!$filter_str){
				$filter_str = "1=1";
				}
			}
		$parent_table_idr = get_value_condition("id","tbl_table","display_name_str = '". $parent_table."'");
		$filter_field = get_value_condition("filter_sql_lng","tbl_table_field_filters","table_idr=".$parent_table_idr." AND LEFT(field_str,length(field_str)-4) = '".str_replace("tbl_","",$table)."'");
		if(!$filter_field){
			$filter_field = "1=1";
		}
		$no_null = get_value_condition("no_null_bol","tbl_table_field_filters","table_idr=".$parent_table_idr." AND LEFT(field_str,length(field_str)-4) = '".str_replace("tbl_","",$table)."'");
		
		$option_query = select_db($table,"*","","(".($filter_str)." AND ".($filter_field).")",2);
		//echo $option_query;
		if($no_null == 0){
			$result_string .= '<option value="0"> None</option>';
		}
		while($row_option = mysqli_fetch_array($option_query))
		{
			$id 				= $row_option['id'];
			$display_name_str 	= $row_option['display_name_str'];
			$selected			= "";
			$array = explode('-',$my_val);
			if(in_array($id, $array))
			{
				$selected = "selected";
			}
			$result_string .= '<option value="'.$id.'" '.$selected.'>'.utf8_decode($display_name_str.(isset($row_option[2]) && strlen($row_option[2])>3?' - ('.$row_option[2].')':'')).'</option>';
		}
		return $result_string;
	}
	function get_imgs($table,$my_val)
	{
		include ("fn_connect.php");
		$sql_string = "SELECT COLUMN_NAME as cn FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 	'".$table."' AND TABLE_SCHEMA = '".$database_name."' AND COLUMN_NAME LIKE '%_img' ORDER BY ORDINAL_POSITION ASC LIMIT 1";
		$query = mysqli_query($con,$sql_string);
		while($row = mysqli_fetch_array($query))
		{
			$cn = $row['cn'];
		}
		$result_string = "";
		$option_query = select_db($table,"id,display_name_str,".$cn,"","(1=1)",2);
		//echo $option_query;
		while($row_option = mysqli_fetch_array($option_query))
		{
			$id 				= $row_option['id'];
			$cn_name 			= $row_option[$cn];
			$display_name_str 	= $row_option['display_name_str'];
			$selected			= "";
			if($my_val == $id.'-'.$cn_name)
			{
				$selected = "selected";
			}
			$result_string .= '<option value="'.$id.'-'.$cn_name.'" '.$selected.'>'.$display_name_str.'</option>';
		}
		return $result_string;
	}
	function get_img($table,$id)
	{
		include ("fn_connect.php");
		$sql_string = "SELECT COLUMN_NAME as cn FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 	'".$table."' AND TABLE_SCHEMA = '".$database_name."' AND COLUMN_NAME LIKE '%_img' ORDER BY ORDINAL_POSITION ASC LIMIT 1";
		$query = mysqli_query($con,$sql_string);
		while($row = mysqli_fetch_array($query))
		{
			$cn = $row['cn'];
		}
		$sql_string = "SELECT ".$cn." as my_val FROM ".$table." WHERE id = ".$id." LIMIT 1";
		$query = mysqli_query($con,$sql_string);
		while($row = mysqli_fetch_array($query))
		{
			$my_val = $row['my_val'];
		}
		if(isset($my_val))
		{
			return $my_val;
		}
		else
		{
			return 0;
		}
		//echo $sql_string;
	}
	function get_img_field($table)
	{
		include ("fn_connect.php");
		$sql_string = "SELECT COLUMN_NAME as cn FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 	'$table' AND TABLE_SCHEMA = '".$database_name."' AND COLUMN_NAME LIKE '%_img' ORDER BY ORDINAL_POSITION ASC LIMIT 1";
		$query = mysqli_query($con,$sql_string);
		while($row = mysqli_fetch_array($query))
		{
			$cn = $row['cn'];
		}
		$cn = str_replace("_img","",$cn);
		return $cn;
	}
	function get_form_fields($cn,$cc,$table,$id)
	{	
		$my_val = get_field_value($cn,$table,$id);
		$admin_type_idr = get_value_condition("admin_type_idr","tbl_admin","username_str = '". $_SESSION["manager"]."'");
		
		$table_id = get_value_condition("id","tbl_table","display_name_str = '".$table."'");
		//update_fields
		$update_fields_str = "*";
		$update_fields_str = get_value_condition("update_fields_str","tbl_admin_tables","(admin_type_idr=".$admin_type_idr.") AND 	(table_idr = ".$table_id.")");
		
		if($update_fields_str ==""){
			$update_fields_str = "*";
		}
		//echo "(".$update_fields_str . "-".$cn.")".(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly");
		//echo $cn;
		//echo ;
	
		$cn_field = str_replace("_"," ",$cn);
		$cn_field = ucwords($cn_field);
		$my_field = substr($cn_field, 0, -4);
		$frm_string = '';
		
		if($cn == 'id')
		{
			$frm_string .= '
			<input type="hidden" name="'.$cn.'" value="'.$my_val.'" />
			
			';
		}
		elseif(strpos($cn,'_pdf'))
		{
			if (!file_exists("uploads/".strtolower($my_field))) {
			mkdir("uploads/".strtolower($my_field), 0777, true);
			}
			if (!file_exists("uploads/".strtolower($my_field)."/thumbs")) {
			mkdir("uploads/".strtolower($my_field)."/thumbs", 0777, true);
			}
			$frm_string = '<div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">
			<label>Upload '.$my_field.'</label>
			<div class="input-group">
				<span class="input-group-btn">
					<span class="btn btn-default btn-file">
						Browse… <input type="file" id="imgInp" name="'.$cn.'">
					</span>
				</span>
				<input type="text" class="form-control" readonly>
			</div>
			';
			//check if has val
			if($my_val == ""){
				$image_src = 'image/drag.png';
			}else{
				$image_src = 'uploads/'.strtolower($my_field).'/'.$my_val;
			}	
			
				$frm_string .= '<a class="btn btn-success" id="img-upload" href="'.$image_src.'" download> Download</a>
		</div>';
		}
		elseif($cn == 'display_name_str')
		{
			//echo $table;
			$auto_id = get_value_condition("autoid_bol","tbl_table","display_name_str = '$table'");
			$readonly = ($auto_id == 1? "readonly": "");
			$my_display_field_table = ucwords(str_replace("tbl_","",$table));
			$my_field = $my_display_field_table . " ID";
			
			$date_time = date("Ymdhis");
			$generated_id = substr(strtoupper(preg_replace('#[aeiou\s]+#i', '', $my_display_field_table)),0,3);
			$auto_val = ($my_val==""?$generated_id.$date_time:$my_val);
			$auto_val = ($auto_id == 1?$auto_val: $my_val);
			$frm_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.str_replace("_"," ",$my_field).'</label>';
				}
				$frm_string .='
				<input '.$readonly.' class="form-control" type="text" name="'.$cn.'_'.strtolower($my_display_field_table).'" value="'.$auto_val.'"/>
			</div>
			';
		}
		elseif(strpos($cn,'_isr'))
		{
			$my_cn = str_replace('_isr',"",$cn);
			//echo 'IM HERE IN IDR';
			$option_table = "tbl_".$my_cn;
			$frm_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
				<select data-table="'.$my_cn.'" class="form-control isr" name="'.$cn.'">';
			$frm_string .= 
			'</select></div>
			';
		}
		elseif(strpos($cn,'_idr'))
		{
			$my_cn = str_replace('_idr',"",$cn);
			//echo 'IM HERE IN IDR';
			$option_table = "tbl_".$my_cn;
			$frm_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
				<select id="'.$cn.'" class="form-control" name="'.$cn.'">';
				$frm_string .= get_options($option_table,$my_val,$table);
			
			$frm_string .= 
			'</select>
			</div>
			';
		}
		elseif(strpos($cn,'_ids'))
		{
			$my_cn = str_replace('_ids',"",$cn);
			//echo 'IM HERE IN IDR';
			$option_table = "tbl_".$my_cn;
			$frm_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
				<select class="form-control" name="'.$cn.'">';
				$frm_string .= get_options_string($option_table,$my_val,$table);
			
			$frm_string .= 
			'</select>
			</div>
			';
		}
		elseif(strpos($cn,'_sgn'))
		{
			$my_cn     = str_replace( '_sgn', "", $cn );
			//check if has val
			if($my_val == ""){
				$image_src = 'image/drag.png';
			}else{
				$image_src = 'uploads/'.strtolower($my_field).'/'.$my_val;
			}	
			
				$frm_string .= '<img class="form-logo" id="'.$cn.'" src="'.$image_src.'"/>
		</div>';
			$frm_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
				<div class="sgn-container">';
					if($cc!="NAN"){
						$frm_string .= '<label>'.$cc.'</label>';
					}else{
						$frm_string .= '<label>'.$my_field.'</label>';
					}
					$frm_string .='
					<div class="btn btn-success sgn-save '.(isset($my_val)?"active":"").'" data-target="'.$cn.'">Save</div>
					<div class="btn btn-danger sgn-clear" ">Clear</div>
					<input class="hidden sgn" type="hidden" name="'.$cn.'" id="'.$cn.'" value="'.$my_val.'">
					<img class="show_sign" alt=""test src="'.$image_src . '?' . date( "sa" ) . '">
					<div id="signatureparent">
					  <div id="signature"></div>
					</div>
				</div>
			</div>
			';
		}
		elseif(strpos($cn,'_flt'))
		{
			$my_cn = str_replace('_flt',"",$cn);
			$option_table = "tbl_".$my_cn;
			$frm_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
				<select class="form-control flt" data-target="'.$my_cn.'" name="'.$cn.'">';
				$frm_string .= get_options($option_table,$my_val,$table);
			
			$frm_string .= 
			'</select>
			
			</div>
			';
		}
		elseif(strpos($cn,'_vsb'))
		{
			
			$my_cn = str_replace('_vsb',"",$cn);
			//echo 'IM HERE IN IDR';
			$option_table = "tbl_".$my_cn;
			$frm_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .= '<select data-table="'.$my_cn.'" class="form-control vtb isr" data-target="'.$cn.'" name="'.$cn.'">';
				$frm_string .= '<option value="0"> None</option>';
				if($my_val!=""){
					$option_query = select_db($option_table,"*","","(id = (".$my_val."))",2);
					//echo $option_query;
					
					while($row_option = mysqli_fetch_array($option_query))
					{
						$id 				= $row_option['id'];
						$display_name_str 	= $row_option['display_name_str'];
						$selected = "selected";
						$result_string .= '<option value="'.$id.'" '.$selected.'>'.utf8_decode($display_name_str.(isset($row_option[2]) && strlen($row_option[2])>3?' - ('.$row_option[2].')':'')).'</option>';
					}
				}
				$frm_string .= $result_string;
			
			$frm_string .= 
			'</select>
				<div class="vtb-ov">
				<table id="'.$cn.'" class="vtb-container"></table>
				</div>
			</div>
			';
		}
		elseif(strpos($cn,'_vtb'))
		{
			
			$my_cn = str_replace('_vtb',"",$cn);
			//echo 'IM HERE IN IDR';
			$option_table = "tbl_".$my_cn;
			$frm_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
				<select class="form-control vtb" data-target="'.$cn.'" name="'.$cn.'">';
				$frm_string .= get_options($option_table,$my_val,$table);
			
			$frm_string .= 
			'</select>
				<div class="vtb-ov">
				<table id="'.$cn.'" class="vtb-container"></table>
				</div>
			</div>
			';
		}
		elseif(strpos($cn,'_qra'))
		{
			$my_cn = str_replace('_qra',"",$cn);
			//echo 'IM HERE IN IDR';
			$option_table = "tbl_".$my_cn;
			$frm_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='<div data-target="'.$cn.'" class="qra" /></div>
				<div class="vtb-ov">
					<table id="'.$cn.'" class="vtb-container"></table>
				</div>
				<div class="container" id="QR-Code">
				<div class="panel panel-info">
					<div class="panel-heading">
						<div class="navbar-form navbar-right">
							<select class="form-control" id="camera-select"></select>
							<div class="form-group">
								<button title="Image shoot" class="btn btn-info btn-sm disabled" id="grab-img" type="button" data-toggle="tooltip"><span class="fa fa-camera"></span></button>
								<button title="Play" class="btn btn-success btn-sm" id="play" type="button" data-toggle="tooltip"><span class="fa fa-play"></span></button>
								<button title="Pause" class="btn btn-warning btn-sm" id="pause" type="button" data-toggle="tooltip"><span class="fa fa-pause"></span></button>
								<button title="Stop streams" class="btn btn-danger btn-sm" id="stop" type="button" data-toggle="tooltip"><span class="fa fa-stop"></span></button>
							 </div>
						</div>
					</div>
					</div>
					
			</div>
			</div>
				<div class="vta-ov">
				<table id="'.$cn.'" class="vta-container"></table>
				</div>
			</div>
			';
		}
		elseif(strpos($cn,'_vta'))
		{
			$my_cn = str_replace('_vta',"",$cn);
			//echo 'IM HERE IN IDR';
			$option_table = "tbl_".$my_cn;
			$frm_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
				<select multiple="multiple" class="form-control vta" data-target="'.$cn.'" name="'.$cn.'[]">';
				$frm_string .= get_options_array($option_table,$my_val,$table);
			
			$frm_string .= 
			'</select>
				<div class="vta-ov">
				<table id="'.$cn.'" class="vta-container"></table>
				</div>
			</div>
			';
		}
		elseif(strpos($cn,'_vsa'))
		{
			$my_cn = str_replace('_vsa',"",$cn);
			//echo 'IM HERE IN IDR';
			$option_table = "tbl_".$my_cn;
			$frm_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
				<select multiple="multiple" d class="form-control vta isr" data-table="'.$my_cn.'" data-target="'.$cn.'" name="'.$cn.'[]">';
				if($my_val!=""){
					$array = str_replace('-',',',$my_val);
					$option_query = select_db($option_table,"*","","(id IN (".$array."))",2);
					//echo $option_query;
					$result_string .= '<option value="0"> None</option>';
					while($row_option = mysqli_fetch_array($option_query))
					{
						$id 				= $row_option['id'];
						$display_name_str 	= $row_option['display_name_str'];
						$selected = "selected";
						$result_string .= '<option value="'.$id.'" '.$selected.'>'.utf8_decode($display_name_str.(isset($row_option[2]) && strlen($row_option[2])>3?' - ('.$row_option[2].')':'')).'</option>';
					}
				}
				$frm_string .= $result_string;
			$frm_string .= 
			'</select>
				<div class="vta-ov">
				<table id="'.$cn.'" class="vta-container"></table>
				</div>
			</div>
			';
		}
		elseif(strpos($cn,'_arr'))
		{
			$my_cn = str_replace('_arr',"",$cn);
			$option_table = "tbl_".$my_cn;
			$frm_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
				<select multiple="multiple" class="form-control" name="'.$cn.'[]">';
				$frm_string .= get_options_array($option_table,$my_val,$table);
			
			$frm_string .= 
			'</select>
				
			</div>
			';
		}
		elseif(strpos($cn,'_crt'))
		{
			$my_cn = str_replace('_crt',"",$cn);
			$option_table = "tbl_".$my_cn;
			$frm_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left cart">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
				<div class="cart_container" id="'.$cn.'">
					<input type="hidden" class="ci_hidden" name="cart_value_'.$cn.'" id="cart_value_'.$cn.'" value="'.$my_val.'"/>
	
					<div class="cart_item cart_selector" id="ci_'.$cn.'">
						<div class="ci_name" id="cn_'.$cn.'">
							<select class="form-control" id="cs_'.$cn.'" name="'.$cn.'">';
								$frm_string .= get_options($option_table,$my_val,$table);
								$frm_string .= 
							'</select>
						</div>
						<div class="ci_qty"><input id="ci_q_'.$cn.'" type="number" name="" value="1" min="1" max="1000" /></div>
						<div class="ci_btn"><div class="btn btn-success crt_add" data-target="'.$cn.'"> <i class="fa fa-plus"></i></div></div>
					</div>
					';
					//echo 'im here';
					if(isset($my_val)){
						$crt_array = explode(',',$my_val);
						//echo count($crt_array) . 'im here';
						
					}
					$frm_string.='
				</div>
				
			</div>
			';
		}
		
		elseif(strpos($cn,'_cdr'))
		{
			$my_cn = str_replace('_cdr',"",$cn);
			$cdr_table = "tbl_".$my_cn;
			
			$option_id = 0;
			$x_cor = 0;
			$y_cor = 0;
			if(isset($my_val))
			{
			$cdr_val = explode(",", $my_val);
			$option_id = $cdr_val[0];
			$x_cor = $cdr_val[1];
			$y_cor = $cdr_val[2];
			}
			
			$my_field = get_img_field($cdr_table);
			$my_img = get_img($cdr_table,$id);
			$frm_string = 
			'<div class="row">
				<div class="col-md-4 col-sm-12">
					<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
					if($cc!="NAN"){
						$frm_string .= '<label>'.$cc.'</label>';
					}else{
						$frm_string .= '<label>'.$my_field.'</label>';
					}
					$frm_string .='
					<select class="form-control" id="scdr" name="'.$cn.'" data-img="'.$my_img.'" data-field="'.strtolower($my_field).'">';
					$frm_string .= get_imgs($cdr_table,$option_id);
					$frm_string .= 
				'	</select>
					</div>
					<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">
					<label>'.ucwords($my_field).' X Coordinate</label>
					<input id="x_coordinate" class="form-control" type="text" name="'.$cn.'_x" value="'.$x_cor.'"/>
					</div>
					<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">
					<label>'.ucwords($my_field).' Y Coordinate</label>
					<input id="y_coordinate" class="form-control" type="text" name="'.$cn.'_y" value="'.$y_cor.'"/>
					</div>
					</div>
			';
			
			$frm_string .= 
			'<div class="col-md-8 col-sm-12">
				<img id="cdr" src="uploads/'.$my_cn.'/'.$my_val.'"/>
				<canvas id="myCanvas" width="100%" height="auto"></canvas>
			</div>
			';
			$frm_string .= 
			'</div>
			';
		}
		elseif(strpos($cn,'_str'))
		{
			$frm_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
				<input class="form-control" type="text" name="'.$cn.'" value="'.$my_val.'"/>
			</div>
			';
			
		}
		elseif(strpos($cn,'_psw'))
		{
			$frm_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
				<input class="form-control" type="password" name="'.$cn.'" value="'.$my_val.'"/>
			</div>
			';
			
		}
		elseif(strpos($cn,'_col'))
		{
			$frm_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
				<input class="form-control color-control" type="color" name="'.$cn.'" value="'.$my_val.'"/>
			</div>
			';
			
		}
		elseif(strpos($cn,'_bol'))
		{
			$checked = "";
			if($my_val==1)
			{
				$checked = "checked";
			}
			$frm_string = 
			'<div class="f-bol  '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' form-group col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
				<input class="form-control cbox" type="checkbox" name="'.$cn.'" value="'.$my_val.'" '.$checked.'/>
			</div>
			';
			
		}
		elseif(strpos($cn,'_qrc'))
		{
			$checked = "";
			$frm_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
				<input class="form-control qrc-text" type="text" name="'.$cn.'" value="'.$my_val.'"/>
				';
					$frm_string .= '<div class="qrc-container">
					<div class="qrc-btn btn btn-success" data-target="#qr-'.$cn.'"> Generate QR Code</div>
					<div id="qr-'.$cn.'" class="qrc"></div>
					</div>';
				
			$frm_string .= '
			</div>
			';
			
		}
		elseif(strpos($cn,'_int'))
		{
			$frm_string = '<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
					<input class="form-control" type="number" name="'.$cn.'" value="'.$my_val.'"/>
				</div>
			';
		}
		elseif(strpos($cn,'_lng'))
		{
			$frm_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
				<textarea rows="3" class="form-control" name="'.$cn.'">'.$my_val.'</textarea>
			</div>
			';
		}
		elseif(strpos($cn,'_rch'))
		{
			$frm_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
				<textarea rows="15" class="form-control nice-txt myNicEditor" name="'.$cn.'">'.$my_val.'</textarea>
			</div>
			';
		}
		elseif(strpos($cn,'_gal'))
		{
			$frm_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left gallery-img">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
				<textarea rows="15" class="form-control nice-txt myNicEditor" name="'.$cn.'">'.$my_val.'</textarea>
			</div>
			';
		}
		elseif(strpos($cn,'_pct'))
		{
			$frm_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
				<input class="form-control" max="100" min="0" type="number" name="'.$cn.'" value="'.$my_val.'"/><span class="pct">%</span>
			</div>
			';
		}
		elseif(strpos($cn,'_url'))
		{
			$frm_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
				<input class="form-control" type="url" name="'.$cn.'" value="'.$my_val.'"/>
			</div>
			';
		}
		elseif(strpos($cn,'_eml'))
		{
			$frm_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
				<input class="form-control" type="email" name="'.$cn.'" value="'.$my_val.'"/>
			</div>
			';
		}
		elseif(strpos($cn,'_dat'))
		{
			$frm_string = '<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
					<input class="form-control" type="date" name="'.$cn.'" value="'.$my_val.'"/>
				</div>
			';
			
		}
		elseif(strpos($cn,'_dtm'))
		{
			$frm_string = '<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
					<input class="form-control" type="datetime" name="'.$cn.'" value="'.$my_val.'"/>
				</div>
			';
			
		}
		elseif(strpos($cn,'_dta'))
		{
			$cur_val = $my_val;
			$date_now = date("Y-m-d");
			$new_val = (isset($my_val)?$cur_val:$date_now);
			
			$frm_string = '<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
					<input readonly class="form-control  disabled" type="date" name="'.$cn.'" value="'.$new_val.'"/>
				</div>
			';
			
		}
		elseif(strpos($cn,'_dec'))
		{
			$frm_string = '<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
					<input class="form-control" type="number" step="0.01" name="'.$cn.'" value="'.$my_val.'"/>
				</div>
			';
		}
		elseif(strpos($cn,'_cur'))
		{
			$frm_string = '<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
					<input class="form-control" type="number" step="0.01" name="'.$cn.'" value="'.$my_val.'"/>
				</div>
			';
			
		}
		elseif(strpos($cn,'_img'))
		{
			if (!file_exists("uploads/".strtolower($my_field))) {
			mkdir("uploads/".strtolower($my_field), 0777, true);
			}
			if (!file_exists("uploads/".strtolower($my_field)."/thumbs")) {
			mkdir("uploads/".strtolower($my_field)."/thumbs", 0777, true);
			}
			$frm_string = '<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
			<div class="input-group">
				<span class="input-group-btn">
					<span class="btn btn-default btn-file">
						Browse… <input type="file" class="imgInp" data-txt="txt-'.$cn.'" data-target="'.$cn.'">
					</span>
				</span>
				<input type="text" class="form-control" readonly>
			</div>
			<input type="hidden" id="txt-'.$cn.'" name="'.$cn.'">
			';
			//check if has val
			if($my_val == ""){
				$image_src = 'image/drag.png';
			}else{
				$image_src = 'uploads/'.strtolower($my_field).'/'.$my_val;
			}	
			
				$frm_string .= '<img class="form-logo" id="'.$cn.'" src="'.$image_src.'?'.time().'"/>
		</div>';
		}
		elseif(strpos($cn,'_log'))
		{
			if (!file_exists("uploads/logo/".$my_field)) {
			mkdir("uploads/logo/".$my_field, 0777, true);
			}
			if (!file_exists("uploads/logo/".strtolower($my_field)."/thumbs")) {
			mkdir("uploads/logo/".strtolower($my_field)."/thumbs", 0777, true);
			}
			$frm_string = '<div id="'.linkerize($my_field).'" class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$frm_string .= '<label>'.$cc.'</label>';
				}else{
					$frm_string .= '<label>'.$my_field.'</label>';
				}
				$frm_string .='
			<div class="input-group">
				<span class="input-group-btn">
					<span class="btn btn-default btn-file">
						Browse… <input type="file" class="imgInp" data-txt="txt-'.$cn.'" data-target="'.$cn.'">
					</span>
				</span>
				<input type="text" class="form-control" readonly>';
			//check if has val
			if($my_val == ""){
				$image_src = 'image/drag.png';
			}else{
				$image_src = 'uploads/logo/'.strtolower($my_field).'/'.$my_val;
			}	
			
				$frm_string .= '<img class="form-logo" id="'.$cn.'" src="'.$image_src.'"/>
			</div>
			
		</div>';
		}
		else
		{
			
		}
		
		return $frm_string;
		
		//echo 'im here';
	}
	function check_table_field($cn,$cc,$table,$id)
	{	
		$my_val = get_field_value($cn,$table,$id);
		$admin_type_idr = get_value_condition("admin_type_idr","tbl_admin","username_str = '". $_SESSION["manager"]."'");
		$table_id = get_value_condition("id","tbl_table","display_name_str = '".$table."'");
		//update_fields
		
		//select column_name  from information_schema.columns where table_name = 'my_table_name' and ordinal_position = 2;
		$column_index = get_value_condition("ordinal_position","information_schema.columns","table_name = '".$table."' AND column_name = '".$cn."'");
		if(isset($_GET["debug"])){
			echo $column_index-1;
		}
		
		
		$update_fields_str = "*";
		$update_fields_str = get_value_condition("update_fields_str","tbl_admin_tables","(admin_type_idr=".$admin_type_idr.") AND 	(table_idr = ".$table_id.")");
		
		if($update_fields_str ==""){
			$update_fields_str = "*";
		}
		//echo "(".$update_fields_str . "-".$cn.")".(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly");
		//echo $cn;
		//echo ;
		
		$cn_field = str_replace("_"," ",$cn);
		$cn_field = ucwords($cn_field);
		$my_field = substr($cn_field, 0, -4);
		$my_string = '';
		
		$my_string .= $column_index;
		
		
		if($cn == 'id')
		{
			$my_string = '
			<input type="hidden" name="'.$cn.'" value="'.$my_val.'" />
			';
		}
		elseif($cn == 'display_name_str')
		{
			//echo $table;
			
			$auto_id = get_value_condition("autoid_bol","tbl_table","display_name_str = '$table'");
			$readonly = ($auto_id == 1? "readonly": "");
			$my_display_field_table = ucwords(str_replace("tbl_","",$table));
			$my_field = $my_display_field_table . " ID";
			
			$date_time = date("Ymdhis");
			$generated_id = substr(strtoupper(preg_replace('#[aeiou\s]+#i', '', $my_display_field_table)),0,3);
			$auto_val = ($my_val==""?$generated_id.$date_time:$my_val);
			$auto_val = ($auto_id == 1?$auto_val: $my_val);
			$my_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .= '
				<input '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' '.$readonly.' required class="form-control" type="text" name="'.$cn.'" value="'.$auto_val.'"/>
			</div>
			';
		}
		elseif(strpos($cn,'_pdf'))
		{
			if (!file_exists("uploads/".strtolower($my_field))) {
			mkdir("uploads/".strtolower($my_field), 0777, true);
			}
			if (!file_exists("uploads/".strtolower($my_field)."/thumbs")) {
			mkdir("uploads/".strtolower($my_field)."/thumbs", 0777, true);
			}
			$my_string = '<div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">
			<label>Upload '.$my_field.'</label>
			<div class="input-group">
				<span class="input-group-btn">
					<span class="btn btn-default btn-file">
						Browse… <input type="file" id="imgInp" name="'.$cn.'">
					</span>
				</span>
				<input type="text" class="form-control" readonly>
			</div>
			';
			//check if has val
			if($my_val == ""){
				$image_src = 'image/drag.png';
			}else{
				$image_src = 'uploads/'.strtolower($my_field).'/'.$my_val;
			}	
			
				$my_string .= '<a class="btn btn-success" id="img-upload" href="'.$image_src.'" download> Download</a>
		</div>';
		}
		elseif(strpos($cn,'_frm'))
		{
			$frm_id = 0;
			if(isset($my_val)){
				$frm_id=$my_val;
			}
			$my_cn = str_replace('_frm',"",$cn);
			$table_name = "tbl_".$my_cn;
			$table_id = get_value_condition("id","tbl_table","display_name_str='".$table_name."'");
			$frm_query = load_data($table_name,0);	
			$ctr = 0;
			$my_string = 
			'<div class="frm_container '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
				<hr class="bg-info" />';
				$my_string .='
				<div class="frm-group">
				
				<select id="sel-'.$cn.'" data-table="'.$my_cn.'" class="form-control vtb isr sel-frm" data-hidtext="hd-'.$cn.'" data-target="'.$cn.'" name="'.$cn.'">';
				$my_string .= '<option value="0"> None</option>';
				if($my_val!=""){
					$option_query = select_db($table_name,"*","","(id = (".$my_val."))",2);
					//echo $option_query;
					
					while($row_option = mysqli_fetch_array($option_query))
					{
						$id 				= $row_option['id'];
						$display_name_str 	= $row_option['display_name_str'];
						$selected = "selected";
						$result_string .= '<option value="'.$id.'" '.$selected.'>'.utf8_decode($display_name_str.(isset($row_option[2]) && strlen($row_option[2])>3?' - ('.$row_option[2].')':'')).'</option>';
					}
				}
				$my_string .= $result_string;
			
			$my_string .= 
			'</select>';
				if($frm_id == 0){ 
					$my_string .= '
				<div class="btn btn-success frm-new" data-select="sel-'.$cn.'" data-vtb="vtb-'.$cn.'" data-tbl="'.$my_cn.'" data-target="fc-'.$cn.'"><i class="fa fa-plus"></i> New</div>
				
				';
				}else{
					$my_string .= '
				<div class="btn btn-info frm-update" data-select="sel-'.$cn.'" data-vtb="vtb-'.$cn.'" data-tbl="'.$my_cn.'" data-target="fc-'.$cn.'"><i class="fa fa-pencil"></i> Update</div>
				
				';
				}
				 $my_string .= '
				<div class="vtb-ov" id="vtb-'.$cn.'">
				<table id="'.$cn.'" class="vtb-container"></table>
				</div>
				<input class="form-control" id="hd-'.$cn.'" type="hidden" name="'.$cn.'" value="'.$my_val.'"/>';
				
				$my_string .= '<div class="frm-container" id="fc-'.$cn.'">';
				
			$my_string .= '
				</div>';
				
				$my_string .= '
			</div>
			</div>
			';
				$my_string .= '
			</div>
			';
		}
		elseif(strpos($cn,'_sgn'))
		{
			$my_cn     = str_replace( '_sgn', "", $cn );
			//check if has val
			if($my_val == ""){
				$image_src = 'image/drag.png';
			}else{
				$image_src = 'uploads/'.strtolower($my_field).'/'.$my_val;
			}	
			
				$my_string .= '<img class="form-logo" id="'.$cn.'" src="'.$image_src.'?'.time().'"/>
		</div>';
			$my_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
				<div class="sgn-container">';
					if($cc!="NAN"){
						$my_string .= '<label>'.$cc.'</label>';
					}else{
						$my_string .= '<label>'.$my_field.'</label>';
					}
					$my_string .='
					<div class="btn btn-success sgn-save '.(isset($my_val)?"active":"").'" data-target="'.$cn.'">Save</div>
					<div class="btn btn-danger sgn-clear" ">Clear</div>
					<input class="hidden sgn" type="hidden" name="'.$cn.'" id="'.$cn.'" value="'.$my_val.'">
					<img class="show_sign" alt=""test src="'. $image_src . '?' . date( "sa" ) . '">
					<div id="signatureparent">
					  <div id="signature"></div>
					</div>
				</div>
			</div>
			';
		}
		elseif(strpos($cn,'_ids'))
		{
			
			$my_cn = str_replace('_ids',"",$cn);
			$option_table = "tbl_".$my_cn;
			$my_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
				<select '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' class="form-control" name="'.$cn.'">';
				$my_string .= get_options_string($option_table,$my_val,$table);
			
			$my_string .= 
			'</select>
			</div>
			';
		}
		elseif(strpos($cn,'_isr'))
		{
			$my_cn = str_replace('_isr',"",$cn);
			//echo 'IM HERE IN IDR';
			$option_table = "tbl_".$my_cn;
			$my_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
				<select data-table="'.$my_cn.'" class="form-control isr" name="'.$cn.'">';
			$my_string .= 
			'</select></div>
			';
		}
		elseif(strpos($cn,'_dcl'))
		{
			
			$my_cn = str_replace('_dcl',"",$cn);
			$option_table = "tbl_".$my_cn;
			$my_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
				<select id="'.$cn.'" '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' class="form-control" name="'.$cn.'">';
				$my_string .= get_database_columns($option_table,$my_val);
			
			$my_string .= 
			'</select>
			</div>
			';
		}
		elseif(strpos($cn,'_idr'))
		{
			
			$my_cn = str_replace('_idr',"",$cn);
			$option_table = "tbl_".$my_cn;
			$my_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
				<select id="'.$cn.'" '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' class="form-control" name="'.$cn.'">';
				$my_string .= get_options($option_table,$my_val,$table);
			
			$my_string .= 
			'</select>
			</div>
			';
		}
		elseif(strpos($cn,'_flt'))
		{
			$my_cn = str_replace('_flt',"",$cn);
			$option_table = "tbl_".$my_cn;
			$my_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
				<select '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' class="form-control flt" data-target="'.$my_cn.'" name="'.$cn.'">';
				$my_string .= get_options($option_table,$my_val,$table);
			
			$my_string .= 
			'</select>
			
			</div>
			';
		}
		elseif(strpos($cn,'_vsb'))
		{
			
			$my_cn = str_replace('_vsb',"",$cn);
			//echo 'IM HERE IN IDR';
			$option_table = "tbl_".$my_cn;
			$my_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
				<select data-table="'.$my_cn.'" class="form-control vtb isr" data-target="'.$cn.'" name="'.$cn.'">';
				$my_string .= '<option value="0"> None</option>';
				if($my_val!=""){
					$option_query = select_db($option_table,"*","","(id = (".$my_val."))",2);
					//echo $option_query;
					
					while($row_option = mysqli_fetch_array($option_query))
					{
						$id 				= $row_option['id'];
						$display_name_str 	= $row_option['display_name_str'];
						$selected = "selected";
						$result_string .= '<option value="'.$id.'" '.$selected.'>'.utf8_decode($display_name_str.(isset($row_option[2]) && strlen($row_option[2])>3?' - ('.$row_option[2].')':'')).'</option>';
					}
				}
				$my_string .= $result_string;
			
			$my_string .= 
			'</select>
				<div class="vtb-ov">
				<table id="'.$cn.'" class="vtb-container"></table>
				</div>
			</div>
			';
		}
		elseif(strpos($cn,'_vtb'))
		{
			
			$my_cn = str_replace('_vtb',"",$cn);
			$option_table = "tbl_".$my_cn;
			$my_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
				<select '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' class="form-control vtb" data-target="'.$cn.'" name="'.$cn.'">';
				$my_string .= get_options($option_table,$my_val,$table);
			
			$my_string .= 
			'</select>
				<div class="vtb-ov">
				<table id="'.$cn.'" class="vtb-container"></table>
				</div>
			</div>
			';
		}
		elseif(strpos($cn,'_qra'))
		{
			$my_cn = str_replace('_qra',"",$cn);
			//echo 'IM HERE IN IDR';
			$option_table = "tbl_".$my_cn;
			$my_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='<div data-target="'.$cn.'" class="qra" />
				<input type="hidden" class="current-qr" />
				</div>
				<div class="vtb-ov">
					<table id="'.$cn.'" class="vtb-container"></table>
				</div>
				<div class="container" id="QR-Code">
				<div class="panel panel-info">
					<div class="panel-heading">
						<div class="navbar-form navbar-right">
							<select class="form-control" id="camera-select"></select>
							<div class="form-group">
								<button title="Image shoot" class="btn btn-info btn-sm disabled" id="grab-img" type="button" data-toggle="tooltip"><span class="fa fa-camera"></span></button>
								<button title="Play" class="btn btn-success btn-sm" id="play" type="button" data-toggle="tooltip"><span class="fa fa-play"></span></button>
								<button title="Pause" class="btn btn-warning btn-sm" id="pause" type="button" data-toggle="tooltip"><span class="fa fa-pause"></span></button>
								<button title="Stop streams" class="btn btn-danger btn-sm" id="stop" type="button" data-toggle="tooltip"><span class="fa fa-stop"></span></button>
							 </div>
						</div>
					</div>
					<div class="panel-body text-center">
						<div class="col-md-6 float-left">
							<div class="well" style="position: relative;display: inline-block;">
								<canvas width="320" height="240" id="webcodecam-canvas"></canvas>
								<div class="scanner-laser laser-rightBottom" style="opacity: 0.5;"></div>
								<div class="scanner-laser laser-rightTop" style="opacity: 0.5;"></div>
								<div class="scanner-laser laser-leftBottom" style="opacity: 0.5;"></div>
								<div class="scanner-laser laser-leftTop" style="opacity: 0.5;"></div>
							</div>
							<div class="well hidden" style="width: 100%;">
								<label id="zoom-value" width="100">Zoom: 2</label>
								<input id="zoom" onchange="Page.changeZoom();" type="range" min="10" max="30" value="20">
								<label id="brightness-value" width="100">Brightness: 0</label>
								<input id="brightness" onchange="Page.changeBrightness();" type="range" min="0" max="128" value="0">
								<label id="contrast-value" width="100">Contrast: 0</label>
								<input id="contrast" onchange="Page.changeContrast();" type="range" min="0" max="64" value="0">
								<label id="threshold-value" width="100">Threshold: 0</label>
								<input id="threshold" onchange="Page.changeThreshold();" type="range" min="0" max="512" value="0">
								<label id="sharpness-value" width="100">Sharpness: off</label>
								<input id="sharpness" onchange="Page.changeSharpness();" type="checkbox">
								<label id="grayscale-value" width="100">grayscale: off</label>
								<input id="grayscale" onchange="Page.changeGrayscale();" type="checkbox">
								<br>
								<label id="flipVertical-value" width="100">Flip Vertical: off</label>
								<input id="flipVertical" onchange="Page.changeVertical();" type="checkbox">
								<label id="flipHorizontal-value" width="100">Flip Horizontal: off</label>
								<input id="flipHorizontal" onchange="Page.changeHorizontal();" type="checkbox">
							</div>
						</div>
						<div class="col-md-6 float-left">
							<div class="thumbnail hidden" id="result">
								<div class="well" style="overflow: hidden;">
									<img width="320" height="240" id="scanned-img" src="">
								</div>
								<div class="caption">
									<h3>Scanned result</h3>
									<p id="scanned-QR"></p>
								</div>
							</div>
						</div>
					</div>
					
			</div>
			</div>
				<div class="vta-ov">
				<table id="'.$cn.'" class="vta-container"></table>
				</div>
			</div>
			';
		}
		elseif(strpos($cn,'_vsa'))
		{
			$my_cn = str_replace('_vsa',"",$cn);
			//echo 'IM HERE IN IDR';
			$option_table = "tbl_".$my_cn;
			$my_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
				<select multiple="multiple" d class="form-control vta isr" data-table="'.$my_cn.'" data-target="'.$cn.'" name="'.$cn.'[]">';
				if($my_val!=""){
					$array = str_replace('-',',',$my_val);
					$option_query = select_db($option_table,"*","","(id IN (".$array."))",2);
					//echo $option_query;
					$result_string .= '<option value="0"> None</option>';
					while($row_option = mysqli_fetch_array($option_query))
					{
						$id 				= $row_option['id'];
						$display_name_str 	= $row_option['display_name_str'];
						$selected = "selected";
						$result_string .= '<option value="'.$id.'" '.$selected.'>'.utf8_decode($display_name_str.(isset($row_option[2]) && strlen($row_option[2])>3?' - ('.$row_option[2].')':'')).'</option>';
					}
				}
				$my_string .= $result_string;
			$my_string .= 
			'</select>
				<div class="vta-ov">
				<table id="'.$cn.'" class="vta-container"></table>
				</div>
			</div>
			';
		}
		elseif(strpos($cn,'_vta'))
		{
			
			$my_cn = str_replace('_vta',"",$cn);
			//echo 'IM HERE IN IDR';
			$option_table = "tbl_".$my_cn;
			$my_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
				<select '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' multiple="multiple" class="form-control vta" data-target="'.$cn.'" name="'.$cn.'[]">';
				$my_string .= get_options_array($option_table,$my_val,$table);
			
			$my_string .= 
			'</select>
				<div class="vta-ov">
				<table id="'.$cn.'" class="vta-container"></table>
				</div>
			</div>
			';
		}
		elseif(strpos($cn,'_arr'))
		{
			$my_cn = str_replace('_arr',"",$cn);
			$option_table = "tbl_".$my_cn;
			$my_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
				<select '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' multiple="multiple" class="form-control" name="'.$cn.'[]">';
				$my_string .= get_options_array($option_table,$my_val,$table);
			
			$my_string .= 
			'</select>
			</div>
			';
		}
		elseif(strpos($cn,'_crt'))
		{
			$my_cn = str_replace('_crt',"",$cn);
			$option_table = "tbl_".$my_cn;
			$my_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left cart">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
				<div class="cart_container" id="'.$cn.'">
					<input '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' type="hidden" class="ci_hidden" name="cart_value_'.$cn.'" id="cart_value_'.$cn.'" value="'.$my_val.'"/>
					';
					//echo 'im here';
					
					$my_string .= '
					<div class="cart_item cart_selector"" id="ci_'.$cn.'">
						<div class="ci_name" id="cn_'.$cn.'">
							<select class="form-control" id="cs_'.$cn.'" name="'.$cn.'">';
								$my_string .= get_options($option_table,$my_val,$table);
								$my_string .= 
							'</select>
						</div>
						<div class="ci_qty"><input id="ci_q_'.$cn.'" type="number" name="" value="1" min="1" max="1000" /></div>
						<div class="ci_btn"><div class="btn btn-success crt_add" data-target="'.$cn.'"> <i class="fa fa-plus"></i></div></div>
					</div>';
					
					if(isset($my_val)){
						$crt_array = explode(',',$my_val);
						foreach ($crt_array as $item) {
							if($item!= ""){
								$crt_item = explode('-',$item);
								$crt_item_id = $crt_item[0];
								$crt_item_qty = $crt_item[1];
								$ci_name = get_value_condition("display_name_str",$option_table,"id = " . $crt_item_id);
								$ci_qty = $crt_item_qty;
								$append_val = $crt_item_id . "-" . $crt_item_qty . ",";
								//echo $append_val . '=append_val';
								$generated_item = '<div class="cart_item"><div class="ci_name">'.$ci_name.'</div><div class="ci_qty">'.$crt_item_qty.'</div><div class="ci_delete btn btn-danger" data-delval="'.$append_val.'" data-target="'.$cn.'"> <i class="fa fa-trash"></i></div></div>';
								
								$my_string .= $generated_item;
								//echo "<li>$ci_name - $ci_qty</li>";
							}
							
						}
						//echo $my_val;
						
					}
					$my_string .= '
				</div>
				
			</div>
			';
		}
		
		elseif(strpos($cn,'_cdr'))
		{
			$my_cn = str_replace('_cdr',"",$cn);
			$cdr_table = "tbl_".$my_cn;
			
			$option_id = 0;
			$x_cor = 0;
			$y_cor = 0;
			if(isset($my_val))
			{
			$cdr_val = explode(",", $my_val);
			$option_id = $cdr_val[0];
			$x_cor = $cdr_val[1];
			$y_cor = $cdr_val[2];
			}
			
			$my_field = get_img_field($cdr_table);
			$my_img = get_img($cdr_table,$id);
			$my_string = 
			'<div class="row">
				<div class="col-md-4 col-sm-12">
					<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">
					<label>'.ucwords($my_field).'</label>
					<select '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' class="form-control" id="scdr" name="'.$cn.'" data-img="'.$my_img.'" data-field="'.strtolower($my_field).'">';
					$my_string .= get_imgs($cdr_table,$option_id);
					$my_string .= 
				'	</select>
					</div>
					<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">
					<label>'.ucwords($my_field).' X Coordinate</label>
					<input id="x_coordinate" required class="form-control" type="text" name="'.$cn.'_x" value="'.$x_cor.'"/>
					</div>
					<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">
					<label>'.ucwords($my_field).' Y Coordinate</label>
					<input id="y_coordinate" required class="form-control" type="text" name="'.$cn.'_y" value="'.$y_cor.'"/>
					</div>
					</div>
			';
			
			$my_string .= 
			'<div class="col-md-8 col-sm-12">
				<img id="cdr" src="uploads/'.$my_cn.'/'.$my_val.'"/>
				<canvas id="myCanvas" width="100%" height="auto"></canvas>
			</div>
			';
			$my_string .= 
			'</div>
			';
		}
		elseif(strpos($cn,'_str'))
		{
			$my_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
				<input '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' required class="form-control" type="text" name="'.$cn.'" value="'.$my_val.'"/>
			</div>
			';
			
		}
		elseif(strpos($cn,'_psw'))
		{
			$my_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
				<input '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' required class="form-control" type="password" name="'.$cn.'" value="'.$my_val.'"/>
			</div>
			';
			
		}
		elseif(strpos($cn,'_col'))
		{
			$my_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">
				<label>'.$my_field.' color</label>
				<input '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' required class="form-control color-control" type="color" name="'.$cn.'" value="'.$my_val.'"/>
			</div>
			';
			
		}
		elseif(strpos($cn,'_bol'))
		{
			$checked = "";
			if($my_val==1)
			{
				$checked = "checked";
			}
			$my_string = 
			'<div class="f-bol  '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' form-group col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
				<input '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' class="form-control cbox" type="checkbox" name="'.$cn.'" value="'.$my_val.'" '.$checked.'/>
			</div>
			';
			
		}
		elseif(strpos($cn,'_qrc'))
		{
			$checked = "";
			$my_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
				<input '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' class="form-control qrc-text" type="text" name="'.$cn.'" value="'.$my_val.'"/>
				';
					$my_string .= '<div class="qrc-container">
					<div class="qrc-btn btn btn-success" data-target="#qr-'.$cn.'"> Generate QR Code</div>
					<div id="qr-'.$cn.'" class="qrc"></div>
					</div>';
				
			$my_string .= '
			</div>
			';
			
		}
		elseif(strpos($cn,'_int'))
		{
			$my_string = '<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
					<input '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' required class="form-control" type="number" name="'.$cn.'" value="'.$my_val.'"/>
				</div>
			';
		}
		elseif(strpos($cn,'_lng'))
		{
			$my_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
				<textarea rows="3" required class="form-control" name="'.$cn.'">'.$my_val.'</textarea>
			</div>
			';
		}
		elseif(strpos($cn,'_rch'))
		{
			$my_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
				<textarea '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' rows="15" class="form-control myNicEditor nice-txt" name="'.$cn.'">'.$my_val.'</textarea>
			</div>
			';
		}
		elseif(strpos($cn,'_gal'))
	{
		$img_field = strtolower(str_replace("_gal","",$my_field));
		if (!file_exists("uploads/".strtolower($my_field))) {
		mkdir("uploads/".strtolower($my_field), 0777, true);
		}
		if (!file_exists("uploads/".strtolower($my_field)."/thumbs")) {
		mkdir("uploads/".strtolower($my_field)."/thumbs", 0777, true);
		}
		$my_string = '<div class="gallery form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
        <label>Upload '.$my_field.' Gallery (Multiple Upload)</label>
        <div class="input-group">
            <span class="input-group-btn">
                <span class="btn btn-default btn-file">
                    Browse… <input id="file-input" class="val-clr" type="file" multiple name="'.$cn.'[]" >
                </span>
            </span>
        </div>
        <button class="btn btn-warning button-clear" id="btn-clear">Clear</button>
        ';
        
        $my_string .= '
        <div id="preview"></div>
        ';

            // Image extensions
            $image_extensions = array("png","jpg","jpeg","gif");

            // Target directory
            $dir = "uploads/".strtolower($my_field);
			
            if (is_dir($dir)){
                
                if ($dh = opendir($dir)){
                    $count = 1;

                    // Read files
					$y = 0;
                    while (($file = readdir($dh)) !== false){
						
                        if($file != '' && $file != '.' && $file != '..'){
                            
                            // Thumbnail image path
							
                            $thumbnail_path = "uploads/".strtolower($my_field)."/".$file;

                            // Image path
                            $location_path = "uploads/".strtolower($my_field)."/";
                            $image_path = "uploads/".strtolower($my_field)."/".$file;
                            
                            $thumbnail_ext = pathinfo($thumbnail_path, PATHINFO_EXTENSION);
                            $image_ext = pathinfo($image_path, PATHINFO_EXTENSION);
                            
                            // Check its not folder and it is image file
                            
                            
                            if(!is_dir($image_path) && 
                                in_array($thumbnail_ext,$image_extensions) && 
                                in_array($image_ext,$image_extensions)){
									
								//echo $image_path . " | " . $my_val . "<br/>";
								 
								 
                                if(strpos($image_path,$my_val)){
                                   
                                        //echo $y.'<br/>';
                                        //$image_path_wnum = $image_path; //Check All FIles
                                        
                                        for($x=1;$x<=2;$x++){
                                            
                                            if($x == 1){
                                                $exten = '.jpg';
                                            }elseif($x==2){
                                                $exten = '.png';
                                            }
                                            
                                            $image_path_wnum = $location_path.$my_val.$y.$exten; //In Order
    									    if(file_exists($image_path_wnum)){
        									    $my_string .= '
                                                <!-- Image -->
                								<div class="gal-item" id="gal'.$y.'">
                								<div class="clear" data-target="gal'.$y.'" data-targetfile="'. $image_path_wnum .'"><i class="fa fa-times" aria-hidden="true"></i></div>
                                                <a class="val-clr" href="'. $image_path_wnum .'?v='.date('s').'">
                                                    <img class="val-clr" src="'. $image_path_wnum .'?v='.date('s').'">
                                                </a>
                								</div>';
    									    
    									    }else{
    									        continue;
    									    }
    									   //echo $image_path_wnum.'<br/>';
                                        }
        								 //$arr = array($thumbnail_path);
        								 //print_r($arr);
									    
        								 //echo $thumbnail_path."<br/>";
                                        $y=$y+1;
                                        
                                }
                                $count++;
                            }
                        }
                            
                    }
                    closedir($dh);
                }
            }
			$my_string .= '</div>';
	}
		elseif(strpos($cn,'_pct'))
		{
			$my_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
				<input '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' required class="form-control" max="100" min="0" type="number" name="'.$cn.'" value="'.$my_val.'"/><span class="pct">%</span>
			</div>
			';
		}
		elseif(strpos($cn,'_url'))
		{
			$my_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
				<input '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' required class="form-control" type="url" name="'.$cn.'" value="'.$my_val.'"/>
			</div>
			';
		}
		elseif(strpos($cn,'_eml'))
		{
			$my_string = 
			'<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
				<input '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' required class="form-control" type="email" name="'.$cn.'" value="'.$my_val.'"/>
			</div>
			';
		}
		elseif(strpos($cn,'_dat'))
		{
			$my_string = '<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
					<input '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' required class="form-control" type="date" name="'.$cn.'" value="'.$my_val.'"/>
				</div>
			';
			
		}
		elseif(strpos($cn,'_dtm'))
		{
			$my_string = '<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
					<input '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' required class="form-control" type="datetime" name="'.$cn.'" value="'.$my_val.'"/>
				</div>
			';
			
		}
		elseif(strpos($cn,'_dta'))
		{
			$cur_val = $my_val;
			$date_now = date("Y-m-d");
			$new_val = (isset($my_val)?$cur_val:$date_now);
			
			$my_string = '<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
					<input readonly class="form-control  disabled" type="date" name="'.$cn.'" value="'.$new_val.'"/>
				</div>
			';
			
		}
		elseif(strpos($cn,'_dec'))
		{
			$my_string = '<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
					<input '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' required class="form-control" type="number" step="0.01" name="'.$cn.'" value="'.$my_val.'"/>
				</div>
			';
		}
		elseif(strpos($cn,'_cur'))
		{
			$my_string = '<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
					<input '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' required class="form-control" type="number" step="0.01" name="'.$cn.'" value="'.$my_val.'"/>
				</div>
			';
			
		}
		elseif(strpos($cn,'_img'))
		{
			if (!file_exists("uploads/".strtolower($my_field))) {
			mkdir("uploads/".strtolower($my_field), 0777, true);
			}
			if (!file_exists("uploads/".strtolower($my_field)."/thumbs")) {
			mkdir("uploads/".strtolower($my_field)."/thumbs", 0777, true);
			}
			$my_string = '<div class="form-group '.(strpos($update_fields_str,$cn)||($update_fields_str=="*")?"":"readonly").' col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
			<div class="input-group">
				<span class="input-group-btn">
					<span class="btn btn-default btn-file">
						Browse… <input type="file" class="imgInp" data-txt="txt-'.$cn.'" data-target="'.$cn.'">
					</span>
				</span>
				<input type="text" class="form-control" readonly>
			</div>
			<input type="hidden" id="txt-'.$cn.'" name="'.$cn.'">
			';
			//check if has val
			if($my_val == ""){
				$image_src = 'image/drag.png';
			}else{
				$image_src = 'uploads/'.strtolower($my_field).'/'.$my_val;
			}	
			
				$my_string .= '
				<div class="gal-item" id="'.substr($my_val, 0, -4).'">
				    <div class="clear" data-target="'.substr($my_val, 0, -4).'" data-targetfile="'. $image_src .'"><i class="fa fa-times" aria-hidden="true"></i></div>
				    <img class="form-logo" id="'.$cn.'" src="'.$image_src.'?'.time().'"/>
				</div>
		        </div>';
		}
		elseif(strpos($cn,'_log'))
		{
			if (!file_exists("uploads/logo/".$my_field)) {
			mkdir("uploads/logo/".$my_field, 0777, true);
			}
			if (!file_exists("uploads/logo/".strtolower($my_field)."/thumbs")) {
			mkdir("uploads/logo/".strtolower($my_field)."/thumbs", 0777, true);
			}
			$my_string = '<div id="'.linkerize($my_field).'" class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left">';
				if($cc!="NAN"){
					$my_string .= '<label>'.$cc.'</label>';
				}else{
					$my_string .= '<label>'.$my_field.'</label>';
				}
				$my_string .='
				<div class="input-group">
					<span class="input-group-btn">
						<span class="btn btn-default btn-file">
							Browse… <input type="file" class="imgInp" data-txt="txt-'.$cn.'" data-target="'.$cn.'">
						</span>
					</span>
				<input type="text" class="form-control" readonly>';
			//check if has val
			if($my_val == ""){
				$image_src = 'image/drag.png';
			}else{
				$image_src = 'uploads/logo/'.strtolower($my_field).'/'.$my_val;
			}	
			
				$my_string .= '<img class="form-logo" id="'.$cn.'" src="'.$image_src.'?'.time().'"/>
				</div></div>';
		}
		else
		{
			
		}
		echo $my_string;
	}
	function load_data($table,$limit)
	{
		include ("fn_connect.php");
		$generated_form = ''; 
		if($limit > 0)
		{
			$my_limit = "LIMIT " . $limit;
		}
		else
		{
			$my_limit = "";
		}
		$sql_string = "SELECT COLUMN_NAME as cn, COLUMN_COMMENT as cc  FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table' AND TABLE_SCHEMA = '".$database_name."' ORDER BY ORDINAL_POSITION ASC " . $my_limit;
		//echo $sql_string;
		$query = mysqli_query($con,$sql_string);
		return $query;
		
	}
	function update_db($table_name, $fields, $condition, $return)
	{
		include ("fn_connect.php");
		$sql_string = "UPDATE $table_name SET $fields WHERE $condition";
		if(strpos($sql_string,", WHERE"))
		{
			$sql_string = str_replace(", WHERE"," WHERE",$sql_string);
		}
		$query = mysqli_query($con,$sql_string);
		if($return==1)
		{
			return $sql_string;
		}
		elseif($return==2)
		{
			
			return $query;
		}
		else
		{
			return 0;
		}
	}
	function delete_db($table_name, $condition, $return)
	{
		include ("fn_connect.php");
		$sql_string = "DELETE FROM $table_name WHERE $condition";
		$query = mysqli_query($con,$sql_string);
		if($return==1)
		{
			return $sql_string;
		}
		elseif($return==2)
		{
			return $query;
		}
		else
		{
			return 0;
		}
	}
	function get_user($username, $return)
	{
		include ("fn_connect.php");
		$user_id = $_SESSION['manager'];
		$sql_string = "SELECT * FROM tbl_users WHERE id = '$user_id'";
		$query = mysqli_query($con,$sql_string);
		if($return==1)
		{
			return $sql_string;
		}
		elseif($return==2)
		{
			return $query;
		}
		else
		{
			return 0;
		}
	}
	
	function insert_db($table_name, $fields, $values, $return)
	{
		include ("fn_connect.php");
		$sql_string = "INSERT INTO $table_name ($fields) VALUES ($values)";
		mysqli_query($con,$sql_string);
		if($return==1)
		{
			return $sql_string;
		}
		elseif($return==2)
		{
			return mysqli_insert_id($con);
		}
		else
		{
			return 0;
		}
	}
	function select_db($table_name, $fields, $join, $condition, $return)
	{
		include ("fn_connect.php");
		$sql_string = "SELECT $fields FROM $table_name $join WHERE $condition";
		if(isset($_SESSION["admin_id"])){
			
			$admin_id = $_SESSION["admin_id"];
			$sql_string = str_replace("'\$admin_id'","'".$admin_id."'",$sql_string);
		}
		if(isset($_SESSION["admin_branch_idr"])){
			//echo 'im here';
			$admin_branch_idr = $_SESSION["admin_branch_idr"];
			$sql_string = str_replace("'\$admin_branch_idr'","'".$admin_branch_idr."'",$sql_string);
		}
		
		//echo $sql_string;
		//echo 'im here';
		//echo $admin_branch_idr;
		$query = mysqli_query($con,$sql_string);
	
		if(!$query)
		{
			
			header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
			echo mysqli_error($con);
			echo '<script>//alert("'.$sql_string .'");</script>';
			$message = $sql_string .'
			<style>
			.banner-wrapper{
				display:none;
			}
			.container {
			background: #222;
			width: 100%;
			height: 100vh !important;
			margin: 0;
			padding: 0;
			padding-top: 60px;
			}
	
	.container {}
			body {
				margin: 0;
				text-align: center;
			}
			</style>		<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="error-template">
					<img class="icon-logo" src="http://1devsinc.com/admin/uploads/logo/logo/detail-01.png" alt="1Devs Logo">
					<h1>Oops!</h1>
					<h2>
						404 Not Found (select_db)</h2>
					<div class="error-details">
						Sorry, an error has occured, Requested page not found!
					</div>
					<div class="error-actions">
						<a href="http://1devsinc.com" style="padding:10px 15px; color:#fff; border-radius:5px;"><span class="fa fa-home"></span>
							Take Me Home </a>
					</div>
				</div>
			</div>
		</div>
	</div>
	';
		 die($message);
		}
		
		if($return==1)
		{
			return $sql_string;
		}
		elseif($return==2)
		{
			if($query)
			{
			return $query;
			}
			else
			{
				return 0;
			}
		}
		else
		{
			return 0;
		}
	}
	function select_query($myquerys, $dat_from, $dat_to, $return)
	{
		include ("fn_connect.php");
		$sql_string = "$myquerys";
		$sql_string = str_replace("'\$date_from'","'".$dat_from."'",$sql_string);
		$sql_string = str_replace("'\$date_to'","'".$dat_to."'",$sql_string);
		if(isset($_SESSION["admin_id"])){
			$admin_id = $_SESSION["admin_id"];
			$sql_string = str_replace("'\$admin_id'","'".$admin_id."'",$sql_string);
		}
		if(isset($_SESSION["admin_branch_idr"])){
			$admin_branch_idr = $_SESSION["admin_branch_idr"];
			$sql_string = str_replace("'\$admin_branch_idr'","'".$admin_branch_idr."'",$sql_string);
		}
		$query = mysqli_query($con,$sql_string);
		
		if(!$query)
		{
			header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
			echo $sql_string;
			$message = '
			<style>
			.banner-wrapper{
				display:none;
			}
			.container {
			background: #222;
			width: 100%;
			height: 100vh !important;
			margin: 0;
			padding: 0;
			padding-top: 60px;
			}
	
	.container {}
			body {
				margin: 0;
				color: #fff;
				text-align: center;
			}
			</style>		<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="error-template">
					<img class="icon-logo" src="http://1devsinc.com/admin/uploads/logo/logo/detail-01.png" alt="1Devs Logo">
					<h1>Oops!</h1>
					<h2>
						404 Not Found (select_db)</h2>
					<div class="error-details">
						Sorry, an error has occured, Requested page not found!
					</div>
					<div class="error-actions">
						<a href="http://1devsinc.com" style="padding:10px 15px; color:#fff; border-radius:5px;"><span class="fa fa-home"></span>
							Take Me Home </a>
					</div>
				</div>
			</div>
		</div>
	</div>
	';
		 die($message);
		}
		
		if($return==1)
		{
			return $sql_string;
		}
		elseif($return==2)
		{
			if($query)
			{
			return $query;
			}
			else
			{
				return 0;
			}
		}
		else
		{
			return 0;
		}
	}
	
	function alert($message, $type)
	{
		$return_message = '<div class="alert alert-'.$type.'">'.$message.'</div>';
		return $return_message;
	}
	
	function get_sum($table_name, $fields, $join, $condition, $return)
	{
		include ("fn_connect.php");
		$my_sum = 0;
		$sql_string = "SELECT SUM($fields) as my_sum FROM $table_name $join WHERE $condition";
		$query = mysqli_query($con,$sql_string);
		while($row = mysqli_fetch_array($query))
		{
			$my_sum = $row['my_sum'];
		}
		if($return==1)
		{
			return $sql_string;
		}
		elseif($return==2)
		{
			return $my_sum;
		}
		else
		{
			return 0;
		}
	}
	
	function monetarize($amount)
	{
		return '₱ ' . number_format($amount, (2) ? 2 : 0, '.', ',');
		
	}
	
	?>
