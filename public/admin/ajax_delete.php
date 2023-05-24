<?php
	if(isset($_POST["delete_file"])){
		$delete_file = $_POST["delete_file"];
		$deleted = unlink($delete_file);
		if($deleted){
			echo 'YES';
		}
	}
?>