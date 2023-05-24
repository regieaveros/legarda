<?php 
if(isset($_GET["page"]))
{
	$my_page = $_GET["page"];
}
?>
<body class="<?php echo $my_page?>">
<?php include ("nav.php");?>
</body>
