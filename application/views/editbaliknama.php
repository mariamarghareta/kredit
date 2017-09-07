<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

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
        if($_SESSION['kd_role'] == "RL001"){
            include 'sidebar-master.php';
        } else if($_SESSION['kd_role'] == "RL003"){
            include 'sidebar-admin2.php';
        }
            
      
      ?>
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          	
            <div class="header-div col-sm-8 col-sm-offset-2 mt" id="div-ppjb">
                <span class="fa fa-info"></span><span>PPJB</span>
            </div>
            <div class="col-sm-8 col-sm-offset-2 form-horizontal white-bg"> 
                <?php 
                    
                    $attributes = array('class' => 'form-horizontal', 'id' => 'edit_ppjb');
                    echo form_open('Transaksimaster/update_baliknama', $attributes); 
                ?>
                <input type="hidden" value="<?=$kd_nota?>" name="kd_nota"/>
                <input type="hidden" value="<?=$kd_trans?>" name="kd_trans"/>
                <div class="form-group">
                    <label class="control-label col-sm-6 col-xs-6" >Biaya Balik Nama:</label>
                    <div class="col-sm-5 ">
                        <?php echo form_input(array('name'=>'bayar', 'id'=>'bayar', 'class'=>'form-control', 'placeholder'=>'Biaya ppjb'), $bn->bayar);?>
                        <?php echo form_error('bayar'); ?>
                    </div>
                    
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-6 col-xs-6" >Tanggal Bayar:</label>
                    <div class="col-sm-5 ">
                        <div class="date" data-date="" data-date-format="dd-mm-yyyy" data-link-field="dtp_input2" data-link-format="dd-mm-yyyy">
                            <input class="form-control datepicker"  data-date-format="dd-mm-yyyy" type="text" name="tgl_trans" style="width:150px" placeholder="dd-mm-yyyy" autocomplete="off" value="<?=$bn->tgl_trans?>" >
                            <?php echo form_error('tgl_trans'); ?>
                        </div>
                    </div>
                    
                </div>
                
               
                <div class="col-sm-12 text-center mt">
                    <button type="submit" value="update" class="btn btn-success" name="btn-tog-cari" id="btn-up">Update</button>
                    <button type="submit" value="kembali" id="kembali" name="kembali" class="btn btn-success" name="btnkembali" id="btnkembali">Back</button>
                </div>
                <div class="col-sm-12 mt">
                    <?=$msg?>
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
        $("#bayar").maskMoney({thousands:'.', decimal:',', precision:0});
        $("#trans_admin2").addClass("active");
        $(".sldown").slideDown();
        $(".slhide").hide();
      
        $("#lbagen").ready(getrole);
        $("#lbagen").change(getrole);
        
        $('.datepicker').datetimepicker({
            language:  'id',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0
        });
    });
    //cari role
    var getrole = function(){
        $temp = $("#lbagen").val().split(";");
        $("#lbjabatan").html($temp[1]);
    }
    
   
  </script>

  </body>
</html>
