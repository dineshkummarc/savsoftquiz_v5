<html>
<head>
<title>
<?php echo $GLOBALS['appName'];?> | <?php echo $GLOBALS['appNameSlogan'];?>
</title>
 <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="sqmicro.css?q=<?php echo time();?>">
<script src="jquery.js"></script>
<script> var base_url="<?php echo base_url();?>";</script>
<script src="sqmicro.js?q=<?php echo time();?>"></script>
</head>
<body>
<?php 
if(flash_message('message') != false){
	?>
	<div class="sqm-alert" id="message"><?php $message=flash_message('message'); echo $message;?></div><script> shake('#message'); </script>
	<?php 
}
?>