<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Master Pemasukan</title>

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
        if($_SESSION['kd_role'] == "RL003"){
            include 'sidebar-admin2.php';
        } else if($_SESSION['kd_role'] == "RL001"){
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
                <div class="header-div-plain header-div-green col-sm-10 col-sm-offset-1 mt" id="div-header">
                    <span class="fa fa-money"></span><span>TRANSAKSI PEMASUKAN</span>
                </div>
                <div class="col-sm-10 col-sm-offset-1 white-bg mb">
                    <?php 
                        $attributes = array('class' => 'form-horizontal', 'id' => 'form_pemasukan');
                        echo form_open('Masterpemasukan/add_new_data', $attributes); 
                    ?>
                    <!--kolom kiri-->
                    <div class="col-sm-12 mt">
                        <div class="form-group">
                            <label class="control-label col-sm-4" >Jumlah Pemasukan:</label>
                            <div class="col-sm-3">
                              <?php echo form_input(array('name'=>'uang', 'id'=>'uang', 'class'=>'form-control', 'placeholder'=>'Besar pemasukan'), $uang);?>
                              <?php echo form_error('uang'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Tanggal Pemasukan:</label>
                            <div class="col-sm-8">
                              <input class="form-control datepicker"  data-date-format="dd-mm-yyyy" type="text" name="tanggal" style="width:195px" placeholder="dd-mm-yyyy" autocomplete="off" value="<?=$tanggal?>" >
                            </div>
                          </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Nama Karyawan:</label>
                            <div class="col-sm-5">
                              <?php echo form_input(array('name'=>'pj', 'id'=>'pj', 'class'=>'form-control', 'placeholder'=>'Nama karyawan penanggung jawab'), $pj);?>
                              <?php echo form_error('pj'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Keterangan:</label>
                            <div class="col-sm-8">
                              <?php echo form_textarea(array('name'=>'ket', 'id'=>'ket', 'style'=>'height:120px;', 'class'=>'form-control', 'placeholder'=>'Keterangan pemasukan'), $ket);?>
                              <?php echo form_error('ket'); ?>
                            </div>
                        </div>
                        
                    </div>
                    <?php
                        if($show_update == "none"){
                    ?>
                    <div class="form-group"> 
                        <div class="col-sm-12">
                          <button type="submit" class="btn btn-success btn-custom center-block" id="simpan" name="simpan">Simpan Transaksi</button>
                        </div>
                    </div>
                    <?php
                        }
                        if($show_update == ""){
                    ?>
                    <input type="hidden" name="kd_pemasukan" value="<?=$kd_pemasukan?>" >
                    <div class="form-group"> 
                        <div class="col-sm-12 text-center">
                          <button type="button" class="btn btn-success btn-custom" id="ubah" name="ubah">Ubah Data</button>
                            <button type="button" class="btn btn-success btn-custom" id="batal" name="batal">Batal</button>
                        </div>
                    </div>
                    
                    <?php
                        }
                    ?>
                    <div class="form-group"> 
                        <div class="col-sm-12">
                          <?=$msg;?>
                        </div>
                    </div>
                    <?php echo form_close(); ?>   
                </div>
                
		  </section><!--/wrapper -->
       
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
        
        $("#ubah").click( function(){
            $("#form_pemasukan").attr("action", "<?php echo base_url();echo index_page(); ?>/Masterpemasukan/update_data");
            $("#form_pemasukan").submit();
        });
         
        $("#batal").click( function(){
            $("#form_pemasukan").attr("action", "<?php echo base_url();echo index_page(); ?>/Masterpemasukan");
            $("#form_pemasukan").submit();
        });
         
        $("#uang").maskMoney({thousands:'.', decimal:',', precision:0});
         
        $("#menu_pemasukan").addClass('active');
        $("#err_msg").addClass('text-center');
        $('#tab').dataTable();
        $(".sldown").slideDown("slow");
        $(".slup").slideUp("slow");
        $(".slfadein").fadeIn("slow");
        $(".slhide").hide();
        $(".slshow").show();

    });
  </script>

  </body>
</html>
