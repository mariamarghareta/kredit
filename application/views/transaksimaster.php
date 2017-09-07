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
          	
            <div class="col-sm-12 row mt-big">
                <div class="col-sm-10 col-sm-offset-1">
                <?php 
                    $attributes = array('class' => 'form-horizontal', 'id' => 'bayar_cicilan');
                    echo form_open('Transaksimaster/cek_nota', $attributes); 
                ?>
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="uname">KODE TRANSAKSI:</label>
                        <div class="col-sm-4">
                          <?php echo form_input(array('name'=>'kd_trans', 'id'=>'kd_trans', 'class'=>'form-control', 'placeholder'=>'Masukkan nomor nota'), $kd_trans);?>
                          <div class="error <?=$err_nota?>" style="display:none;" >Kode Transaksi tidak ada</div>
                        </div>
                        <div class="col-sm-4 text-center mt-mob">
                            <button id="cek_nota" type="submit" class="btn btn-success"><span class="fa fa-check"></span> Cek Nota</button>
                            <button type="button" id="cari_nota" class="btn btn-success ml"><span class="fa fa-search"></span> Cari Nota</button>
                        </div>
                        
                      </div>
                <?php echo form_close();?>
                   
                </div>
                <div class="col-sm-10 col-sm-offset-1 form-horizontal" id="div_cari" style="display:none;">
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="uname">CARI:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="cari" placeholder="Masukkan nama customer/tanah"></input>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-3">
                            <select size="5" class="form-control" id="ls_data"  >

                            </select>
                            <div class="error" id="err_cari" style="display:none;">*Pilih salah satu</div>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-3 text-right">
                            <button id="pilih_data" type="button" class="btn btn-success">Pilih Data</button>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-sm-12 row mt">
            <div class="row col-sm-6 mt">
             <?php
                if($show_header == ""){
                    if($header->tipe_bayar == 0){
                        $tipe = "Cash";
                    }else if($header->tipe_bayar == 1){
                        $tipe = "Booking";
                    }else if($header->tipe_bayar == 2){
                        $tipe = "Cicilan";
                    }
                
            ?>  
                <div class="header-div col-sm-11 col-sm-offset-1" id="div-header">
                    <span class="fa fa-info"></span><span>INFO</span>
                </div>
                <div class="col-sm-11 col-sm-offset-1 form-horizontal white-bg" id="div-header-info"> 
                    <?php 
                        $attributes = array('class' => 'form-horizontal', 'id' => 'header_info');
                        echo form_open('Editheader/show_header', $attributes); 
                    ?>
                    <input type="hidden" name="kd_trans" value="<?=$kd_trans?>"/>
                    <div class="form-group">
                        <label class="control-label col-sm-6 col-xs-6" for="uname">Status:</label>
                        <?php
                            if($status == "Sudah Lunas"){
                        ?>
                        <div class="control-label col-sm-6 col-xs-6 text-left"><span class="fa fa-check-circle" style="color:green;"></span><?=$status?></div>
                        <?php
                            } else {
                        ?>
                            <div class="control-label col-sm-6 col-xs-6 text-left"><span class="fa fa-times" style="color:red;"></span><?=$status?></div>
                        <?php
                            }
                        ?>
                        
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6 col-xs-6" for="uname">Nama Customer:</label>
                        <div class="control-label col-sm-6 text-left col-xs-6"><?=$header->nama?></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6 col-xs-6" for="uname">Tanah:</label>
                        <div class="control-label col-sm-6 text-left col-xs-6"><?=$header->nama_blok. " " .$header->nomor_tanah?></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6 col-xs-6" for="uname">Tipe:</label>
                        <div class="control-label col-sm-6 text-left col-xs-6"><?=$header->tipe?></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6 col-xs-6" for="uname">Tipe Pembayaran:</label>
                        <div class="control-label col-sm-6 text-left col-xs-6"><?=$tipe;?></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6 col-xs-6" for="uname">Banyaknya Cicilan DP:</label>
                        <div class="control-label col-sm-6 col-xs-6 text-left"><?=$header->dp_cicilan . " bulan";?></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6 col-xs-6" for="uname">Banyaknya Angsuran:</label>
                        <div class="control-label col-sm-6 col-xs-6 text-left"><?=$header->cicilan . " bulan";?></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6 col-xs-6" for="uname">Banyaknya Cicilan Balik Nama:</label>
                        <div class="control-label col-sm-6 col-xs-6 text-left"><?=$header->cicilan_baliknama . " bulan";?></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6 col-xs-6" for="uname">Harga Jual:</label>
                        <div class="control-label col-sm-6 col-xs-6 text-left"><?="Rp ". number_format($header->harga ,0,',','.') ?></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6 col-xs-6" for="uname">Diskon:</label>
                        <div class="control-label col-sm-6 col-xs-6 text-left"><?="Rp ". number_format($header->diskon ,0,',','.') ?></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6 col-xs-6" for="uname">Booking:</label>
                        <div class="control-label col-sm-3 col-xs-3 text-left"><?="Rp ". number_format($header->bayar_book ,0,',','.') ?></div>
                        <div class="col-sm-3 col-xs-3">
                            <?php
                            if($header->book_kd_nota != null){
                                
                                echo "
                                <div class='col-sm-12 col-xs-12 text-center'>
                                <input type='hidden' value='$header->book_kd_nota' name='kd_nota'>
                                <button type='button' id='print_book' name='print_book' class='btn btn-success'>Print</button>
                                </div>
                                ";
                                
                            }
                            ?>
                        </div>
                    </div>
                    <div class="form-group text-center mt">
                        <button id="edit_header" type="submit" class="btn btn-success"><span class="fa fa-pencil"></span>Edit</button>
                    </div>
                    <?php echo form_close();?>
                    
                </div>
                
                <div class="header-div col-sm-11 col-sm-offset-1 mt" id="div-balik">
                    <span class="fa fa-info"></span><span>BALIK NAMA</span>
                </div>
                <div class="col-sm-11 col-sm-offset-1 form-horizontal white-bg" id="div-balik-info" style="display:none;"> 
                    <div class="form-group">
                        <label class="control-label col-sm-6 col-xs-6" for="uname">Biaya Balik Nama:</label>
                        <div class="control-label col-sm-6 col-xs-6 text-left"><?="Rp ". number_format($header->balik_nama ,0,',','.') ?></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6 col-xs-6" for="uname">Karyawan yang Mengurus:</label>
                        <div class="control-label col-sm-6 col-xs-6 text-left"><?=$header->bn_kar_nama?></div>
                    </div>
                    <div class="col-sm-12 mb mt">
                        
                        <?php
                        if($header->bn_kd_nota != null){
                            $attributes = array('class' => 'form-horizontal', 'id' => 'edit_ppjb');
                            echo form_open('Transaksimaster/edit_baliknama', $attributes); 
                            echo "
                            <div class='col-sm-6 col-xs-6 text-right'>
                            <input type='hidden' value='$header->bn_kd_nota' name='kd_nota'>
                            <input type='hidden' value='$kd_trans' name='kd_trans'>
                            <button type='submit' id='edit' name='edit' class='btn btn-success'>Edit</button>
                            </div>
                            ";
                            echo form_close();
                            
                            $attributes = array('class' => 'form-horizontal', 'id' => 'bayar_cicilan', 'target' => '_blank');
                            echo form_open('Mid/print_nota_again', $attributes); 
                            echo "
                            <div class='col-sm-6 col-xs-6 text-left'>
                            <input type='hidden' value='$header->bn_kd_nota' name='kd_nota'>
                            <button type='submit' id='edit' name='edit' class='btn btn-success'>Print</button>
                            </div>
                            ";
                            echo form_close();
                        }
                        ?>
                    </div>
                </div>
                
                <div class="header-div col-sm-11 col-sm-offset-1 mt" id="div-ppjb">
                    <span class="fa fa-info"></span><span>PPJB</span>
                </div>
                <div class="col-sm-11 col-sm-offset-1 form-horizontal white-bg" id="div-ppjb-info" style="display:none;"> 
                    <div class="form-group">
                        <label class="control-label col-sm-6 col-xs-6" for="uname">Biaya PPJB:</label>
                        <?php
                            if($data_ppjb == null){
                        ?>
                            <div class="control-label col-sm-6 col-xs-6 text-left"><?="Rp ". number_format(0 ,0,',','.') ?></div>
                        <?php
                            }else{
                        ?>
                            <div class="control-label col-sm-6 col-xs-6 text-left"><?="Rp ". number_format($data_ppjb->bayar ,0,',','.') ?></div>
                        <?php
                            }
                        ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6 col-xs-6" for="uname">Karyawan yang Mengurus:</label>
                        <div class="control-label col-sm-6 col-xs-6 text-left"><?php if(sizeof($data_ppjb) > 0){echo $data_ppjb->ppjb_kar_nama;} else {echo "-";} ?></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6 col-xs-6" for="uname">Agen/Sales yang Menjual:</label>
                        <div class="control-label col-sm-6 col-xs-6 text-left"><?php if(sizeof($data_ppjb) > 0){echo $data_ppjb->ppjb_agen;}else{echo "-";} ?></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6 col-xs-6" for="uname">Bonus untuk Agen/Sales:</label>
                        <div class="control-label col-sm-6 col-xs-6 text-left"><?php if(sizeof($data_ppjb) > 0){echo "Rp " .number_format($data_ppjb->bonus_agen ,0,',','.');}else{echo "-";} ?></div>
                    </div>
                    <div class="col-sm-12 mt mb">
                        <?php
                        if(sizeof($data_ppjb) > 0){
                            if($data_ppjb->kd_nota != null){
                                $attributes = array('class' => 'form-horizontal', 'id' => 'edit_ppjb');
                                echo form_open('Transaksimaster/edit_ppjb', $attributes); 
                                echo "
                                <div class='col-sm-6 col-xs-6 text-right'>
                                <input type='hidden' value='$data_ppjb->kd_nota' name='kd_nota'>
                                <input type='hidden' value='$kd_trans' name='kd_trans'>
                                <button type='submit' id='edit' name='edit' class='btn btn-success'>Edit</button>
                                </div>
                                ";
                                echo form_close();
                                
                                $attributes = array('class' => 'form-horizontal', 'id' => 'bayar_cicilan', 'target' => '_blank');
                                echo form_open('Mid/print_nota_again', $attributes); 
                                echo "
                                <div class='col-sm-6 col-xs-6 text-left'>
                                <input type='hidden' value='$data_ppjb->kd_nota' name='kd_nota'>
                                <button type='submit' id='edit' name='edit' class='btn btn-success'>Print</button>
                                </div>
                                ";
                                echo form_close();
                                
                            }
                        }
                        ?>
                    </div>
                </div>
                <?php
                }
                
                if($show_cash == "sldown"){
                    $ctr = 1;
                    
                ?>
                    <div class="header-div col-sm-11 col-sm-offset-1 mt" id="div-cicilan">
                        <span class="fa fa-money"></span><span>CICILAN CASH</span>
                    </div>
                    <div class="col-sm-11 col-sm-offset-1 form-horizontal white-bg" id="div-cicilan-info"> 
                        <div class="form-group">
                        <?php

                                $ctr = 1;
                                foreach($detail_cash as $row){
                                    if($ctr >= 2){
                                        echo "<div class='col-sm-6 col-sm-offset-3 col-xs-6 col-xs-offset-3 bb line'></div>";
                                    }
                                    echo "<div class='form-group'>";
                                    echo "<label class='control-label col-sm-6 col-xs-6'> Cicilan cash ke-$ctr: </label>";
                                    echo "<div class='control-label col-sm-6 col-xs-6 text-left'>Rp ". number_format($row['bayar'] ,0,',','.') . "</div>";
                                    echo "</div>";
                                    echo "<div class='form-group'>";
                                    echo "<label class='control-label col-sm-6 col-xs-6'> Tgl Bayar: </label>";
                                    echo "<div class='control-label col-sm-6 col-xs-6 text-left'>" .$row['tgl_trans'] . "</div>";
                                    echo "</div>";
                                     echo "<div class='form-group'>";
                                    echo "<label class='control-label col-sm-6 col-xs-6'> Karyawan yang Mengurus: </label>";
                                    echo "<div class='control-label col-sm-6 col-xs-6 text-left'>" .$row['nama'] . "</div>";
                                    echo "</div>";
                                    $ctr++;
                                    //$jatuh_tempo = $row['jatuh_tempo'];
                                    $attributes = array('class' => 'form-horizontal', 'id' => 'bayar_cicilan');
                                    echo form_open('Transaksimaster/edit_nota', $attributes); 
                                    echo "
                                    <div class='col-sm-6 col-xs-6 text-right mb'>
                                    <input type='hidden' value=$row[kd_nota] name='kd_nota'>
                                    <input type='hidden' value=$kd_trans name='kd_trans'>
                                    <button type='submit' id='edit' name='edit' class='btn btn-success'>Edit</button>
                                    </div>
                                    ";
                                    echo form_close();
                                    
                                    $attributes = array('class' => 'form-horizontal', 'id' => 'bayar_cicilan', 'target' => '_blank');
                                    echo form_open('Mid/print_nota_again', $attributes); 
                                    echo "
                                    <div class='col-sm-6 col-xs-6 text-left mb'>
                                    <input type='hidden' value=$row[kd_nota] name='kd_nota'>
                                    <button type='submit' id='edit' name='edit' class='btn btn-success'>Print</button>
                                    </div>
                                    ";
                                    echo form_close();
                                }
                                echo "<div class='col-sm-8 col-xs-8 col-xs-offset-2 col-sm-offset-2 bb line'></div>";
                        ?>
                            <div class='form-group'>
                                <label class="control-label col-sm-6 col-xs-6" for="uname">Total:</label>
                                <div class="control-label col-sm-6 col-xs-6 text-left"><?="Rp ".  number_format($data_bayar->cash,0,",",".") ?></div>
                            </div>
                            
                        </div>

                    </div>
                <?php
                    }
                    if($show_book == ""){
                ?>
                    <div class="header-div col-sm-11 col-sm-offset-1 mt" id="div-dp">
                        <span class="fa fa-file-o"></span><span>DETAIL DP</span>
                    </div>
                     <div class="col-sm-11 col-sm-offset-1 form-horizontal white-bg" id="div-dp-info"> 
                        <div class="form-group">
                        <?php
                            if(sizeof($detail_book) > 0){
                                echo "<div class='form-group'>";
                                echo "<label class='control-label col-sm-6 col-xs-6'> DP/UM: </label>";
                                echo "<div class='control-label col-sm-6 col-xs-6 text-left'>Rp ". number_format($header->dp ,0,',','.') ."</div>";
                                echo "</div>";
                                echo "<div class='col-sm-8 col-xs-8 col-xs-offset-2 col-sm-offset-2 bb line'></div>";
                                $ctr=1;
                                foreach($detail_book as $row){
                                    if($ctr >= 2){
                                        echo "<div class='col-sm-6 col-sm-offset-3 col-xs-6 col-xs-offset-3 bb line'></div>";
                                    }
                                    echo "<div class='form-group'>";
                                    echo "<label class='control-label col-sm-6 col-xs-6'> DP/UM ke-$ctr: </label>";
                                    echo "<div class='control-label col-sm-6 col-xs-6 text-left'>Rp ". number_format($row['bayar'] ,0,',','.') . "</div>";
                                    echo "</div>";
                                    echo "<div class='form-group'>";
                                    echo "<label class='control-label col-sm-6 col-xs-6'> Tgl Bayar: </label>";
                                    echo "<div class='control-label col-sm-6 col-xs-6 text-left'>". $row['tgl_trans'] . "</div>";
                                    echo "</div>";
                                    echo "<div class='form-group'>";
                                    echo "<label class='control-label col-sm-6 col-xs-6'> Karyawan yang Mengurus: </label>";
                                    echo "<div class='control-label col-sm-6 col-xs-6 text-left'>". $row['nama'] . "</div>";
                                    echo "</div>";
                                    
                                    $attributes = array('class' => 'form-horizontal', 'id' => 'edit_dp');
                                    echo form_open('Transaksimaster/edit_nota', $attributes); 
                                    echo "
                                    <div class='col-sm-6 col-xs-6 text-right mb'>
                                    <input type='hidden' value=$row[kd_nota] name='kd_nota'>
                                    <input type='hidden' value=$kd_trans name='kd_trans'>
                                    <button type='submit' id='edit' name='edit' class='btn btn-success'>Edit</button>
                                    </div>
                                    ";
                                    echo form_close();
                                    
                                    $attributes = array('class' => 'form-horizontal', 'id' => 'bayar_cicilan', 'target' => '_blank');
                                    echo form_open('Mid/print_nota_again', $attributes); 
                                    echo "
                                    <div class='col-sm-6 col-xs-6 text-left mb'>
                                    <input type='hidden' value=$row[kd_nota] name='kd_nota'>
                                    <button type='submit' id='edit' name='edit' class='btn btn-success'>Print</button>
                                    </div>
                                    ";
                                    echo form_close();
                                    
                                    $ctr++;
                                    //$jatuh_tempo = $row['jatuh_tempo'];
                                    
                                }
                                
                                
                                echo "<div class='col-sm-8 col-xs-8 col-xs-offset-2 col-sm-offset-2 bb line'></div>";
                                echo "<div class='form-group'>";
                                echo "<label class='control-label col-sm-6 col-xs-6'> Total DP/UM: </label>";
                                echo "<div class='control-label col-sm-6 col-xs-6 text-left'>Rp ". number_format($data_bayar->dp ,0,',','.') ."</div>";
                                echo "</div>";
                                
                                echo "<div class='form-group'>";
                                echo "<label class='control-label col-sm-6 col-xs-6'> Sisa DP/UM: </label>";                                
                                echo "<div class='control-label col-sm-6 col-xs-6 text-left'>Rp ". number_format($header->dp - $data_bayar->dp ,0,',','.') ."</div>";
                                echo "</div>";
                            }else{
                                echo "<div class='col-sm-12 col-xs-12 text-center' > Belum ada data transaksi </div>";
                            }
                        ?>
                        </div>
                       
                    </div>
                <?php
                    }
                    if($show_cicilan == ""){
                  ?>  
                    <div class="header-div col-sm-11 col-sm-offset-1 mt" id="div-detail">
                        <span class="fa fa-list"></span><span>DETAIL ANGSURAN </span>
                    </div>
                    <div class="col-sm-11 col-sm-offset-1 form-horizontal white-bg" id="div-detail-info"> 
                        <?php
                            if(sizeof($subdetail) > 0){
                        ?>
                        <div class="form-group">
                        <?php
                            
                                $ctr=1;
                                $temp_denda = 0;
                                foreach($subdetail as $row){
                                    if($ctr >= 2){
                                        echo "<div class='col-sm-6 col-sm-offset-3 col-xs-6 col-xs-offset-3 bb line'></div>";
                                    }
                                    echo "<div class='form-group'>";
                                    echo "<label class='control-label col-sm-6 col-xs-6'>Angsuran ke-$ctr: </label>";
                                    echo "<div class='control-label col-sm-6 col-xs-6 text-left'>Rp ". number_format($row['bayar'] ,0,',','.') ."</div>";
                                    echo "</div>";
                                    
                                    if($row['denda'] != 0){
                                        echo "<div class='form-group'>";
                                        echo "<label class='control-label col-sm-6 col-xs-6'>Dikenakan Denda: </label>";
                                        echo "<div class='control-label col-sm-6 col-xs-6 text-left'>Rp ". number_format($row['denda'] ,0,',','.')."</div>";
                                        echo "</div>";
                                    }
                                    
                                    echo "<div class='form-group'>";
                                    echo "<label class='control-label col-sm-6 col-xs-6'>Tgl Bayar: </label>";
                                    echo "<div class='control-label col-sm-6 col-xs-6 text-left'>" .$row['tgl_trans'] . "</div>";
                                    echo "</div>";
                                    echo "<div class='form-group'>";
                                    echo "<label class='control-label col-sm-6 col-xs-6'>Karyawan yang Mengurus: </label>";
                                    echo "<div class='control-label col-sm-6 col-xs-6 text-left'>" .$row['nama'] . "</div>";
                                    echo "</div>";
                                    $attributes = array('class' => 'form-horizontal', 'id' => 'edit_cicilan');
                                    echo form_open('Transaksimaster/edit_nota', $attributes); 
                                    echo "
                                    <div class='col-sm-6 col-xs-6 text-right mb'>
                                    <input type='hidden' value=$row[kd_nota] name='kd_nota'>
                                    <input type='hidden' value=$kd_trans name='kd_trans'>
                                    <button type='submit' id='edit' name='edit' class='btn btn-success'>Edit</button>
                                    </div>
                                    ";
                                    echo form_close();
                                    
                                    $attributes = array('class' => 'form-horizontal', 'id' => 'bayar_cicilan', 'target' => '_blank');
                                    echo form_open('Mid/print_nota_again', $attributes); 
                                    echo "
                                    <div class='col-sm-6 col-xs-6 text-left mb'>
                                    <input type='hidden' value=$row[kd_nota] name='kd_nota'>
                                    <button type='submit' id='edit' name='edit' class='btn btn-success'>Print</button>
                                    </div>
                                    ";
                                    echo form_close();
                                    $temp_denda = $row['denda'];
                                    $ctr++;
                                    //$jatuh_tempo = $row['jatuh_tempo'];
                                }
                            
                        ?>
                        </div>
                        
                        <?php
                            } else {
                        ?>
                                <div class='col-sm-12 col-xs-12 text-center mb' > Belum ada data transaksi </div>
                        <?php
                            }
                        ?>
                        <div class='col-sm-6 col-sm-offset-3 col-xs-6 col-xs-offset-3 bb line'></div>
                        <div class="form-group">
                            <label class="control-label col-sm-6 col-xs-6" for="uname">Total Angsuran:</label>
                            <div class="control-label col-sm-6 col-xs-6 text-left"><?="Rp ".  number_format($data_bayar->cicilan,0,",",".") ?></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-6 col-xs-6" for="uname">Total Denda:</label>
                            <div class="control-label col-sm-6 col-xs-6 text-left"><?="Rp ".  number_format($data_bayar->denda,0,",",".") ?></div>
                        </div>
                        
                        
                    </div>
                    
                <?php
                    } 
                    if($show_header == ""){
                ?>
                    <div class="col-sm-11 col-sm-offset-1 white-bg mt text-center" style="font-size:14pt;">
                        <div class="col-sm-6 text-center">
                            <b>SISA</b>
                        </div>
                        <div class="col-sm-6">
                            <b><?="Rp ".  number_format($sisa,0,",",".") ?></b>
                        </div>
                    </div>
                <?php
                    }
                ?>
            </div>
            <div class="row mt col-sm-6">
                <?php
                    if($error_transaksi_show != ""){
                ?>
                <div class="col-sm-11 col-sm-offset-1 form-horizontal white-bg mb text-center"> 
                    <div class="error <?=$error_transaksi_show;?>" style="display:none;" ><?=$error_transaksi;?></div>
                </div>
                
                <?php 
                    }
                    if($show_cash_bayar == ""){
                        $attributes = array('class' => 'form-horizontal', 'id' => 'bayar_cicilan', 'style'=>"display:$show_cash_bayar");
                        echo form_open('Transaksimaster/bayar', $attributes); 
                ?>
                <div class="header-div col-sm-11 col-sm-offset-1 header-div-green">
                    <span class="fa fa-usd"></span><span>PEMBAYARAN</span>
                </div>
                <div class="col-sm-11 col-sm-offset-1 form-horizontal white-bg mb"> 
                    
                    <input type="hidden" name="kd_trans" value="<?=$kd_trans?>" />
                    <input type="hidden" name="nama" value="<?=$header->nama?>" />
                    <input type="hidden" name="tipe_bayar" value="<?=$header->tipe_bayar?>" />
                    <input type="hidden" name="nama_tanah" value="<?=$header->nama_blok. " " .$header->nomor_tanah?>" />
                    <input type="hidden" name="ctr" value="<?=$urutan?>" />
                    <input type="hidden" name="angsuran" value="<?=$angsuran?>"/>
                    <div class="col-sm-12 form-horizontal"> 
                        <div class="form-group">
                            <label class="control-label col-sm-6">Tanggal Jatuh Tempo:</label>
                            <div class="col-sm-6 control-label text-left">
                              <?=$jatuh_tempo;?>

                            </div>
                        </div>
                        <?php
                            $dt = new DateTime();
                            $dt->setTimezone(new DateTimeZone('GMT+7'));
                            
                            if($dt->format("Y-m-d") > date("Y-m-d",strtotime($jatuh_tempo))  && (($header->tipe_bayar == 1 && $angsuran == 1) || ($header->tipe_bayar == 2 && $angsuran == 1))){
                        ?>
                        <div class="form-group">
                            <label class="control-label col-sm-6"></label>
                            <div class="col-sm-6">
                                <div class='alert alert-danger text-center'>Kena denda</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-6">Denda:</label>
                            <div class="col-sm-6">
                              <?php echo form_input(array('name'=>'denda', 'id'=>'denda', 'class'=>'form-control', 'placeholder'=>'Denda keterlambatan'), $denda);?>
                              <?php echo form_error('denda'); ?>
                            </div>
                        </div>
                        <?php
                            } 
                            if($header->tipe_bayar == 0){
                                $temp_denda = 0;
                            }
                            
                            if($temp_denda != 0){
                        ?>
                        <div class="form-group">
                            <label class="control-label col-sm-6">Denda yang harus dibayar bulan ini:</label>
                            <div class="col-sm-6 control-label text-left">
                              <?="Rp ". number_format($temp_denda,0,",",".");?>
                            </div>
                        </div> 
                        <?php
                            }
                        ?>
                        <div class="form-group">
                            <?php
                                if($header->tipe_bayar == 0){
                            ?>
                            <label class="control-label col-sm-6">Cicilan Cash ke-<?=$urutan?>:</label>
                            <?php
                                } else if(($header->tipe_bayar == 1 && $angsuran != 1) || ($header->tipe_bayar == 2 && $angsuran != 1)){
                            ?>
                            <label class="control-label col-sm-6">DP/UM ke-<?=$urutan?>:</label>
                            <?php
                                } else if(($header->tipe_bayar == 1 && $angsuran == 1) || ($header->tipe_bayar == 2 && $angsuran == 1)){
                            ?>
                            <label class="control-label col-sm-6">Angsuran ke-<?=$urutan?>:</label>
                            <?php
                                }
                            ?>
                            <div class="col-sm-6">
                              <?php echo form_input(array('name'=>'bayar', 'id'=>'bayar', 'class'=>'form-control', 'placeholder'=>'Masukkan jumlah uang'), $bayar);?>
                              <?php echo form_error('bayar'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12" style="margin-top:10px;">
                                <button type="submit" name="submit" id="submit" class="btn btn-success center-block">Simpan Pembayaran</button>
                            </div>

                        </div>
                    </div>
                    
                </div>
                <?php
                        echo form_close();
                    }
                ?>
                <?php 
                    if($show_dp == ""){
                        
                ?>
                <div class="header-div col-sm-11 col-sm-offset-1 header-div-green">
                    <span class="fa fa-usd"></span><span>PILIH TIPE PEMBAYARAN</span>
                </div>
                
                <div class="col-sm-11 col-sm-offset-1  form-horizontal white-bg mb"> 
                    <div class="col-xs-12 form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-sm-6">Tipe Bayar:</label>
                            <div class="col-sm-6 ">
                                <select id="cbtipe" name="cbtipe" class="form-control">
                                    <?php
                                        if($dp != 0){
                                    ?>
                                        <option value="cash" >Cash</option>
                                        <option value="angsuran" selected>Angsuran</option>
                                    <?php
                                        }else{
                                    ?>
                                        <option value="cash" selected>Cash</option>
                                        <option value="angsuran" >Angsuran</option>
                                    <?php
                                        }
                                    ?>
                                    
                                </select>

                            </div>

                        </div>
                    </div>
                    <div class="row" >
                        <?php
                            $attributes = array('class' => 'form-horizontal' , 'id'=>'pilih_cash');
                            echo form_open('Transaksimaster/urus_cash', $attributes); 
                        ?>
                        <input type="hidden" name="kd_trans" value="<?=$kd_trans?>"/>
                        <input type="hidden" name="nama" value="<?=$header->nama?>"/>
                        <input type="hidden" name="tipe_bayar" value="<?=$header->tipe_bayar?>"/>
                        <input type="hidden" name="nama_tanah" value="<?=$header->nama_blok. " " .$header->nomor_tanah?>"/>
                            <div class="col-sm-12 form-horizontal"> 
                                <div class="form-group">
                                    <label class="control-label col-sm-6">Bayar:</label>
                                    <div class="col-sm-6 ">
                                        <?php echo form_input(array('name'=>'bayarcash', 'id'=>'bayarcash', 'class'=>'form-control', 'placeholder'=>'Cash yang dibayarkan'), $bayarcash);?>
                                        <?php echo form_error('bayarcash'); ?>

                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-6">Diskon:</label>
                                    <div class="col-sm-6 ">
                                        <?php echo form_input(array('name'=>'diskon1', 'id'=>'diskon1', 'class'=>'form-control', 'placeholder'=>'Diskon yang diberikan'), $diskon1);?>
                                        <?php echo form_error('diskon1'); ?>

                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-6">Cicilan:</label>
                                    <div class="col-sm-6 ">
                                        <?php echo form_input(array('name'=>'cicilan', 'id'=>'cicilan', 'class'=>'form-control', 'placeholder'=>'Cicilan cash berapa bulan'), $cicilan);?>
                                        <?php echo form_error('cicilan'); ?>

                                    </div>

                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button type="submit" name="submit" id="submit" class="btn btn-success center-block">Simpan Pembayaran</button>
                                    </div>

                                </div>
                            </div>

                        <?php
                            echo form_close();
                        ?>
                    </div>
                    <div class="row">
                        <?php
                            $attributes = array('class' => 'form-horizontal' , 'id' => 'bayar_dp', 'style' => 'display:none');
                            echo form_open('Transaksimaster/urus_dp', $attributes); 
                        ?>
                        <input type="hidden" name="kd_trans" value="<?=$kd_trans?>"/>
                        <input type="hidden" name="nama" value="<?=$header->nama?>"/>
                        <input type="hidden" name="tipe_bayar" value="<?=$header->tipe_bayar?>"/>
                        <input type="hidden" name="nama_tanah" value="<?=$header->nama_blok. " " .$header->nomor_tanah?>"/>

                            <div class="col-sm-12 form-horizontal"> 
                                <div class="form-group">
                                    <label class="control-label col-sm-6">DP/UM:</label>
                                    <div class="col-sm-6 ">
                                        <?php echo form_input(array('name'=>'dp', 'id'=>'dp', 'class'=>'form-control', 'placeholder'=>'DP yang harus dibayar'), $dp);?>
                                        <?php echo form_error('dp'); ?>

                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-6">Banyaknya cicilan DP/UM:</label>
                                    <div class="col-sm-6 ">
                                        <?php echo form_input(array('name'=>'cicilan_dp', 'id'=>'cicilan_dp', 'class'=>'form-control', 'placeholder'=>'berapa kali cicilan DP/UM'), $cicilan_dp);?>
                                        <?php echo form_error('cicilan_dp'); ?>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-6">Bayar DP1:</label>
                                    <div class="col-sm-6">
                                        <?php echo form_input(array('name'=>'dp1', 'id'=>'dp1', 'class'=>'form-control', 'placeholder'=>'Cicilan DP/UM pertama'), $dp1);?>
                                        <?php echo form_error('dp1'); ?>

                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="control-label col-sm-6">Diskon:</label>
                                    <div class="col-sm-6 ">
                                        <?php echo form_input(array('name'=>'diskon', 'id'=>'diskon', 'class'=>'form-control', 'placeholder'=>'Besarnya diskon'), $diskon);?>
                                        <?php echo form_error('diskon'); ?>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-6">Angsuran:</label>
                                    <div class="col-sm-6 ">
                                        <?php echo form_input(array('name'=>'angsuran', 'id'=>'angsuran', 'class'=>'form-control', 'placeholder'=>'Angsuran berapa bulan'), $angsuran);?>
                                        <?php echo form_error('angsuran'); ?>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button type="submit" name="submit" id="submit" class="btn btn-success center-block">Simpan Pembayaran</button>
                                    </div>

                                </div>
                            </div>
                        <?php
                                echo form_close();
                        ?>
                    </div>
                </div>
                
                <?php 
                    }
                    if($show_balik == ""){
                    
                        $attributes = array('class' => 'form-horizontal', 'id' => 'bayar_balik_nama');
                        echo form_open('Transaksimaster/balik_nama', $attributes); 
                ?>
                <div class="header-div col-sm-11 col-sm-offset-1 header-div-green ">
                    <span class="fa fa-usd"></span><span>BIAYA BALIK NAMA</span>
                </div>
                <div class="col-sm-11 col-sm-offset-1 form-horizontal white-bg mb"> 
                    <input type="hidden" name="kd_trans" value="<?=$kd_trans?>"/>
                    <input type="hidden" name="nama" value="<?=$header->nama?>"/>
                    <input type="hidden" name="tipe_bayar" value="<?=$header->tipe_bayar?>"/>
                    <input type="hidden" name="nama_tanah" value="<?=$header->nama_blok. " " .$header->nomor_tanah?>"/>
					<input type="hidden" name="ctr" value="<?=count($detail_baliknama)+1?>"/>
                    <div class="col-sm-12 form-horizontal"> 
                        <div class="form-group">
                            <label class="control-label col-sm-6">Biaya Balik Nama/Sertifikat ke-<?=count($detail_baliknama)+1?>:</label>
                            <div class="col-sm-6 ">
                                <?php echo form_input(array('name'=>'balik_nama', 'id'=>'balik_nama', 'class'=>'form-control', 'placeholder'=>'Biaya balik nama'), $balik_nama);?>
                                <?php echo form_error('balik_nama'); ?>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" name="submit" id="submit" class="btn btn-success center-block" style="margin-top:20px;">Simpan Pembayaran</button>
                            </div>

                        </div>
                    </div>
                </div>
                <?php
                        echo form_close();
                    }
                ?>
                <?php 
                    if($show_ppjb == ""){
                    
                        $attributes = array('class' => 'form-horizontal', 'id' => 'bayar_ppjb');
                        echo form_open('Transaksimaster/bayar_ppjb', $attributes); 
                ?>
                    <input type="hidden" name="kd_trans" value="<?=$kd_trans?>"/>
                    <input type="hidden" name="nama" value="<?=$header->nama?>"/>
                    <input type="hidden" name="tipe_bayar" value="<?=$header->tipe_bayar?>"/>
                    <input type="hidden" name="nama_tanah" value="<?=$header->nama_blok. " " .$header->nomor_tanah?>"/>
                
                    <div class="header-div col-sm-11 col-sm-offset-1 header-div-green">
                        <span class="fa fa-usd"></span><span>BAYAR PPJB</span>
                    </div>
                    <div class="col-sm-11 col-sm-offset-1 form-horizontal white-bg mb"> 
                        <div class="form-group">
                            <label class="control-label col-sm-6">Bayar PPJB:</label>
                            <div class="col-sm-6 ">
                                <?php echo form_input(array('name'=>'ppjb', 'id'=>'ppjb', 'class'=>'form-control', 'placeholder'=>'Biaya ppjb'), $ppjb);?>
                                <?php echo form_error('ppjb'); ?>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-6">Karyawan:</label>
                            <div class="col-sm-6 ">
                                <select class="form-control" id="cbagen" name="cbagen">
                                    <?php
                                        foreach($agen as $row){
                                            if($row[kd_kar] == $kd_agen){
                                                echo "<option value='". "$row[kd_kar];$row[nama_role];$row[nama]"."' selected>".$row['nama'] ."</option>";
                                            }else{
                                                echo "<option value='". "$row[kd_kar];$row[nama_role];$row[nama]"."' >".$row['nama'] ."</option>";
                                            }
                                            
                                        }
                                    ?>
                                </select>
                                <?php echo form_error('cbagen'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden"></input>
                            <label class="control-label col-sm-6">Jabatan:</label>
                            <div class="col-sm-6">
                                <div class="control-label text-left" id="lbjabatan"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 mt">
                                <button type="submit" name="submit" id="submit" class="btn btn-success center-block">Simpan Pembayaran</button>
                            </div>

                        </div>
                    </div>
                <?php
                        echo form_close();
                    }
                ?>
                <?php 
                    if($show_header == ""){
                        $attributes = array('class' => 'form-horizontal', 'id' => 'bayar_ppjb');
                        echo form_open('Transaksimaster/hapus_transaksi', $attributes); 
                ?>
                    <input type="hidden" value="<?=$kd_trans?>" name="kd_trans">
                    <div class="header-div col-sm-11 col-sm-offset-1 header-div-red">
                        <span class="fa fa-exclamation"></span><span>HAPUS TRANSAKSI</span>
                    </div>
                    <div class="col-sm-11 col-sm-offset-1 form-horizontal white-bg"> 
                        <div>
                            Penghapusan transaksi akan menyebabkan segala pembayaran yang pernah dilakukan akan hilang dan tanah kavling akan muncul kembali di halaman transaksi baru.
                        </div>
                        <button type="button" class="btn btn-danger center-block mt" data-toggle="modal" data-target="#myModal">Hapus Transaksi</button>
                    </div>
                    <div id="myModal" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Konfirmasi Hapus Transaksi</h4>
                          </div>
                          <div class="modal-body">
                            <p>Apakah Anda yakin untuk menghapus data transaksi ini?</p>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="submit" id="submit" class="btn btn-danger">Ya</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                          </div>
                        </div>

                      </div>
                    </div>
                <?php
                        echo form_close();
                    }
                ?>
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
        $("#cbtipe").ready(tampilkantipe);
        $("#cbtipe").change(tampilkantipe);
        
        $("#bayar").maskMoney({thousands:'.', decimal:',', precision:0});
        $("#dp").maskMoney({thousands:'.', decimal:',', precision:0});
        $("#dp1").maskMoney({thousands:'.', decimal:',', precision:0});
        $("#diskon").maskMoney({thousands:'.', decimal:',', precision:0});
        $("#diskon1").maskMoney({thousands:'.', decimal:',', precision:0});
        $("#denda").maskMoney({thousands:'.', decimal:',', precision:0});
        $("#balik_nama").maskMoney({thousands:'.', decimal:',', precision:0});
        $("#bayarcash").maskMoney({thousands:'.', decimal:',', precision:0});
        $("#ppjb").maskMoney({thousands:'.', decimal:',', precision:0});
        $("#trans_admin2").addClass("active");
        $(".sldown").slideDown();
        $(".slhide").hide();
        $("#div-detail-info").hide();
        $("#div-dp-info").hide();
        $("#div-cicilan-info").hide();
        
        $("#div-header").click(function(){
            $("#div-header-info").slideToggle();
        });
        $("#div-detail").click(function(){
            $("#div-detail-info").slideToggle();
        });
        $("#div-dp").click(function(){
            $("#div-dp-info").slideToggle();
        });
        $("#div-cicilan").click(function(){
            $("#div-cicilan-info").slideToggle();
        });
        $("#cari_nota").click(function(){
            $("#div_cari").slideToggle();
        });
        $("#div-ppjb").click(function(){
            $("#div-ppjb-info").slideToggle();
        });
        $("#div-balik").click(function(){
            $("#div-balik-info").slideToggle();
        });
        $("#cbagen").ready(getrole);
        $("#cbagen").change(getrole);
        
        $("#print_book").click(function(){
            $("#header_info").prop("target", "_blank");
            $("#header_info").attr("action", "<?php echo base_url();echo index_page(); ?>/Mid/print_nota_again");
            $("#header_info").submit();
            $("#header_info").prop("target", "_self");
            $("#header_info").attr("action", "<?php echo base_url();echo index_page(); ?>/Editheader/show_header");
        });
        
        
    });
    
    //cari kode transaksi
    
    var search_kodetrans = function(){
        var keyword = {
            'keyword':$("#cari").val()
        };

        $.ajax({
            url:"<?php echo base_url().index_page();?>/Transaksibayar/search_kdtrans",
            type:"POST",
            data: keyword,
            success:function(msg){
                $arr = msg;
                $temp = "";
                for(var $i=0; $i<$arr.length; $i++){
                    $temp+= "<option value='" + ($arr[$i]["kd_trans"]) + "'>" + ($arr[$i]["nama"])+  "-" + ($arr[$i]["nama_blok"] + " " + $arr[$i]["nomor_tanah"]) + "</option>";
                }
                $("#ls_data").html($temp);

            },
            dataType:"json"
        });
    }
    $("#cari").ready(search_kodetrans);
    $("#cari").keyup(search_kodetrans);
    
      
    //button pilih di klik
    $("#pilih_data").click(function(){
        if($("#ls_data").val() != null){
            $("#kd_trans").val($("#ls_data").val());
            $("#div_cari").slideUp();
        }else{
            $("#err_cari").slideDown();
        }
    });
    var tampilkantipe = function(){
        
        var temp = $("#cbtipe").val();
        
        if(temp == "cash"){
            $("#bayar_dp").hide();
            $("#pilih_cash").slideDown();
            
        } else {
            $("#pilih_cash").css('display','none');
            $("#bayar_dp").slideDown();
        }
    }
    //cari role
    var getrole = function(){
        $temp = $("#cbagen").val().split(";");
        $("#lbjabatan").html($temp[1]);
    }
  </script>

  </body>
</html>
