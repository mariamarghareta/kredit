<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <title>Bayar Cicilan</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/style-responsive.css" rel="stylesheet">

    <?php include 'import.php' ?>
  
  </head>



  <body>

    <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
     
      <div id="login-page">
	  	<div class="container">
                    
            <?php 
                $attributes = array('class' => 'form-login');
                echo form_open('welcome/login', $attributes); 
            ?>
            <h2 class="form-login-heading">sign in now</h2>
            <div class="login-wrap">
                <div class="form-group">
                    
                  <input type="text" class="form-control" id="uname" name="uname" placeholder="Enter username">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" id="pass" placeholder="Enter password" name="pass">
                </div>
                
                <input type="submit" class="btn btn-theme btn-block" name="submit" id="submit" value="SIGN IN">
                <div class="mt text-center">
                    <?=$err_msg?>
                </div>
            </div>
            <?php echo form_close(); ?>
            
          </div>
          
          
      </div>
    <!-- js placed at the end of the document so the pages load faster -->
    
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.ui.touch-punch.min.js"></script>
    <script class="include" type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.scrollTo.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="<?php echo base_url(); ?>assets/js/common-scripts.js"></script>

    <!--script for this page-->
    
  <script type="text/javascript">
        $(document).ready(function(){
            $(".sldown").slideDown("slow");
        });
   
  </script>

  </body>
</html>
