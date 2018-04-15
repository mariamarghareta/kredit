<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Ubah Password</title>

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

  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
      <?php include('header.php');?>
      <!--header end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
      <?php
        if($_SESSION['kd_role'] == "RL002"){
            include 'sidebar-admin1.php';
        } else if($_SESSION['kd_role'] == "RL003"){
            include 'sidebar-admin2.php';
        }else if($_SESSION['kd_role'] == "RL001"){
            include 'sidebar-master.php';
        }
      ?>
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          	
            <div class="header-div-plain col-sm-8 col-sm-offset-2 mt" id="div-header">
                <span class="fa fa-key"></span><span>UBAH PASSWORD</span>
            </div>
            <div class="col-sm-8 col-sm-offset-2 white-bg row ">
                <?php 
                    $attributes = array('class' => 'form-horizontal', 'id' => 'form_pass');
                    echo form_open('Changepass/change', $attributes); 
                ?>
                <div class="form-group">
                    <label class="control-label col-sm-3 col-sm-offset-1">Password Lama:</label>
                    <div class="col-sm-5">
                        <?php echo form_input(array('name'=>'old', 'id'=>'old', 'class'=>'form-control', 'placeholder'=>'Masukkan Password lama', 'type'=>'password'), $old);?>
                        <?php echo form_error('old'); ?>
                    </div>
                    
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3 col-sm-offset-1">Password Baru:</label>
                    <div class="col-sm-10">
                        <?php echo form_input(array('name'=>'new', 'id'=>'new', 'class'=>'form-control', 'placeholder'=>'Masukkan Password baru', 'type'=>'password'), $new);?>
                        <?php echo form_error('new'); ?>
                    </div>
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-info fa fa-eye" id="see"></button>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3 col-sm-offset-1">Ulangi Password Baru:</label>
                    <div class="col-sm-5 ">
                        <?php echo form_input(array('name'=>'renew', 'id'=>'renew', 'class'=>'form-control', 'placeholder'=>'Masukkan Ulang Password baru', 'type'=>'password'), $renew);?>
                        <?php echo form_error('renew') ?>
                    </div>
                    
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                      <button type="submit" class="btn btn-success center-block btn-custom" id="submit" name="submit">Ubah Password</button>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-1">
                    <?=$msg?>
                    </div>
                </div>
                <?php
                    echo form_close();
                ?>
            </div>
                  
		</section><! --/wrapper -->
       
      </section>
        
      <!--main content end-->
     
  </section>

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
        $(document).ready(function(){
            $("#menu_pass").addClass('active');
            $("#err_msg").addClass('text-center');
            $(".sldown").slideDown("slow");
            $(".slup").slideUp("slow");
            $(".slfadein").fadeIn("slow");
            $(".slhide").hide();
            $(".slshow").show();
            
        });
    });
   
    $("#see").click(function(){
        if($("#new").attr("type") == "password"){
            $("#new").attr("type", "text");
        } else{
            $("#new").attr("type", "password");
        }
        
    });
  </script>

  </body>
</html>
