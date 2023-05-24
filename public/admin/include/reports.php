<?php
	if(isset($_GET["report"])){
		$report_id = addslashes(strip_tags($_GET["report"]));
		$reports_query = select_db("tbl_admin_reports","*","","id=".$report_id,2);
		$report = mysqli_fetch_array( $reports_query );
		
		$report_name = $report[1];
		$report_query = $report["query_lng"];
		//echo $report_name ."|".$report_query."|".$report_date_field;
	}
	if(isset($_GET["report"])&&isset($_GET["filter"])&&isset($_GET["date_from"])&&isset($_GET["date_to"])){
		$filter = addslashes(strip_tags($_GET["filter"]));
		$reports_query = select_db("tbl_admin_reports","*","","id=".$report_id,2);
		$report = mysqli_fetch_array( $reports_query );
		
		$report_name = $report[1];
		$report_query = $report["query_lng"];
		
		$date_from = $_GET["date_from"];
		$date_to = $_GET["date_to"];
		$final_report_query = select_query($report_query,$date_from,$date_to,2);
		//echo $final_report_query;
		//echo 'Test';
		//echo $report_name ."|".$report_query."|".$report_date_field;
	}
?>
<div class="container-fluid jumbotron p-5 fieldset">
    <div class="row">
        <div class="col-md-12">
        	<h2 class="table-title"><?=$report_name?></h2>
        	<form class="form-filter" method="get">
            	<div class="row">
                	<input type="hidden" name="report" value="<?=$_GET["report"];?>" />
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>From</label>
                            <input class="form-control" required type="date" name="date_from" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>To</label>
                            <input class="form-control" required type="date" name="date_to" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <input class="form-control btn btn-success" required type="submit" name="filter" value="Filter"/>
                        </div>
                    </div>
               </div>
            </form>
            <div class="report-container">
            <div class="table-cont">
            <?php
            if(isset($final_report_query)){?>
            	<div class="table-title-header">
                	<div class="table-title">Generating <b><?=$report_name?></b> filtered <b>FROM <?=$date_from?> TO <?=$date_to?></b></div>
                </div>
				<table class="table table-striped">
  <thead>
    <tr>
      <?php
      $row = mysqli_fetch_assoc($final_report_query);
            foreach ($row as $col => $value) {
                echo "<th>";
                echo $col;
                echo "</th>";
            }
      ?>
    </tr>
  </thead>
  <tbody>
    <?php
  // Write rows
  mysqli_data_seek($final_report_query, 0);
    while ($row = mysqli_fetch_assoc($final_report_query)) {
        ?>
    <tr>
      <?php         
    foreach($row as $key => $value){
        echo "<td>";
        echo (is_numeric($value)&&(strlen($value)>1)?monetarize($value):$value);
        echo "</td>";
    }
    ?>
    </tr>
    <?php } ?>
  </tbody>
</table>
<?php
			}
			?>
        		</div>
            </div>
        </div>
    </div>
</div>
