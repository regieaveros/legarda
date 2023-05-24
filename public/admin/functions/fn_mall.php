<?php
function update_mall()
{
	include 'fn_connect.php';
	$data_array = '{
	"mapwidth": "1000",
	"mapheight": "600",
	"categories": [
		';
		$sql = mysqli_query($con,"SELECT * FROM tbl_category");
		$md_count = mysqli_num_rows($sql); // count the output amount
		if ($md_count > 0) 
		{
			while($row = mysqli_fetch_array($sql))
			{ 
				$id = $row["id"];
				$category_name = $row["display_name_str"];
				
				$data_array .=
				'{
					"id": "c'.$id.'",
					"title": "'.$category_name.'",
					"color": "#00a88f",
					"show": "false"
				}';
				$md_count = $md_count - 1;
				if($md_count !=0)
				{
					$data_array .= ',';
				}
			}
		}
	
	$data_array .= '
	],
	"levels": [';
	
	$f_sql = mysqli_query($con,"SELECT * FROM tbl_floor");
	$f_count = mysqli_num_rows($f_sql); // count the output amount
	if ($f_count > 0) 
	{
		while($f_row = mysqli_fetch_array($f_sql))
		{ 	
			$f_id = $f_row["id"];
			$display_name_str = $f_row["display_name_str"];
			$floor_name_str = $f_row["floor_name_str"];			
			$floorplan_img = $f_row["floorplan_img"];	
			
			$cdr_val = explode(".", $floorplan_img);
			$my_val = $cdr_val[0];						
			$data_array .='
			{
			"id": "'.$my_val.'",
			"title": "'.$floor_name_str.'",
			"map": "admin/uploads/floorplan/'.$floorplan_img.'",
			"minimap": "admin/uploads/floorplan/'.$floorplan_img.'",
			"locations": [
			';
				$sql = mysqli_query($con,"SELECT * FROM tbl_store WHERE floor_cdr LIKE '".$f_id."-%'");
				$md_count = mysqli_num_rows($sql); // count the output amount
				if ($md_count > 0) 
				{
					while($row = mysqli_fetch_array($sql))
					{ 
						$md_id = $row["display_name_str"];
						$logo_img = $row["logo_img"];
						$store_name_str = $row["store_name_str"];
						$about_str = $row["about_str"];
						$description_lng = $row["description_lng"];
						$category_idr = $row["category_idr"];
						$floor_cdr = $row["floor_cdr"];
						$orientation = $row["orientation_idr"];
						$type = $row["type_idr"];
						
						if(isset($floor_cdr))
						{
						$cdr_val = explode(",", $floor_cdr);
						$my_val = $cdr_val[0];
						$x = $cdr_val[1];
						$y = $cdr_val[2];
						}
						$data_array .= '
						{
						"id": "'.$md_id.'",
						"title": "'.$store_name_str.'",
						"about": "'.$about_str.'",
						"description": "'.$description_lng.'",
						"category": "c'.$category_idr.'",
						"thumbnail": "admin/uploads/logo/'.$logo_img.'",
						"orientation": "'.$orientation.'",
						"type": "'.$type.'",
						"x": "'.$x.'",
						"y": "'.$y.'"
						}
						'
						;
						$md_count = $md_count-1;
						if($md_count >=1)
						{
							$data_array .= ',';
						}
					}
				}
		
		$data_array .= 
		']
		}';
			$f_count = $f_count - 1;
			if($f_count !=0)
			{
				$data_array .= ',';
			}
		}
	
	$data_array .= 
		']
		}';
		}
	$my_json = '../map/mall.json';
	unlink($my_json);
	
	$my_file = 'mall.txt';
	$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
	$data = $data_array;
	fwrite($handle, $data);
	
	$data2 = json_decode(file_get_contents('mall.txt'), true);
	$fp = fopen('../map/mall.json', 'w'); 
	//fwrite($fp, json_encode($data2,JSON_UNESCAPED_SLASHES)); 
	if(!fwrite($fp, json_encode($data2,JSON_UNESCAPED_SLASHES))) 
	{ 
		die('Error : File Not Opened. ' . mysqli_error());
	 } 
	 else
	 { 
	 //echo $data_array;
	 $message =  '<div class="alert alert-success"> Mall Directory Successfully Updated!</div>';
	 } 
	 fclose($fp);
						
}
?>