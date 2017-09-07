<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Data Transaksi</title>

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
                <span class="fa fa-search"></span><span>CARI DATA TRANSAKSI</span>
            </div>
            <div class="col-sm-8 col-sm-offset-2 white-bg row ">
                <?php 
                    $attributes = array('class' => 'form-horizontal', 'id' => 'form_tanah');
                    echo form_open('Masteradmin/search', $attributes); 
                ?>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label col-sm-3 col-sm-offset-1 ">Filter:</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="filter" name="filter" value="blunas">
                                <option value="all" <?php if($filter == 'all'){echo "selected";}?> >Semua</option>
                                <option value="lunas" <?php if($filter == 'lunas'){echo "selected";}?> >Lunas</option>
                                <option value="blunas" <?php if($filter == 'blunas'){echo "selected";}?> >Belum Lunas</option>
                                <option value="jatuhtempo" <?php if($filter == 'jatuhtempo'){echo "selected";}?> >Jatuh Tempo</option>
                            </select>
                        </div>
                        

                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3 col-sm-offset-1 ">Tanggal Penjualan Blok:</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="range" name="range">
                                <option value="tgl_all" <?php if($range == 'tgl_all'){echo "selected";}?> >Semua</option>
                                <option value="bulan" <?php if($range == 'bulan'){echo "selected"; $show_bulan = "block";}?> >Bulanan</option>
                                <option value="jangka" <?php if($range == 'jangka'){echo "selected";  $show_range = "block";}?> >Jangka Waktu Tertentu</option>
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
                            <button type="submit" class="btn btn-success btn-custom" id="sub" name="sub" value="subs">Tampilkan Data</button>
                            <button type="button" class="btn btn-success btn-custom" id="print" name="print" value="print">Print</button>
                        </div>
                    </div>
                </div>
                <?php
                    echo form_close();
                ?>
            </div>
            <div class="header-div-plain col-sm-12 mt" id="div-header">
                <span class="fa fa-table"></span><span>DATA BLOK</span>
            </div>
            <div class="detail-tabel col-sm-12">
                 <div class="col-sm-12 pr pl">
                    <div class="table-responsive">
                        <table id="tab" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                              <tr>
                                <th>No.</th>
                                <th>Jatuh Tempo</th>
                                <th>Kode Transaksi</th>
                                <th>Kavling</th>
                                <th>Blok</th>
                                <th>Denda</th>
                                <th>Customer</th>
                                <th>Status</th>
                                
                                <th>Lihat Data</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $date = new DateTime();
                                    $date->setTimezone(new DateTimeZone('GMT+7'));
                                    $ctr = 1;
                                    if(($header != null)){
                                        foreach ($header as $row)
                                        {
                                            echo"<tr>";
                                            echo "<td>" . $ctr."</td>";
                                            $ctr++;
                                            if($row->status == 0){
                                                if($date->format("Y-m-d") > date("Y-m-d",strtotime($row->jatuh_tempo))){
                                                    echo "<td class='danger error'>" . $row->jatuh_tempo ."</td>";
                                                }else{
                                                    echo "<td>" . $row->jatuh_tempo ."</td>";
                                                }
                                            }  else {
                                                echo "<td class='text-center'>-</td>";
                                            }

                                            echo "<td>" . $row->kd_trans ."</td>";
                                            echo "<td>" . $row->nama_blok ."</td>";
                                            echo "<td>" . $row->nomor_tanah ."</td>";
                                            
                                            if($row->status == 0){
                                                echo "<td>" .  number_format($row->paydenda ,0,",",".") ."</td>";
                                            } else {
                                                echo "<td>0</td>";
                                            }
                                            
                                            echo "<td>" . $row->nama ." </br>Telp : " . $row->telp;
                                            if($row->telp2 != ""){
                                                echo ", " . $row->telp2;
                                            }
                                            if($row->telp3 != ""){
                                                echo ", " . $row->telp3;
                                            }
                                            echo  "</br>Alamat : ". $row->alamat." </br>RT/RW : ". $row->rt ." </br>Kelurahan : ". $row->kelurahan ." </br>Kecamatan : ". $row->kecamatan.  "</td>";
                                            if($row->status == 0){
                                                echo "<td class='danger error'>Belum Lunas</td>";    
                                            }else{
                                                echo "<td class='success'>Lunas</td>";
                                            }

                                            echo "<td class='text-center'>";
                                                
                                                $attributes = array('class' => 'form-horizontal', 'id' => 'lihat_detail');
                                                echo form_open('Masteradmin/lihat_detail', $attributes); 
                                                echo "<input type=hidden name='kd_trans' id='kd_trans' value='$row->kd_trans' >";
                                                echo "<button type='submit' class='btn btn-info'><span class='fa fa-info'></span>Lihat Detail</button>";
                                                echo form_close();
                                            echo "</td>";
                                            echo"</tr>";
                                        }   
                                    }

                                ?>

                            </tbody>
                        </table>
                     </div>
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
        $("#menu_transaksi").addClass('active');
        $("#sub_menu_lap").css("display", "block");
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
        
        $("#print").click( function(){
            $("#form_tanah").prop("target", "_blank");
            $("#form_tanah").attr("action", "<?php echo base_url();echo index_page(); ?>/Masteradmin/print_laporan");
            $("#form_tanah").submit();
            $("#form_tanah").attr("action", "<?php echo base_url();echo index_page(); ?>/Masteradmin/search");
            $("#form_tanah").prop("target", "_self");
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
   
   
  </script>

  </body>
</html>
