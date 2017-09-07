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
          	
                <div class="header-div-plain col-sm-10 col-sm-offset-1 mt header-div-green" id="div-header">
                    <span class="fa fa-dollar"></span><span>FORM TRANSAKSI</span>
                </div>
                <div class="col-sm-10 col-sm-offset-1 white-bg">
                    <?php 
                        $attributes = array('class' => 'form-horizontal', 'id' => 'form_transaksi');
                        echo form_open('Transaksiadmin2_baru/tahap1', $attributes); 
                    ?>
                    <!--kolom kiri-->
                    <div class="col-sm-6 mt">
                        
                            <div class="col-sm-12 form-horizontal">
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
                            <div class="col-sm-12">
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
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-4 " for="uname">Blok:</label>
                                    <div class="col-sm-8">
                                        <select name="cb_tanah" id="cb_tanah" class="form-control">

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="uname">Type:</label>
                                    <div class="col-sm-8">
                                        <?php echo form_input(array('name'=>'tb_tipe', 'id'=>'tb_tipe', 'class'=>'form-control', 'placeholder'=>'Masukkan tipe'), $tb_tipe);?>
                                        <?php echo form_error('tb_tipe'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="uname">Harga:</label>
                                    <div class="col-sm-8">
                                        <?php echo form_input(array('name'=>'tb_harga', 'id'=>'tb_harga', 'class'=>'form-control', 'placeholder'=>'Masukkan harga'), $tb_harga);?>
                                        <?php echo form_error('tb_harga'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="uname">Agen:</label>
                                    <div class="col-sm-8">
                                        <select name="cb_agen" id="cb_agen" class="form-control">
                                        </select>
                                    </div>
                                </div>
                            </div>
                
                    </div>
                    <!--kolom kanan-->
                    <div class="col-sm-6 mt">
                         <div class="col-sm-12 form-horizontal">
                             <div class="form-group">
                                <label class="control-label col-sm-4" for="uname">Tipe Pembayaran:</label>
                                <div class="col-sm-8 control-label">
                                    <select name="cb_tipebayar" id="cb_tipebayar" class="form-control">
                                        <?php
                                            if($cb_tipebayar == "booking"){    
                                        ?>
                                            <option value="cash" >Bayar Cash</option>
                                            <option value="cicilan">Cicilan</option>
                                            <option value="booking" selected>Booking</option>
                                        <?php
                                            }else if($cb_tipebayar == "cicilan"){
                                        ?>
                                            <option value="cash" >Bayar Cash</option>
                                            <option value="cicilan" selected>Cicilan</option>
                                            <option value="booking" >Booking</option>
                                        <?php
                                            } else {
                                        ?>
                                            <option value="cash" selected>Bayar Cash</option>
                                            <option value="cicilan">Cicilan</option>
                                            <option value="booking">Booking</option>
                                        <?php    
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="bayar_cash" style="display:none;" class="col-sm-12 form-horizontal">
                            <div class="form-group">
                                <label class="control-label col-sm-4" >Bayar:</label>
                                <div class="col-sm-8">
                                    <?php echo form_input(array('name'=>'tb_cashbayar', 'id'=>'tb_cashbayar', 'class'=>'form-control', 'placeholder'=>'Masukkan besar uang yang dibayarkan'), $tb_cashbayar);?>
                                    <?php echo form_error('tb_cashbayar'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Diskon:</label>
                                <div class="col-sm-8">
                                    <?php echo form_input(array('name'=>'tb_cashdiskon', 'id'=>'tb_cashdiskon', 'class'=>'form-control', 'placeholder'=>'Masukkan diskon'), $tb_cashdiskon);?>
                                    <?php echo form_error('tb_cashdiskon'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="uname">Cicilan:</label>
                                <div class="col-sm-8">
                                    <?php echo form_input(array('name'=>'tb_cashbulan', 'id'=>'tb_cashbulan', 'class'=>'form-control', 'placeholder'=>'Masukkan cicilan berapa bulan'), $tb_cashbulan);?>
                                    <?php echo form_error('tb_cashbulan'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="uname">Cicilan Balik Nama:</label>
                                <div class="col-sm-8">
                                    <?php echo form_input(array('name'=>'tb_bulanbaliknama', 'id'=>'tb_bulanbaliknama', 'class'=>'form-control', 'placeholder'=>'Masukkan cicilan balik nama berapa bulan'), $tb_bulanbaliknama);?>
                                    <?php echo form_error('tb_bulanbaliknama'); ?>
                                </div>
                            </div>
                            
                        </div>
                        <div id="bayar_booking" style="display:none;" class="col-sm-12 form-horizontal">
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="uname">Bayar:</label>
                                <div class="col-sm-8">
                                    <?php echo form_input(array('name'=>'tb_bookbayar', 'id'=>'tb_bookbayar', 'class'=>'form-control', 'placeholder'=>'Masukkan besar uang booking'), $tb_bookbayar);?>
                                    <?php echo form_error('tb_cashbayar'); ?>
                                </div>
                            </div>
                        </div>
                        <div id="bayar_dp" style="display:none;" class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="uname">DP/UM:</label>
                                <div class="col-sm-8">
                                    <?php echo form_input(array('name'=>'tb_cidp', 'id'=>'tb_cidp', 'class'=>'form-control', 'placeholder'=>'Masukkan besar uang DP yang harus dibayar'), $tb_cidp);?>
                                    <?php echo form_error('tb_cidp'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="uname">Banyaknya Cicilan DP:</label>
                                <div class="col-sm-8">
                                    <?php echo form_input(array('name'=>'tb_ciberapabulan', 'id'=>'tb_ciberapabulan', 'class'=>'form-control', 'placeholder'=>'Masukkan berapa kali DP dilakukan'), $tb_ciberapabulan);?>
                                    <?php echo form_error('tb_ciberapabulan'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="uname">Bayar DP1:</label>
                                <div class="col-sm-8">
                                    <?php echo form_input(array('name'=>'tb_cidp1', 'id'=>'tb_cidp1', 'class'=>'form-control', 'placeholder'=>'Masukkan jumlah DP1 yang dibayarkan'), $tb_cidp1);?>
                                    <?php echo form_error('tb_cidp1'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="uname">Diskon:</label>
                                <div class="col-sm-8">
                                    <?php echo form_input(array('name'=>'tb_cidiskon', 'id'=>'tb_cidiskon', 'class'=>'form-control', 'placeholder'=>'Masukkan diskon'), $tb_cidiskon);?>
                                    <?php echo form_error('tb_cidiskon'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="uname">Angsuran:</label>
                                <div class="col-sm-8">
                                    <?php echo form_input(array('name'=>'tb_ciangsuran', 'id'=>'tb_ciangsuran', 'class'=>'form-control', 'placeholder'=>'Angsuran berapa bulan'), $tb_ciangsuran);?>
                                    <?php echo form_error('tb_ciangsuran'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 mt mb">
                        <button type="submit" class="center-block btn btn-success pl pr" name="submit" id="submit">Siapkan Nota</button>
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
            $("#btn-tog-cari").click(function(){
                $("#div-cari-cust").slideToggle();

            });
            $("#tb_harga").maskMoney({thousands:'.', decimal:',', precision:0});
            $("#tb_cashbayar").maskMoney({thousands:'.', decimal:',', precision:0});
            $("#tb_cashdiskon").maskMoney({thousands:'.', decimal:',', precision:0});
            $("#tb_bookbayar").maskMoney({thousands:'.', decimal:',', precision:0});
            $("#tb_cidp").maskMoney({thousands:'.', decimal:',', precision:0});
            $("#tb_cidp1").maskMoney({thousands:'.', decimal:',', precision:0});
            $("#tb_cidiskon").maskMoney({thousands:'.', decimal:',', precision:0});
            $("#tb_harga").maskMoney({thousands:'.', decimal:',', precision:0});
            $("#tb_cashbayar").maskMoney({thousands:'.', decimal:',', precision:0});

            $("#cb_tipebayar").ready(load_bayar);
            $("#cb_tipebayar").change(load_bayar);
            
            $("#trans_baru").addClass("active");
        });
         $("#search_cust").keyup(function(){
            /*
            var keyword = $("#search-cust").val();
            $.post('Transaksiadmin1/search_cust', keyword, function(data){
                alert(data);
            });
            */
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

        });
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
        var load_tanah = function(){
            if($("#cb_blok").val() != null){
                var keyword = {
                    'keyword':$("#cb_blok").val()
                };
                $.ajax({
                    url:"<?php echo base_url().index_page();?>/Transaksiadmin2_baru/get_tanah",
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
        var load_agen = function(){
            var keyword = {
                'keyword':$("#cb_agen").val()
            };
            $.ajax({
                url:"<?php echo base_url().index_page();?>/Transaksiadmin2_baru/get_agen",
                type:"POST",
                data: keyword,
                success:function(msg){
                    $arr = msg;
                    $temp = "";
                    for(var $i=0; $i<$arr.length; $i++){
                        if($arr[$i]["kd_role"] == "RL004" || $arr[$i]["kd_role"] == "RL005"){
                            if($i == 0){
                                $temp+= "<option value='" + ($arr[$i]["kd_kar"]) + "' selected>" + ($arr[$i]["nama"]) + "</option>";
                            } else{
                                $temp+= "<option value='" + ($arr[$i]["kd_kar"]) + "'>" + ($arr[$i]["nama"]) + "</option>";
                            }
                        }
                    }
                    $("#cb_agen").html($temp);
                },
                dataType:"json"
            });
        }
        var load_bayar = function(){
            var temp = $("#cb_tipebayar").val();
            if(temp == "cash"){
                $("#bayar_booking").hide();
                $("#bayar_cash").slideToggle();
                $("#bayar_dp").hide();
            }else if(temp == "booking"){
                $("#bayar_cash").hide();
                $("#bayar_dp").hide();
                $("#bayar_booking").slideDown();
            }else if(temp == "cicilan"){
                $("#bayar_cash").hide();
                $("#bayar_dp").slideDown();
                $("#bayar_booking").hide();
            }
        }


        $("#cb_blok").ready(load_tanah);
        $("#cb_blok").change(load_tanah);
        $("#cb_agen").ready(load_agen);
        $("#cb_blok").change(load_agen);
  </script>

  </body>
</html>
