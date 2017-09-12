<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Edit Header</title>

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
      <?php include 'sidebar-master.php' ?>
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          	<div class="header-div-plain col-sm-10 col-sm-offset-1 mt" id="div-header">
                <span class="fa fa-search"></span><span>CARI DATA</span>
            </div>
            <div class="col-sm-10 col-sm-offset-1 white-bg row ">
                <?php 
                    $attributes = array('class' => 'form-horizontal', 'id' => 'edit_head');
                    echo form_open('Editheader/update_header', $attributes); 
                ?>
                <div class="col-sm-6">
                    <div class="form-group">
                        <input type="hidden" value="<?=$kd_trans?>" id="kd_trans" name="kd_trans">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label col-sm-4" >Customer:</label>
                                <div class="col-sm-8">
                                    <label name="lb_nama" id="lb_nama" class="line-btn"><?php echo $hd_nama;?></label>

                                    <?php echo form_error('hd_kode'); ?>
                                    <input type="hidden" name="hd_kode" id="hd_kode" value="<?php echo $hd_kode;?>"></input>
                                    <input type="hidden" name="hd_nama" id="hd_nama" value="<?php echo $hd_nama;?>"></input>
                                    <button type="button" value="" class="btn btn-success pull-right" name="btn-tog-cari" id="btn-tog-cari">Cari data</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-12 form-horizontal " id="div-cari-cust" style="display:none;">
                        <div class="form-group">
                            <label class="control-label col-sm-4" >Cari:</label>
                            <div class="col-sm-8">
                                <input type="text" name="search_cust" id="search_cust" class="form-control" placeholder="Masukkan Nama/No.KTP customer"></input>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-4">
                                <select size="4" id="ls_cust" name="ls_cust" class="form-control">
                                    <?php 
                                        foreach($cust as $row) {
                                            echo "<option value=$row->kd_cust >$row->ktp-$row->nama</option>";
                                        }
                                    ?>
                                </select>
                                <div class="error" style="display:none;" id="err-msg">*Pilih salah satu data</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-4">
                                <button type="button" value="" class="btn btn-success pull-right" name="btn-pilih" id="btn-pilih">Pilih data</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="uname">Kavling:</label>
                        <div class="col-sm-8">
                            <select name="cb_blok" id="cb_blok" class="form-control control-label">
                                <?php
                                    foreach($blok as $row) {
                                        if($row->kd_blok == $cb_blok){
                                            echo "<option value=$row->kd_blok selected>$row->nama_blok</option>";
                                        } else {
                                            echo "<option value=$row->kd_blok>$row->nama_blok</option>";
                                        }

                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <label class="control-label col-sm-4 " for="uname">Blok:</label>
                        <div class="col-sm-8">
                            <select name="cb_tanah" id="cb_tanah" class="form-control">

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4 " for="uname">Tipe:</label>
                        <div class="col-sm-8">
                            <?php echo form_input(array('name'=>'tipe', 'id'=>'tipe', 'class'=>'form-control', 'placeholder'=>'Tipe Tanah'), $tipe);?>
                            <?php echo form_error('tipe'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4 " for="uname">Harga:</label>
                        <div class="col-sm-8">
                            <?php echo form_input(array('name'=>'harga', 'id'=>'harga', 'class'=>'form-control', 'placeholder'=>'Harga Tanah'), $harga);?>
                            <?php echo form_error('harga'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4 " for="uname">Diskon:</label>
                        <div class="col-sm-8">
                            <?php echo form_input(array('name'=>'diskon', 'id'=>'diskon', 'class'=>'form-control', 'placeholder'=>'Diskon yang diberikan'), $diskon);?>
                            <?php echo form_error('diskon'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4 " for="uname">Tipe Bayar:</label>
                        <div class="col-sm-8">
                            <input type="hidden" value="<?=$tipe_bayar?>" name="tipe_bayar" id="tipe_bayar">
                            <select class="form-control" id="cb_tipe_bayar" name="cb_tipe_bayar">
                                <?php
                                    if($tipe_bayar == 0){
                                ?>
                                    <option value="cash" selected>Cash</option>
                                <?php
                                    } else {
                                ?>
                                    <option value="cash">Cash</option>
                                <?php
                                    }
                                ?>
                                <?php
                                    if($tipe_bayar == 1 || $tipe_bayar == 2){
                                ?>
                                    <option value="cicilan" selected>Cicilan</option>
                                <?php
                                    } else {
                                ?>
                                    <option value="cicilan">Cicilan</option>
                                <?php
                                    }
                                ?>
                                
                            </select> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="uname">Cicilan Balik Nama:</label>
                        <div class="col-sm-8">
                            <?php echo form_input(array('name'=>'tb_bulanbaliknama', 'id'=>'tb_bulanbaliknama', 'class'=>'form-control', 'placeholder'=>'Masukkan cicilan balik nama berapa bulan'), $tb_bulanbaliknama);?>
                            <?php echo form_error('tb_bulanbaliknama'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="uname">Biaya Balik Nama:</label>
                        <div class="col-sm-8">
                            <?php echo form_input(array('name'=>'tb_biayabaliknama', 'id'=>'tb_biayabaliknama', 'class'=>'form-control', 'placeholder'=>'Masukkan biaya balik nama berapa bulan'), $tb_biayabaliknama);?>
                            <?php echo form_error('tb_biayabaliknama'); ?>
                        </div>
                    </div>
                    <div class="form-group" id="div-dp" style="display:none">
                        <label class="control-label col-sm-4 " for="uname">DP/UM:</label>
                        <div class="col-sm-8">
                            <?php echo form_input(array('name'=>'dp', 'id'=>'dp', 'class'=>'form-control', 'placeholder'=>'DP/UM yang dibayar'), $dp);?>
                            <?php echo form_error('dp'); ?>
                        </div>
                    </div>
                    <div class="form-group" id="div-dp-cicilan" style="display:none">
                        <label class="control-label col-sm-4 " for="uname">Cicilan DP/UM:</label>
                        <div class="col-sm-8">
                            <?php echo form_input(array('name'=>'dp_cicilan', 'id'=>'dp_cicilan', 'class'=>'form-control', 'placeholder'=>'Banyaknya cicilan DP/UM'), $dp_cicilan);?>
                            <?php echo form_error('dp_cicilan'); ?>
                        </div>
                    </div>
                    <div class="form-group" id="div-cicilan" style="display:none">
                        <label class="control-label col-sm-4 " for="uname">Cicilan Pembayaran:</label>
                        <div class="col-sm-8">
                            <?php echo form_input(array('name'=>'cicilan', 'id'=>'cicilan', 'class'=>'form-control', 'placeholder'=>'Angsuran berapa bulan'), $cicilan);?>
                            <?php echo form_error('cicilan'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 text-center mt">
                    <button type="submit" value="update" class="btn btn-success" name="btn-tog-cari" id="btn-tog-cari">Update</button>
                    <button type="submit" value="kembali" id="kembali" name="kembali" class="btn btn-success" name="btn-tog-cari" id="btn-tog-cari">Back</button>
                </div>
                <div class="col-sm-12">
                    <?=$msg?>
                </div>
                <?php echo form_close();?>
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
        $("#trans_admin2").addClass("active");
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
        $('#tab').dataTable();
        $("#range").change(show_range);
        $(".sldown").slideDown();
        $(".slhide").hide();
        $("#btn-tog-cari").click(function(){
            $("#div-cari-cust").slideToggle();
        });
        $("#search_cust").keyup(cari_cust);
        $("#search_cust").ready(cari_cust);
        
        $("#cb_blok").ready(load_tanah);
        $("#cb_blok").change(load_tanah);
        
        $("#harga").maskMoney({thousands:'.', decimal:',', precision:0});
        $("#diskon").maskMoney({thousands:'.', decimal:',', precision:0});
        $("#dp").maskMoney({thousands:'.', decimal:',', precision:0});
        
        $("#cb_tipe_bayar").change(show_detail);
        $("#cb_tipe_bayar").ready(show_detail);
    });
    var show_detail = function(){
        if($("#cb_tipe_bayar").val() == "cicilan"){
            $("#div-dp").slideDown();
            $("#div-dp-cicilan").slideDown();
            $("#div-cicilan").slideDown();
            $("#tipe_bayar").val(2);
        } else {
            $("#div-dp").hide();
            $("#div-dp-cicilan").hide();
            $("#div-cicilan").slideDown();
            $("#tipe_bayar").val(0);
        }
    }
    var show_range = function(){
        $pil = $("#range").val();
        
        if($pil == "bulan"){
            $("#div_bulan").slideDown();
            $("#div_range").hide();
        }else if($pil == "jangka"){
            $("#div_bulan").hide();
            $("#div_range").slideDown();
        } else {
            $("#div_bulan").hide();
            $("#div_range").hide();
        }       
    }
    

    var cari_cust = function(){        
        var keyword = {
            'keyword':$("#search_cust").val()
        };
        $.ajax({
            url:"<?php echo base_url().index_page();?>/Transaksiadmin2_baru/search_cust",
            type:"POST",
            data: keyword,
            success:function(msg){
                $arr = msg;
                $temp = "";
                for(var $i=0; $i<$arr.length; $i++){
                    $temp+= "<option value='" + ($arr[$i]["kd_cust"]) + "'>" +($arr[$i]["ktp"])+ "-" + ($arr[$i]["nama"]) + "</option>";
                }
                $("#ls_cust").html($temp);

            },
            dataType:"json"
        });
    }
    var load_tanah = function(){

        if($("#cb_blok").val() != null){
            var keyword = {
                'keyword':$("#cb_blok").val(),
                'kd_trans':$("#kd_trans").val()
            };
            $.ajax({
                url:"<?php echo base_url().index_page();?>/Editheader/get_tanah",
                type:"POST",
                data: keyword,
                success:function(msg){
                    $arr = msg;
                    $temp = "";
                    for(var $i=0; $i<$arr.length; $i++){
                        if($arr[$i]["kd_tanah"] == "<?php echo $cb_tanah?>" ){
                            $temp+= "<option value='" + ($arr[$i]["kd_tanah"]) + "' selected>" + ($arr[$i]["nomor_tanah"]) + "</option>";
                        } else{
                            $temp+= "<option value='" + ($arr[$i]["kd_tanah"]) + "'>" + ($arr[$i]["nomor_tanah"]) + "</option>";
                        }

                    }
                    $("#cb_tanah").html($temp);
                },
                dataType:"json"
            });
        }
    }
    $("#btn-pilih").click(function(){
        if($("#ls_cust").val() != null){
            var keyword = {
                'keyword':$("#ls_cust").val()
            };
            
            $.ajax({
                url:"<?php echo base_url().index_page();?>/Transaksiadmin2_baru/get_cust",
                type:"POST",
                data: keyword,
                success:function(msg){
                    $arr = msg;
                                        
                    $("#lb_nama").html($arr[0]["nama"]);
                    $("#hd_nama").val($arr[0]["nama"]);
                    $("#hd_kode").val($arr[0]["kd_cust"]);
                    $("#div-cari-cust").slideToggle();
                    $("#err-msg").hide();
                },
                dataType:"json"
            });
        }else{
            $("#err-msg").slideDown();
        }
    });
    
  </script>

  </body>
</html>
