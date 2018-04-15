<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Data Tanah</title>

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
          	<div class="header-div-plain col-sm-8 col-sm-offset-2 mt" id="div-header">
                <span class="fa fa-search"></span><span>CARI DATA PENDAPATAN</span>
            </div>
            <div class="col-sm-8 col-sm-offset-2 white-bg row ">
                <?php 
                    $attributes = array('class' => 'form-horizontal', 'id' => 'form_tanah');
                    echo form_open('Laporanpenjualan/search', $attributes); 
                ?>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label col-sm-3 col-sm-offset-1 ">Tipe Pembayaran:</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="tipe" name="tipe">
                                
                                <option value="all" <?php if($tipe == 'all'){echo "selected";}?> >Semua</option>
                                <option value="pilih" <?php if($tipe == 'pilih'){echo "selected";  $show_pilih = "block";}?> >Pilih Tipe Pembayaran</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="display:<?=$show_pilih;?>" id="div_pilih">
                        <div class="col-sm-4 col-sm-offset-4 mb" style="padding-left:35px;">
                            <div class="checkbox">
                                <input type="checkbox" name="cbpilih[0]" value="cash" <?php if(sizeof($cbpilih) > 0) { if(in_array("cash", $cbpilih)){echo "checked";}} ?> >Cash
                            </div>
                            <div class="checkbox">
                                <input type="checkbox" name="cbpilih[1]" value="book" <?php if(sizeof($cbpilih) > 0) { if(in_array("book", $cbpilih)){echo "checked";}} ?> >Booking
                            </div>
                            <div class="checkbox">
                                <input type="checkbox" name="cbpilih[2]" value="ppjb" <?php if(sizeof($cbpilih) > 0) { if(in_array("ppjb", $cbpilih)){echo "checked";}} ?> >PPJB
                            </div>
                            <div class="checkbox">
                                <input type="checkbox" name="cbpilih[3]" value="cicilan" <?php if(sizeof($cbpilih) > 0) { if(in_array("cicilan", $cbpilih)){echo "checked";}} ?> >Cicilan
                            </div>
                            <div class="checkbox">
                                <input type="checkbox" name="cbpilih[4]" value="dp" <?php if(sizeof($cbpilih) > 0) { if(in_array("dp", $cbpilih)){echo "checked";}} ?> >DP/UM
                            </div>
                            <div class="checkbox">
                                <input type="checkbox" name="cbpilih[5]" value="balik" <?php if(sizeof($cbpilih) > 0) { if(in_array("balik", $cbpilih)){echo "checked";}} ?> >Balik Nama
                            </div>
                            <div class="checkbox">
                                <input type="checkbox" name="cbpilih[6]" value="lain" <?php if(sizeof($cbpilih) > 0) { if(in_array("lain", $cbpilih)){echo "checked";}} ?> >Lain-lain
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3 col-sm-offset-1 ">Kavling:</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="kav" name="kav">
                                
                                <option value="kav_all" <?php if($kav == 'kav_all'){echo "selected"; }?> >Semua</option>
                                <option value="kavling" <?php if($kav == 'kavling'){echo "selected";  $show_kav = "block";}?> >Pilih Kavling</option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="display:<?=$show_kav;?>" id="div_kavling">
                        <div class="col-sm-4 col-sm-offset-4">
                            <select class="form-control" id="select_kav" name="select_kav">
                                <?php
                                    foreach($kavling as $row){
                                        echo "<option value=".$row->kd_blok;
                                        if($select_kav == $row->kd_blok){echo " selected";}
                                        echo "> $row->nama_blok</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3 col-sm-offset-1 ">Range Tanggal:</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="range" name="range">
                                
                                <option value="bulan" <?php if($range == 'bulan'){echo "selected"; $show_bulan = "block";}?> >Bulanan</option>
                                <option value="jangka" <?php if($range == 'jangka'){echo "selected";  $show_range = "block";}?> >Jangka Waktu Tertentu</option>
                                <option value="tgl_all" <?php if($range == 'tgl_all'){echo "selected";}?> >Semua</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="display:<?=$show_range;?>" id="div_range">
                        <div class="col-sm-3 col-sm-offset-4">
                            <div class="date" data-date="" data-date-format="dd-mm-yyyy" data-link-field="dtp_input2" data-link-format="dd-mm-yyyy">
                                <input class="form-control datepicker"  data-date-format="dd-mm-yyyy" type="text" name="mulai" placeholder="dd-mm-yyyy" autocomplete="off" value="<?=$mulai?>" >
                                <?php echo form_error('mulai'); ?>
                            </div>
                        </div>
                        <div class="col-sm-1 text-center">
                            -
                        </div>
                        <div class="col-sm-3">
                            <div class="date" data-date="" data-date-format="dd-mm-yyyy" data-link-field="dtp_input2" data-link-format="dd-mm-yyyy">
                                <input class="form-control datepicker"  data-date-format="dd-mm-yyyy" type="text" name="akhir" placeholder="dd-mm-yyyy" autocomplete="off" value="<?=$akhir?>" >
                                <?php echo form_error('akhir'); ?>
                            </div>
                        </div>
                    </div>
                   
                    <div class="form-group" style="display:<?=$show_bulan;?>" id="div_bulan">
                        <div class="col-sm-3 col-sm-offset-4">
                            <select class="form-control" id="bulan" name="bulan">
                                <option value="01" <?php if($bulan == '01'){echo "selected";}?> >Januari</option>
                                <option value="02" <?php if($bulan == '02'){echo "selected";}?> >Febuari</option>
                                <option value="03" <?php if($bulan == '03'){echo "selected";}?> >Maret</option>
                                <option value="04" <?php if($bulan == '04'){echo "selected";}?> >April</option>
                                <option value="05" <?php if($bulan == '05'){echo "selected";}?> >Mei</option>
                                <option value="06" <?php if($bulan == '06'){echo "selected";}?> >Juni</option>
                                <option value="07" <?php if($bulan == '07'){echo "selected";}?> >Juli</option>
                                <option value="08" <?php if($bulan == '08'){echo "selected";}?> >Agustus</option>
                                <option value="09" <?php if($bulan == '09'){echo "selected";}?> >September</option>
                                <option value="10" <?php if($bulan == '10'){echo "selected";}?> >Oktober</option>
                                <option value="11" <?php if($bulan == '11'){echo "selected";}?> >November</option>
                                <option value="12" <?php if($bulan == '12'){echo "selected";}?> >Desember</option>
                            </select>
                        </div>
                       
                        <div class="col-sm-2">
                            <select id="tahun" name="tahun" class="form-control">
                                <?php
                                    $date = new DateTime();
                                    $date->setTimezone(new DateTimeZone('GMT+7'));
                                    echo $date->format("Y");
                                    for($i=20; $i>=0; $i--){
                                        $tahun = $date->format("Y") - $i;
                                        if($tahun == $date->format("Y")){
                                            echo "<option value=$tahun selected>$tahun</option>";
                                        }else{
                                            echo "<option value=$tahun>$tahun</option>";
                                        }
                                        
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-success btn-custom" id="sub" name="sub">Tampilkan Data</button>
                            <button type="button" class="btn btn-success btn-custom" id="print" name="print">Print</button>
                        </div>
                    </div>
                </div>
                <?php
                    echo form_close();
                ?>
            </div>
            <div class="header-div-plain col-sm-12 mt" id="div-header">
                <span class="fa fa-table"></span><span>DATA PENDAPATAN</span>
            </div>
            <div class="detail-tabel col-sm-12">
                 <div class="col-sm-12 pr pl">
                    <div class="table-responsive">
                        <table id="tab" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            
                            <thead>
                              <tr>
                                <th>No.</th>
                                <th>Kode Transaksi</th>
                                <th>Kavling</th>
                                <th>Keterangan</th>
                                <th>Total (Rp)</th>
                                
                              </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $date = new DateTime();
                                    $date->setTimezone(new DateTimeZone('GMT+7'));
                                    $ctr = 1;
                                    $total = 0;
                                    $tot_transfer = 0;
                                    if(sizeof($detail)>0){
                                        foreach ($detail as $row)
                                        {
                                            $ctr_cash = 0; $ctr_cicilan = 0; $ctr_dp = 0; $ctr_bn =0;
                                            echo"<tr>";
                                            echo "<td>" . $ctr ."</td>";
                                            $ctr++;
                                            echo "<td>" . $row[0]['kd_trans'] ."</td>";
                                            echo "<td>" ;
                                            if(substr($row[0]['kd_trans'],0,1) == "M"){echo "-";} else {echo $row[0]['keterangan'];}
                                            echo "</td>";
                                            echo "<td>";
                                            if(sizeof($row[1]) > 0 ){
                                                echo "Agen: ". $row[0]['nama_karyawan']."</br></br>";
                                                foreach($row[1] as $temp){
                                                    if($temp["is_transfer"] == 1){
                                                        $temp["is_transfer"] = "Ya";
                                                    } else {
                                                        $temp["is_transfer"] = "Tidak";
                                                    }
                                                    if(strlen($temp["catatan"])>0){
                                                        $catatan = " (". $temp["catatan"].")";
                                                    }else{
                                                        $catatan = " (-)";
                                                    }
                                                    if(substr($temp['kd_nota'],0,1) == "C"){
                                                        $ctr_cash += 1;
                                                        echo "Cash ke-$ctr_cash: ". number_format($temp['bayar'],0,",",".") ."</br>Tgl. Bayar: ". $temp['tgl_trans'] ."</br> Transfer:". $temp["is_transfer"].$catatan."</br>";
                                                    }else if(substr($temp['kd_nota'],0,1) == "I"){
                                                        $ctr_cicilan+=1;
                                                        echo "Cicilan ke-$ctr_cicilan: ". number_format($temp['bayar'],0,",",".")  ."</br>Tgl. Bayar: ". $temp['tgl_trans'] ."</br> Transfer:". $temp["is_transfer"].$catatan."</br>";
                                                    }else if(substr($temp['kd_nota'],0,1) == "B"){
                                                        echo "Booking: ". number_format($temp['bayar'],0,",",".")  ."</br>Tgl. Bayar: ". $temp['tgl_trans'] ."</br> Transfer:". $temp["is_transfer"].$catatan."</br>";
                                                    }else if(substr($temp['kd_nota'],0,1) == "D"){
                                                        $ctr_dp += 1;
                                                        echo "DP/UM ke-$ctr_dp: ". number_format($temp['bayar'],0,",",".")  ."</br>Tgl. Bayar: ". $temp['tgl_trans'] ."</br> Transfer:". $temp["is_transfer"].$catatan."</br>";
                                                    }else if(substr($temp['kd_nota'],0,1) == "P"){
                                                        echo "PPJB: ". number_format($temp['bayar'],0,",",".")  ."</br>Tgl. Bayar: ". $temp['tgl_trans'] ."</br> Transfer:". $temp["is_transfer"].$catatan."</br>";
                                                    }else if(substr($temp['kd_nota'],0,1) == "N"){
                                                        $ctr_bn += 1;
                                                        echo "Balik Nama ke-$ctr_bn: ". number_format($temp['bayar'],0,",",".")  ."</br>Tgl. Bayar: ". $temp['tgl_trans'] ."</br> Transfer:". $temp["is_transfer"].$catatan."</br>";
                                                    }
                                                
                                                    if(substr($temp['kd_nota'],0,1) == "M"){
                                                
                                                            echo "$temp[keterangan]</br>Tgl. Bayar: $temp[tgl_trans] </br>Transfer: $temp[is_transfer] $catatan </br>Jenis Pemasukan: $temp[name]";

                                                            $attributes = array('class' => 'form-horizontal', 'id' => 'lihat_detail');
                                                            echo form_open('Masterpemasukan/ubah_pemasukan', $attributes); 
                                                            echo "<input type=hidden name='kd_pemasukan' id='kd_pemasukan' value='".$temp['kd_nota']."' >";
                                                            echo "<button type='submit' class='btn btn-xs btn-info'><span class='fa fa-pencil'></span>Edit</button>";
                                                            echo form_close();
                                                            echo "</br>";
                                                        
                                                    } else {
                                                        
                                                        $attributes = array('class' => 'form-horizontal', 'id' => 'lihat_detail');
                                                        echo form_open('Masteradmin/lihat_detail', $attributes); 
                                                        echo "<input type=hidden name='kd_trans' id='kd_trans' value='".$temp['kd_trans']."' >";
                                                        echo "<button type='submit' class='btn btn-xs btn-info'><span class='fa fa-info'></span>Lihat Detail</button>";
                                                        echo form_close();
                                                        echo "</br>";
                                                    }
                                                    if ($temp["is_transfer"] == "Tidak"){
                                                        $total += $temp["bayar"];
                                                    }else{
                                                        $tot_transfer += $temp["bayar"];
                                                    }
                                                }
                                                
                                                
                                            }
                                            echo "</td>";
                                            echo "<td class='text-right'>" . number_format($row[0]['bayar'],0,",",".")  ."</td>";
                                            
                                            
                                            
                                            //$total += $row[0]['bayar'];
                                            echo"</tr>";
                                        }   
                                    }

                                ?>

                            </tbody>
                        </table>
                        
                     </div>
                     
                </div>
                <div class="col-sm-12 text-center mt">
                    <h3><?="Total Keseluruhan: Rp " . number_format($tot_transfer + $total,0,",",".")?></h3>
                    <h3><?="Total (Transfer): Rp " . number_format($tot_transfer,0,",",".")?></h3>
                    <h3><?="Pengeluaran: Rp " . number_format($total_pengeluaran,0,",",".")?></h3>
                    <h3><?="Total Keseluruhan: Rp " . number_format( $total - $total_pengeluaran,0,",",".")?></h3>
                </div>
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
        $("#menu_penjualan").addClass('active');
        $("#sub_menu_lap").css("display", "block");
        
         $("#tipe").change(show_tipe);
        $("#tipe").ready(show_tipe);
        
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
        $("#kav").change(show_kavling);
        $(".sldown").slideDown();
        $(".slhide").hide();
        
        $("#print").click( function(){
            $("#form_tanah").prop("target", "_blank");
            $("#form_tanah").attr("action", "<?php echo base_url();echo index_page(); ?>/Laporanpenjualan/print_laporan");
            $("#form_tanah").submit();
            $("#form_tanah").prop("target", "_self");
            $("#form_tanah").attr("action", "<?php echo base_url();echo index_page(); ?>/Laporanpenjualan/search");
            //alert("aaa");
        });
    });
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
   
    var show_tipe = function(){
        
        $pil = $("#tipe").val();
        
        if($pil != "all"){
            $("#div_pilih").slideDown();
        } else {
            $("#div_pilih").hide();
        }       
    }
    var show_kavling = function(){
        
        $pil = $("#kav").val();
        
        if($pil == "kavling"){
            $("#div_kavling").slideDown();
        } else {
            $("#div_kavling").hide();
        }       
    }
   
   
  </script>

  </body>
</html>
