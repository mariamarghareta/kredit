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
      <?php include 'sidebar-admin2.php' ?>
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          	
            <div class="header-div-plain col-sm-10 col-sm-offset-1 mt header-div-green" id="div-header">
                <span class="fa fa-question"></span><span>KONFIRMASI</span>
            </div>
            <div class="col-sm-10 col-sm-offset-1 white-bg">
                <?php 
                    $attributes = array('class' => 'form-horizontal', 'id' => 'bayar_cicilan');
                    echo form_open('Transaksiadmin2_2/cetak_nota', $attributes); 
                    $tipe = "Biaya PPJB";
                ?>     
                        
                
                <input type="hidden" name="kd_trans" value="<?=$kd_trans?>"/>
                <input type="hidden" name="nama" value="<?=$nama?>"/>
                <input type="hidden" name="tipe_bayar" value="<?=$tipe_bayar?>"/>
                <input type="hidden" name="nama_tanah" value="<?=$nama_tanah?>"/>
                <input type="hidden" name="ppjb" value="<?=$ppjb?>"/>
                <input type="hidden" name="kd_agen" value="<?=$kd_agen?>"/>
                <input type="hidden" name="nm_agen" value="<?=$nm_agen?>"/>

                <div class="mt">
                    <div class="col-sm-12 form-horizontal"> 
                        <div class="form-group">
                            <label class="control-label col-sm-6" for="uname">Tanggal Pembayaran:</label>
                            <div class="col-sm-6">
                                <div class="date" data-date="" data-date-format="dd-mm-yyyy" data-link-field="dtp_input2" data-link-format="dd-mm-yyyy">
                                    <input class="form-control datepicker"  data-date-format="dd-mm-yyyy" type="text" name="tgl_bayar" style="width:150px" placeholder="dd-mm-yyyy" autocomplete="off" value="<?=$tgl_bayar?>" >
                                    <?php echo form_error('tgl_bayar'); ?>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-6" for="uname">Nama:</label>
                            <div class="control-label col-sm-6 text-left"><?=$nama?></div>
                        </div>
                       
                        <div class="form-group">
                            <label class="control-label col-sm-6" for="uname">Banyaknya uang:</label>
                            <div class="control-label col-sm-6 text-left">Rp <?=number_format($ppjb,0,",",".")?></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-6" for="uname">Tipe Pembayaran:</label>
                            <div class="control-label col-sm-6 text-left"><?=$tipe;?></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-6" for="uname">Untuk Pembayaran:</label>
                            <div class="control-label col-sm-6 text-left"><?=$nama_tanah;?></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-6" for="uname">Nama Agen/Sales:</label>
                            <div class="col-sm-6 control-label text-left">
                                <?=$nm_agen?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-6">Melalui Transfer:</label>
                            <div class="control-label col-sm-6 text-left">
                                <?php echo form_checkbox(array('id'=>'is_transfer', 'name' => 'is_transfer', 'value' => 1));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 text-center mt">
                                <button type="submit" name="submit" id="submit" class="btn btn-success " value="submit">Cetak Nota</button>
                                <button type="submit" name="kembali" id="kembali" class="btn btn-success " value="kembali">Kembali</button>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <?=$msg?>
                        </div>

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
    <script>
        $(document).ready(function(){
            $("#trans_admin2").addClass("active");
            $(".sldown").slideDown();
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
    </script>
   
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    
    <script src="<?php echo base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.ui.touch-punch.min.js"></script>
    
    <script class="include" type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.scrollTo.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    
    <script src="<?php echo base_url(); ?>assets/js/common-scripts.js"></script>
    
    <!--script for this page-->
    
  

  </body>
</html>
