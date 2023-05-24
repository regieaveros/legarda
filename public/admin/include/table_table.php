

<?php
if ( isset( $_GET[ "table" ] ) )
    {
		
    
    $table         = $_GET[ "table" ];
    $table_name    = "tbl_" . $_GET[ "table" ];
    $table_details = select_db( "tbl_table", '*', "", "(display_name_str='" . $table_name . "')", 2 );
    $table_detail  = mysqli_fetch_array( $table_details );
    $table_id      = $table_detail[ "id" ];
	if(!isset($table_id)){
		$table_id = 0; // initialization
	}
	$datatable      = get_value_condition( "datatable_bol", "tbl_table", "id=" . $table_id );
    $group_id      = get_value_condition( "group_idr", "tbl_table", "id=" . $table_id );
    $fa_icon       = get_value_condition( "fa_icon_str", "tbl_group", "id=" . $group_id );
    $query         = load_data( $table_name, $table_detail[ "column_limit_int" ] );
	
	
	if(isset($table_detail["row_limit_int"])){
		$limit = $table_detail["row_limit_int"];
	}else{
		$limit = 10;
	}
	//echo $limit;
	
		if(isset($_GET["page"])){
				$page = addslashes(strip_tags($_GET["page"]));
			}else{
				$page = 1;
			}
		if($page == 1){
			$offset = 0;
		}else{
			$offset = ($page-1) * $limit;
		}
    } //isset( $_GET[ "table" ] )
$query       = load_data( $table_name, $table_detail[ "column_limit_int" ] );
$my_table    = "";
$field_count = mysqli_num_rows( $query ) - 1;
$my_table .= "<thead><tr>";


$update_bol = get_value_condition("update_bol","tbl_admin_tables","(admin_type_idr=".$admin["admin_type_idr"].") AND (table_idr = ".$table_id.")");
$delete_bol = get_value_condition("delete_bol","tbl_admin_tables","(admin_type_idr=".$admin["admin_type_idr"].") AND (table_idr = ".$table_id.")");
$admin_type_idr = get_value_condition("admin_type_idr","tbl_admin","username_str = '". $_SESSION["manager"]."'");
			//get admin type
			
			$show_fields_str = get_value_condition("show_fields_str","tbl_admin_tables","(admin_type_idr=".$admin_type_idr.") AND 	(table_idr = ".$table_id.")");
			$sfs_array = "";
			
$x = 0;
$my_table .= (($update_bol != "" && $update_bol != 0) || ($delete_bol != "" && $delete_bol != 0))?'<th>Action</th>':"";
		
while ( $row = mysqli_fetch_array( $query ) )
    {
    $cn       = $row[ 'cn' ];
	
	if($show_fields_str != "*" && $show_fields_str != NULL){
		$sfs_array = explode(",",$show_fields_str );
		//echo $x;
		//echo $show_fields_str;
		if (!in_array($x, $sfs_array)){
			//echo $cn;
			$x ++;
			continue;
		}else{
			$x++;
		}
		
	}
	//echo $show_fields_str;
	
	
	if($row['cc']!=NULL && strlen($row['cc']) <=50){
		$cc = $row['cc'];
	}else{
		$cc = "NAN";
	}
    $cn_field = str_replace( "_", " ", $cn );
    $cn_field = ucwords( $cn_field );
    if ( $cn != "id" )
        {
			if($cc!="NAN"){
				$my_field = $cc;
			}else{
			if ( $cn == "display_name_str" )
				{
				$my_field = $table;
				} //$cn == "display_name_str"
			elseif ( strpos( $cn, '_psw' ) )
				{
				continue;
				} //strpos( $cn, '_psw' )
			
			else
				{
				$my_field = substr( $cn_field, 0, -4 );
				}
			} //$cn != "id"
		}
    else
        {
        $my_field = $cn;
        }
    $my_table .= '<th>' . $my_field . (strpos($cn,"_img")?' IMAGE': '') . (strpos($cn,"_col")?' Color': '') .'</th>';
    } //$row = mysqli_fetch_array( $query )
	
	


$my_table .= (($update_bol != "" && $update_bol != 0) || ($delete_bol != "" && $delete_bol != 0))?'<th>Action</th>':"";
$my_table .= "</tr></thead>";

		
		$filter_str = "1=1";
		
		if(null !==(get_value_condition("filter_str","tbl_admin_tables","(admin_type_idr=".$admin["admin_type_idr"].") AND (table_idr = ".$table_id.")")))
		{
			$filter_str = get_value_condition("filter_str","tbl_admin_tables","(admin_type_idr=".$admin["admin_type_idr"].") AND (table_idr = ".$table_id.")");
			
			if(strlen($filter_str)==0){
				$filter_str = "1=1";
			}else{
				//echo 'FALSE' . $filter_str ."S";
			}
			
		}else{
			$filter_str = "1=1";
			
		}
		
		//echo $filter_str;
		$descending_bol = 0;
		
		if(null !==(get_value_condition("descending_bol","tbl_admin_tables","(admin_type_idr=".$admin["admin_type_idr"].") AND (table_idr = ".$table_id.")"))){
			$descending_bol = get_value_condition("descending_bol","tbl_admin_tables","(admin_type_idr=".$admin["admin_type_idr"].") AND (table_idr = ".$table_id.")");
			//echo $descending_bol . ' im here';
		}else{
			$descending_bol = 0;
		}
		
		if(isset($_GET["q"])){
			$q = $_GET["q"];
			$search_query = "";
			$s_query = load_data( $table_name, $table_detail[ "column_limit_int" ] );	
			$s_row_count = mysqli_num_rows($s_query);
			
			//echo $s_row_count;
			$s_count = 0;
			while ( $s_row = mysqli_fetch_array( $s_query ) ){
				$search_query .= $s_row[ 'cn' ] . " LIKE '%".$q."%'";
				if($s_count < $s_row_count - 1){
					$search_query .= " OR ";
				}
				$s_count ++;
			}
		}else{
			$search_query = "1=1";
		}
		//echo 'im here';
		$additional_filters = "1=1";
		if(isset($_GET["filter"])){
			foreach($_GET as $key => $value){
			   //echo 'Key = ' . $key . '<br />';
			   //echo 'Value= ' . $value;
			   if($key != "table" && $key !="filter"){
				   if($value == "All"){
					continue;  
					}
				   	$filters = $key . " = '" . $value . "'";
					$additional_filters .= " AND ".$filters;
				}
			}
		}
		
		
		$table_query = select_db( $table_name, '*', "", "(".$search_query." AND ".($filter_str!="1=1"?$filter_str:"1=1")." AND ".$additional_filters.") ORDER BY id ".($descending_bol==0?"ASC":"DESC"),2);
$total_count = mysqli_num_rows($table_query);
		
    	
		
		if(isset($_GET["debug"])){
			$table_query = select_db( $table_name, '*', "", "(".$search_query." AND ".($filter_str!="1=1"?$filter_str:"1=1")." AND ".$additional_filters.") ORDER BY id ".($descending_bol==0?"ASC":"DESC") . " LIMIT ".$limit." OFFSET ".$offset,1);
			echo $table_query;
		}else{
			$table_query = select_db( $table_name, '*', "", "(".$search_query." AND ".($filter_str!="1=1"?$filter_str:"1=1")." AND ".$additional_filters.") ORDER BY id ".($descending_bol==0?"ASC":"DESC") . " LIMIT ".$limit." OFFSET ".$offset,2);
		}

		$page_numbers = intdiv($total_count, $limit) + 1;
$from_count = $offset + 1;
$to_count = $offset + $limit;
if($to_count > $total_count){
	$to_count = $total_count;
}

$ctr     = 0;
$ctr_val = 1;

if ( $table_query )
    {
    $table_count = mysqli_num_rows( $table_query );
    if ( $table_count != 0 )
        {
        while ( $row = mysqli_fetch_array( $table_query ) )
            {
				$data_id = $row[ 0 ];
				$data_table_name = str_replace( "tbl_", "", $table );
				
            if ( $ctr == 0 )
                {
                $my_table .= '<tr>';
                $ctr += 1;
                } //$ctr == 0
            elseif ( $ctr > $ctr - $field_count )
                {
                $ctr = 0;
                $my_table .= '</tr>';
                } //$ctr > $ctr - $field_count
			//Action Buttons
			
			if((($update_bol != "" && $update_bol != 0) || ($delete_bol != "" && $delete_bol != 0))){
				$my_table .= '<td>';
				if ( (get_value_condition("update_bol","tbl_admin_tables","(admin_type_idr=".$admin["admin_type_idr"].") AND (table_idr = ".$table_id.")")) == 1 )
                {
                $my_table .= '
          <a href="?table=' . $data_table_name . '&update&id=' . $data_id . '" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
    	     ';
                } //$table_detail[ "update_bol" ] == 1
            if ( (get_value_condition("delete_bol","tbl_admin_tables","(admin_type_idr=".$admin["admin_type_idr"].") AND (table_idr = ".$table_id.")")) == 1 )
                {
                $my_table .= '
          <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#delete_modal' . $data_id . '"><i class="fa fa-trash"></i></a>
    	     ';}
			 	$my_table .= '</td>';
			}
				
            for ( $x = 0; $x <= $field_count; $x++ )
                {
				$val     = $row[ $x ];
					
                
                
                $finfo   = mysqli_fetch_field_direct( $table_query, $x );
                $fname   = $finfo->name;
				$admin_type_idr = get_value_condition("admin_type_idr","tbl_admin","username_str = '". $_SESSION["manager"]."'");
			//get admin type
			
			$show_fields_str = get_value_condition("show_fields_str","tbl_admin_tables","(admin_type_idr=".$admin_type_idr.") AND 	(table_idr = ".$table_id.")");
			$sfs_array = "";
			
			//echo 'im here';
			
			if($show_fields_str != "*" && $show_fields_str != NULL){
				$sfs_array = explode(",",$show_fields_str );
				//echo $x;
				//echo $show_fields_str;
				if (!in_array($x, $sfs_array)){
					//echo $fname;
					continue;
				}
				
			}
				if($val == ""){
					$val = "NA";
				}
				
				$column_comment="";
				$column_comment = get_value_condition("column_comment","information_schema.columns","table_name = 'tbl_".$table."' AND column_name = '".$fname."'");
				if($column_comment!=""){
					$data_label = $column_comment;
				}else{
					$data_label = substr( str_replace( "_", " ", ucwords( $fname ) ), 0, -4 );
					//echo $fname;
				}
				
                if ( strpos( $fname, '_cur' ) )
                    {
                    $val = monetarize( $val );
                    $my_table .= '<td data-label="' . $data_label . '"


>' . $val . '</td>';
                    } //strpos( $fname, '_cur' )
                elseif ( strpos( $fname, '_idr' ) )
                    {
                    $my_cn     = str_replace( '_idr', "", $fname );
                    $rel_table = "tbl_" . $my_cn;
                    $my_table .= '<td data-label="' . $data_label . '"
><b class="data-idr" data-toggle="modal" data-target="#idrModal" data-table="'.str_replace("tbl_","",$rel_table).'" data-idr="'.$val.'">' . (get_relative( $rel_table, $val )?get_relative( $rel_table, $val ):"NA") . '</b></td>';
                    } //strpos( $fname, '_idr' )
				elseif ( strpos( $fname, '_vtb' ) )
                    {
                    $my_cn     = str_replace( '_vtb', "", $fname );
                    $rel_table = "tbl_" . $my_cn;
                    $my_table .= '<td data-label="' . $data_label . '"
><b class="data-idr" data-toggle="modal" data-target="#idrModal" data-table="'.str_replace("tbl_","",$rel_table).'" data-idr="'.$val.'">' . (get_relative( $rel_table, $val )?get_relative( $rel_table, $val ):"NA") . '</b></td>';
                    } //strpos( $fname, '_idr' )
				elseif ( strpos( $fname, '_vsb' ) )
                    {
                    $my_cn     = str_replace( '_vsb', "", $fname );
                    $rel_table = "tbl_" . $my_cn;
                    $my_table .= '<td data-label="' . $data_label . '"
><b class="data-idr" data-toggle="modal" data-target="#idrModal" data-table="'.str_replace("tbl_","",$rel_table).'" data-idr="'.$val.'">' . (get_relative( $rel_table, $val )?get_relative( $rel_table, $val ):"NA") . '</b></td>';
                    } //strpos( $fname, '_idr' )
                elseif ( strpos( $fname, '_psw' ) )
                    {
                    $ctr += 1;
                    continue;
                    } //strpos( $fname, '_psw' )
				elseif ( strpos( $fname, '_bol' ) )
                    {
                    	$my_table .= '<td>' . ($val==1?"Yes":"No") . '</td>';
					} //strpos( $fname, '_psw' )
				elseif ( strpos( $fname, '_arr' ) )
                    {
						$my_cn     = str_replace( '_arr', "", $fname );
						$rel_table = "tbl_" . $my_cn;
						$resulting_arr = "";
						$arr_array = explode('-',$val);
						foreach($arr_array as $id_arr){
							$resulting_arr .= '<div class="array-list"><b class="data-idr" data-toggle="modal" data-target="#idrModal" data-table="'.str_replace("tbl_","",$rel_table).'" data-idr="'.$id_arr.'">'.get_value_condition("display_name_str",$rel_table,"id='$id_arr'") .'</b></div>';
						}
                    	$my_table .= '<td>' . $resulting_arr . '</td>';
					}
				elseif ( strpos( $fname, '_vta' ) )
                    {
						$my_cn     = str_replace( '_vta', "", $fname );
						$rel_table = "tbl_" . $my_cn;
						$resulting_arr = "";
						$arr_array = explode('-',$val);
						foreach($arr_array as $id_arr){
							$resulting_arr .= '<div class="array-list"><b class="data-idr" data-toggle="modal" data-target="#idrModal" data-table="'.str_replace("tbl_","",$rel_table).'" data-idr="'.$id_arr.'">'.get_value_condition("display_name_str",$rel_table,"id='$id_arr'") .'</b></div>';
						}
                    	$my_table .= '<td>' . $resulting_arr . '</td>';
					}
				elseif ( strpos( $fname, '_vsa' ) )
                    {
						$my_cn     = str_replace( '_vsa', "", $fname );
						$rel_table = "tbl_" . $my_cn;
						$resulting_arr = "";
						$arr_array = explode('-',$val);
						foreach($arr_array as $id_arr){
							$resulting_arr .= '<div class="array-list"><b class="data-idr" data-toggle="modal" data-target="#idrModal" data-table="'.str_replace("tbl_","",$rel_table).'" data-idr="'.$id_arr.'">'.get_value_condition("display_name_str",$rel_table,"id='$id_arr'") .'</b></div>';
						}
                    	$my_table .= '<td>' . $resulting_arr . '</td>';
					}
				elseif ( strpos( $fname, '_frm' ) )
                    {
						$my_cn     = str_replace( '_frm', "", $fname );
						$rel_table = "tbl_" . $my_cn;
						$my_table .= '<td data-label="' . $data_label . '"><b class="data-idr" data-toggle="modal" data-target="#idrModal" data-table="'.str_replace("tbl_","",$rel_table).'" data-idr="'.$val.'">' . get_value_condition("display_name_str", $rel_table, "id=".$val) . '</b></td>';
					}  
                elseif ( strpos( $fname, '_rch' ) )
                    {
                    $my_cn = str_replace( '_rch', "", $fname );
                    $my_table .= '<td><a href="#" data-toggle="modal" data-target="#modal_content' . $data_id . '" class="btn btn-success"><i class="fa fa-eye"></i> View</a>
</a>
			';
                    $my_table .= '
<div id="modal_content' . $data_id . '" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
	  <h4 class="modal-title">Preview</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="container">' . $val . '</div>
      </div>
      <div class="modal-footer">
        <a type="button" class="btn btn-info" data-dismiss="modal">Close</a>
      </div>
    </div>

  </div>
</div>
</td>';
                    } //strpos( $fname, '_rch' )
                elseif ( strpos( $fname, '_cdr' ) )
                    {
                    $my_cn     = str_replace( '_cdr', "", $fname );
                    $arr_val   = explode( ",", $val );
                    $arr_val   = explode( "-", $arr_val[ 0 ] );
                    $val_id    = $arr_val[ 0 ];
                    $rel_table = "tbl_" . $my_cn;
                    $my_table .= '<td data-label="' . $data_label . '"


>' . get_relative( $rel_table, $val_id ) . '</td>';
                    } //strpos( $fname, '_cdr' )
                elseif ( strpos( $fname, '_img' ) )
                    {
                    $my_cn = str_replace( '_img', "", $fname );
                    $my_table .= '<td class="td-img" data-label="' . $data_label . '"
><a href="#" data-toggle="modal" data-target="#modal_img_' . $my_cn . '' . $data_id . '"><div class="btn btn-'.($val=="NA"?"danger":"info").'"><i class="fa fa-eye"></i> View</div></a>
			';
                    $my_table .= '
<div id="modal_img_' . $my_cn . '' . $data_id . '" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
	  <h4 class="modal-title">Preview Image</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <img class="mod-img" src="uploads/' . $my_cn . '/' . $val . '?' . date( "sa" ) . '"/></a>
      </div>
      <div class="modal-footer">
        <a type="button" class="btn btn-info" data-dismiss="modal">Close</a>
      </div>
    </div>

  </div>
</div>
</td>';
                    } 
				elseif ( strpos( $fname, '_sgn' ) )
					{
						$my_cn = str_replace( '_sgn', "", $fname );
						$my_table .= '<td class="td-img" data-label="' . $data_label . '"
><a href="#" data-toggle="modal" data-target="#modal_img_' . $my_cn . '' . $data_id . '"><div class="btn btn-'.($val=="NA"?"danger":"info").'"><i class="fa fa-eye"></i> View Signature</div></a>
				';
						$my_table .= '
		<div id="modal_img_' . $my_cn . '' . $data_id . '" class="modal fade" role="dialog">
		<div class="modal-dialog">
		
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
		  <h4 class="modal-title">Preview Image</h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		  </div>
		  <div class="modal-body">
			<img class="mod-img" src="uploads/' . $my_cn . '/' . $val . '?' . date( "sa" ) . '"/></a>
		  </div>
		  <div class="modal-footer">
			<a type="button" class="btn btn-info" data-dismiss="modal">Close</a>
		  </div>
		</div>
		
		</div>
		</div>
		</td>';
				} 
				elseif ( strpos( $fname, '_crt' ) )
                    {
						$my_cn     = str_replace( '_crt', "", $fname );
						$rel_table = "tbl_" . $my_cn;
						$resulting_arr = "";
						if(isset($val)){
					$crt_array = explode(',',$val);
					foreach ($crt_array as $item) {
						if($item!= ""){
							$crt_item = explode('-',$item);
							$crt_item_id = $crt_item[0];
							$crt_item_qty = $crt_item[1];
							$ci_name = get_value_condition("display_name_str",$rel_table,"id = " . $crt_item_id);
							$ci_qty = $crt_item_qty;
							$append_val = $crt_item_id . "-" . $crt_item_qty . ",";
							//echo $append_val . '=append_val';
							$generated_item = '<div class="crt_tbl_item"><b class="data-idr" data-toggle="modal" data-target="#idrModal" data-table="'.str_replace("tbl_","",$rel_table).'" data-idr="'.$crt_item_id.'">'.$ci_name.'</b> - '.$crt_item_qty.'</div>';
							
							$resulting_arr .= $generated_item;
							//echo "<li>$ci_name - $ci_qty</li>";
						}
						
					}
					//echo $my_val;
					
				}
                    	$my_table .= '<td>' . $resulting_arr . '</td>';
					} 
				elseif ( strpos( $fname, '_col' ) ){
					$my_cn = str_replace( '_col', "", $fname );
					$my_table .= '<td data-label="' . $data_label . '"><div class="color" style="background:'.$val.'">'.$val.'</div></td>';
				}
				elseif ( strpos( $fname, '_pdf' ) ){
					$my_cn = str_replace( '_pdf', "", $fname );
					$my_table .= '<td data-label="' . $data_label . '"><a target="new" class="btn btn-success '.($val==""?"disabled":"").'" href="uploads/' . $my_cn . '/' . $val . '?' . date( "sa" ) . '"> Preview </a></td>';
				}
                elseif ( strpos( $fname, '_log' ) )
                    {
                    $my_cn = str_replace( '_log', "", $fname );
                    $my_table .= '<td data-label="' . $data_label . '"


><a href="#" data-toggle="modal" data-target="#modal_log' . $data_id . '"><img src="uploads/logo/' . $my_cn . '/thumbs/' . $val . '?' . date( "sa" ) . '"/></a>
			';
                    $my_table .= '
<div id="modal_log' . $data_id . '" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
	  <h4 class="modal-title">Preview Image</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <img class="mod-img" src="uploads/logo/' . $my_cn . '/' . $val . '?' . date( "sa" ) . '"/></a>
      </div>
      <div class="modal-footer">
        <a type="button" class="btn btn-info" data-dismiss="modal">Close</a>
      </div>
    </div>

  </div>
</div>
</td>';
                    } //strpos( $fname, '_log' )
                else
                    {
                    //$data_label = "test";
                    if ( $x == 0 )
                        {
                        $data_label = "ID";
                        $my_table .= '<td data-label="' . $data_label . '">' . $val . '</td>';
                        } //$x == 0
                    elseif ( $x == ( $field_count ) + 1 )
                        {
                        $data_label = "Action";
                        $my_table .= '<td data-label="' . $data_label . '">' . $val . '</td>';
                        } //$x == ( $field_count ) + 1
                    else
                        {
                        $my_table .= '<td data-label="' . $data_label . '">' . $val . '</td>';
                        }
                    }
                } //$x = 0; $x <= $field_count; $x++
            
			
			if(($update_bol != "" && $update_bol != 0) || ($delete_bol != "" && $delete_bol != 0)){
            $my_table .= '<td data-label="' . $data_label . '"


>';
            if ( (get_value_condition("update_bol","tbl_admin_tables","(admin_type_idr=".$admin["admin_type_idr"].") AND (table_idr = ".$table_id.")")) == 1 )
                {
                $my_table .= '
          <a href="?table=' . $data_table_name . '&update&id=' . $data_id . '" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
    	     ';
                } //$table_detail[ "update_bol" ] == 1
            if ( (get_value_condition("delete_bol","tbl_admin_tables","(admin_type_idr=".$admin["admin_type_idr"].") AND (table_idr = ".$table_id.")")) == 1 )
                {
                $my_table .= '
          <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#delete_modal' . $data_id . '"><i class="fa fa-trash"></i></a>
    	     ';}
                } //$table_detail[ "delete_bol" ] == 1
            $my_table .= '
</td>
	
	
<div id="delete_modal' . $data_id . '" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
	  <h4 class="modal-title">Delete Confirmation</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this? </p>
      </div>
      <div class="modal-footer">
      	<a type="button" href="?table=' . $data_table_name . '&delete&yes&id=' . $data_id . '" class="btn btn-warning">Yes</a>
        <a type="button" class="btn btn-success" data-dismiss="modal">No</a>
      </div>
    </div>

  </div>
</div>';
            $ctr += 1;
			$ctr_val +=1;
            } //$row = mysqli_fetch_array( $table_query )
        } //$table_count != 0
    } //$table_query
?>

<?php
if ( isset( $_GET[ "table" ] ) )
    {
?>
<div class="container-fluid jumbotron p-5 fieldset">
    <div class="row">
    
    <div class="col-md-12">
    
<h2 class="table-title"><i class="fa <?= $fa_icon; ?>"></i> <?php
    echo $table_detail[ "title_str" ];
?>
    <div class="search_form">
        <form method="get" target="_self" action="?table=<?=strtolower($table)?>">
            <input type="hidden" name="table" value="<?=strtolower($table);?>">
            <input type="search" placeholder="Search..." class="form-control" name="q">
        </form>
    </div>
</h2>
<?php

$filter_count = count_con("tbl_table_field_filters","(table_idr = ".$table_id.")");
?>
	<div class="table-head-controls">
		<span class="product-num">Showing <?=$from_count?> - <?=$to_count?> of <?=$total_count?> items</span>
        <?php
        if($filter_count>0){
		?>
        	<div class="table-filters-container">
        	<div class="panel-group">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapse1">Filter Table</a>
                  </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse">
                  <div class="panel-body">
                  	<div class="table-filter">
                    	<form method="GET">
                        <input type="hidden" name="table" value="<?=$_GET[ "table" ]?>" /> 
                        <input type="hidden" name="filter" value="<?=$filter_count;?>" /> 
        <?php
        	$table_filters_query = select_db("tbl_table_field_filters","*","","(table_idr = ".$table_id.")",2);
			//echo $table_filters_query;
			while($tf = mysqli_fetch_assoc($table_filters_query)){
				$filter_field = $tf["field_str"];
				$filter_table = "tbl_".$_GET["table"];
				$option_table = "tbl_".substr( $filter_field, 0, -4 );
				$filter_label = get_value_condition("COLUMN_COMMENT","INFORMATION_SCHEMA.COLUMNS","table_name = '".$filter_table."' AND column_name = '".$filter_field."' AND table_schema = '".$database_name."'");
				if($filter_label == ""){
					$filter_label = str_replace("_"," ",ucfirst(substr( $filter_field, 0, -4 )));
					//$filter_label = get_value_condition("title_str","tbl_table","display_name_str = '".$filter_table."'");
				}
			?>
            
            	<div class="form-group">
                    <label><?=$filter_label;?></label>
                    <select name="<?=$filter_field?>" class="form-control">
                        <option selected>All</option>
                        <?php
                            echo get_options($option_table,0,$filter_table);
                        ?>
                    </select>
                </div>
            
            <?php
			}
		?>
        		<div class="form-group"><input type="submit" value="Filter" class="btn btn-success form-control"></div>
        </form>
                        
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
        	
        </div>
        <?php
		}
		?>
        
        
	<?php
    if ( (get_value_condition("add_bol","tbl_admin_tables","(admin_type_idr=".$admin["admin_type_idr"].") AND (table_idr = ".$table_id.")")) == 1 ){
?>
          <a class="btn btn-info pull-right new-btn" href="index.php?table=<?php
        echo strtolower( $table );
?>&new" ><i class="fa fa-plus"></i> New </a>
    	<?php } ?>
	</div>
	
    <div class="table-cont">
        <table id="td-table" class="table table-striped <?=($datatable==1?"dtable":"")?>">
        
        <?php
		//echo 'im here';
    echo $my_table;
?>
        </table>
    </div>
        <ul class="pagination">
              <?php 
			  $min = 1;
			  $page_numbering = $page - $min;
			  if($page_numbering <= 1){
				 $page_numbering = 2;
				 }
			  $max = $page_numbers;
			  $half_max = $max/2;
			  $hm = false;
			  //echo $half_max;
			  if($page_numbering>$half_max){
				  $hm = true;
				}
			  $p_offset = 4;
			  $dots_enabled = false;
			  ?>
              <li><a href="?table=<?=strtolower($table)?><?=(isset($q)?"&q=".$q:"")?>&page=<?=$min?>"><?=$min?></a></li>              <?php
              for ($x = $page_numbering; $x <= $page_numbers - 1; $x++) {
				  	if($x <= $p_offset + $page_numbering || $x >= $max - $p_offset){
						?>
                        <li class="<?=($x == $page ? "active" : "");?>"><a href="?table=<?=strtolower($table)?><?=(isset($q)?"&q=".$q:"")?>&page=<?=$x?>"><?=$x?></a></li>
                        <?php
					}else{
						if($dots_enabled == false){
							echo '<li><span>...</span></li>';
							$dots_enabled = true;
						}
					}
				  ?>
					
				<?php
                }
				
				if($page_numbers !=1){
					?>
				<li><a href="?table=<?=strtolower($table)?><?=(isset($q)?"&q=".$q:"")?>&page=<?=$max?>"><?=$max?></a></li>
                <?php
				}
			  ?>
             
              
            </ul>
    </div>
    </div>
</div>


<?php
    } //isset( $_GET[ "table" ] )
?>