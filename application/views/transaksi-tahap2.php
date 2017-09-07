<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Transaksi Baru</title>

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
      <?php include 'sidebar-admin1.php' ?>
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
                <div class="header-div-plain col-sm-8 col-sm-offset-2 mt header-div-green" id="div-header">
                    <span class="fa fa-question"></span><span>KONFIRMASI</span>
                </div>
                <div class="col-sm-8 col-sm-offset-2 white-bg">
                    <?php 
                        $attributes = array('class' => 'form-horizontal', 'id' => 'form_transaksi');
                        echo form_open('Transaksiadmin1_2/simpan_trans', $attributes); 
                    ?>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-6">Tgl Pembayaran:</label>
                        <div class="col-sm-6">
                            <div class="date" data-date="" data-date-format="dd-mm-yyyy" data-link-field="dtp_input2" data-link-format="dd-mm-yyyy">
                                <input class="form-control datepicker"  data-date-format="dd-mm-yyyy" type="text" name="tgl_bayar" style="width:150px" placeholder="dd-mm-yyyy" autocomplete="off" value="<?=$tgl_bayar?>" >
                                <?php echo form_error('tgl_bayar'); ?>
                            </div>

                        </div>

                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6" for="uname">Nama:</label>
                        <div class="control-label col-sm-6 text-left">
                            <?php echo $hd_nama;?>
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6" for="uname">Banyaknya Uang:</label>
                        <div class="control-label col-sm-6 text-left">
                            <?php echo "Rp " . number_format($bayar_final,2,",",".")  ;?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6">Tipe Pembayaran:</label>
                        <div class="control-label col-sm-6 text-left">
                            <?php echo $cb_tipebayar;?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6">Untuk Pembayaran:</label>
                        <div class="control-label col-sm-6 text-left">
                            <?php echo $nama_tanah;?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6">Tanggal Jatuh Tempo Berikutnya:</label>
                        <div class="col-sm-6">
                            <div class="date" data-date="" data-date-format="dd-mm-yyyy" data-link-field="dtp_input2" data-link-format="dd-mm-yyyy">
                                <input class="form-control datepicker"  data-date-format="dd-mm-yyyy" type="text" name="jatuh_tempo" style="width:150px" placeholder="dd-mm-yyyy" autocomplete="off" value="<?=$jatuh_tempo?>" >
                                <?php echo form_error('jatuh_tempo'); ?>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-12">
                        <?=$msg;?>
                    </div>
                    <div class="col-sm-12 text-center mt mb">    
                        <button type="submit" class="btn btn-success" name="submit" id="submit">Cetak Nota</button>
                        <button type="button" value="" class="btn btn-success" onClick="location.href='<?php echo base_url(). index_page();?>/Transaksiadmin1'">Back</button>
                    </div>
                    
                    <?php
                        echo form_close();
                    ?>
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
            $("#trans_baru").addClass("active");
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

  </body>
</html>
