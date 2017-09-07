<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Sistem Kredit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include 'import.php' ?>
   
</head>
<body>
    <div class="row header-menu">
        <div class="row row-one">
            <div class="col-sm-2 col-sm-offset-9 no-padding-left user-name"> WELCOME, <?php echo strtoupper($_SESSION['uname']);?> <button type="button" value="" class="btn btn-success btn-xs pull-right btn-logout" onClick="location.href='<?php echo base_url(). index_page();?>/Masteradmin/logout'">Log Out</button></div>
        </div>
        <div class="row">
            <?php include 'header.php' ?>
            <?php include 'menu-admin.php' ?>    
        </div>
    </div>
    
    <div class="body-wrapper">
        
    </div>
    <div class="footer">
        Copyright Maria Marghareta
    </div>
</body>
</html>