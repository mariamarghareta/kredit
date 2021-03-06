<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Master Customer</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>/assets/css/bootstrap.css" rel="stylesheet">
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
            <div class=" <?=$show_insert;?> mt">
                <div class="header-div col-sm-10 col-sm-offset-1" id="div-header">
                    <span class="fa fa-file"></span><span>MASTER CUSTOMER</span>
                </div>
                <div class="col-sm-10 col-sm-offset-1 white-bg">
                    <?php 
                        $attributes = array('class' => 'form-horizontal', 'id' => 'form_blok');
                        echo form_open('Mastercustomeradmin/add_new_data', $attributes); 
                    ?>
                    <div class="col-sm-6 mt">
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="ktp">Nomor KTP:</label>
                            <div class="col-sm-8">
                              <?php echo form_input(array('name'=>'ktp', 'id'=>'ktp', 'class'=>'form-control', 'placeholder'=>'Masukkan nomor KTP'), $ktp);?>
                              <?php echo form_error('ktp'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="nama">Nama:</label>
                            <div class="col-sm-8">
                              <?php echo form_input(array('name'=>'nama', 'id'=>'nama', 'class'=>'form-control', 'placeholder'=>'Masukkan nama pembeli'), $nama);?>
                              <?php echo form_error('nama'); ?>
                            </div>
                          </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="nama">Telepon 1:</label>
                            <div class="col-sm-8">
                              <?php echo form_input(array('name'=>'telp', 'id'=>'telp', 'class'=>'form-control', 'placeholder'=>'Masukkan nomor telepon pembeli'), $telp);?>
                              <?php echo form_error('telp'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="nama">Telepon 2:</label>
                            <div class="col-sm-8">
                              <?php echo form_input(array('name'=>'telp2', 'id'=>'telp2', 'class'=>'form-control', 'placeholder'=>'Masukkan nomor telepon pembeli'), $telp2);?>
                              <?php echo form_error('telp2'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="nama">Telepon 3:</label>
                            <div class="col-sm-8">
                              <?php echo form_input(array('name'=>'telp3', 'id'=>'telp3', 'class'=>'form-control', 'placeholder'=>'Masukkan nomor telepon pembeli'), $telp3);?>
                              <?php echo form_error('telp3'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="nama">Tempat Lahir:</label>
                            <div class="col-sm-8">
                              <?php echo form_input(array('name'=>'tempat', 'id'=>'tempat', 'class'=>'form-control', 'placeholder'=>'Masukkan tempat lahir'), $tempat);?>
                              <?php echo form_error('tempat'); ?>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-sm-6 mt">
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="nama">Tanggal Lahir:</label>
                            <div class="col-sm-8">
                                <div class="date" data-date="" data-date-format="dd-mm-yyyy" data-link-field="dtp_input2" data-link-format="dd-mm-yyyy">
                                    <input class="form-control datepicker"  data-date-format="dd-mm-yyyy" type="text" name="tanggal" style="width:150px" placeholder="dd-mm-yyyy" autocomplete="off" value="<?=$tanggal?>" >
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="nama">Jenis Kelamin:</label>
                            <div class="col-sm-8">
                                <?php
                                    if($gen == 'P'){
                                        $laki=array('id'=>'laki','name'=>'gen', 'value'=>'L');  
                                        $wanita=array('id'=>'wanita','name'=>'gen', 'value'=>'P','checked'=>'checked');  
                                    } else{
                                        $laki=array('id'=>'laki','name'=>'gen', 'value'=>'L', 'checked'=>'checked');  
                                        $wanita=array('id'=>'wanita','name'=>'gen', 'value'=>'P');  
                                    }

                                    echo "<span style='margin-right:20px;'>".form_radio($laki). "Laki-laki </span>";
                                    echo "<span>".form_radio($wanita). "Perempuan </span>";
                                ?>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="control-label col-sm-4" for="nama">Alamat:</label>
                            <div class="col-sm-8">
                                <?php echo form_input(array('name'=>'alamat', 'id'=>'alamat', 'class'=>'form-control', 'placeholder'=>'Masukkan alamat'), $alamat);?>
                                <?php echo form_error('alamat'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="nama">RT/RW:</label>
                            <div class="col-sm-8">
                                <?php echo form_input(array('name'=>'rt', 'id'=>'rt', 'class'=>'form-control', 'placeholder'=>'Masukkan RT dan RW'), $rt);?>
                                <?php echo form_error('rt'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="nama">Kel/Desa:</label>
                            <div class="col-sm-8">
                                <?php echo form_input(array('name'=>'kel', 'id'=>'kel', 'class'=>'form-control', 'placeholder'=>'Masukkan Keluarahan dan Desa'), $kel);?>
                                <?php echo form_error('kel'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="nama">Kecamatan:</label>
                            <div class="col-sm-8">
                                <?php echo form_input(array('name'=>'kec', 'id'=>'kec', 'class'=>'form-control', 'placeholder'=>'Masukkan Kecamatan'), $kec);?>
                                <?php echo form_error('kec'); ?>
                            </div>
                        </div>
                    </div>
                       
                            
                          <div class="form-group"> 
                            <div class="col-sm-12">
                              <button type="submit" class="btn btn-success btn-custom center-block" id="submit" name="submit">Tambahkan Data Baru</button>
                            </div>
                          </div>
                          <div class="form-group"> 
                            <div class="col-sm-12">
                              <?=$msg;?>
                            </div>
                          </div>

                    <?php echo form_close(); ?>   
                </div>
            </div>
            <div class=" mt <?=$show_update;?>">
                <div class="header-div col-sm-10 col-sm-offset-1" id="div-header">
                    <span class="fa fa-pencil"></span><span>EDIT CUSTOMER</span>
                </div>
                <div class="col-sm-10 col-sm-offset-1 white-bg">
                     <?php 
                        $attributes = array('class' => 'form-horizontal', 'id' => 'form_blok');
                        echo form_open('Mastercustomeradmin/update_data', $attributes); 
                    ?>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <?php echo "<input type='hidden' name='kd_cust' id='kd_cust' value=$kd_cust></input>"; ?>
                            <label class="control-label col-sm-4" for="ktp">Nomor KTP:</label>
                            <div class="col-sm-8">
                              <?php echo form_input(array('name'=>'ktp', 'id'=>'ktp', 'class'=>'form-control', 'placeholder'=>'Masukkan nomor KTP'), $ktp);?>
                              <?php echo form_error('ktp'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="nama">Nama:</label>
                            <div class="col-sm-8">
                              <?php echo form_input(array('name'=>'nama', 'id'=>'nama', 'class'=>'form-control', 'placeholder'=>'Masukkan nama pembeli'), $nama);?>
                              <?php echo form_error('nama'); ?>
                            </div>
                          </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="nama">Telepon 1:</label>
                            <div class="col-sm-8">
                              <?php echo form_input(array('name'=>'telp', 'id'=>'telp', 'class'=>'form-control', 'placeholder'=>'Masukkan nomor telepon pembeli'), $telp);?>
                              <?php echo form_error('telp'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="nama">Telepon 2:</label>
                            <div class="col-sm-8">
                              <?php echo form_input(array('name'=>'telp2', 'id'=>'telp2', 'class'=>'form-control', 'placeholder'=>'Masukkan nomor telepon pembeli'), $telp2);?>
                              <?php echo form_error('telp2'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="nama">Telepon 3:</label>
                            <div class="col-sm-8">
                              <?php echo form_input(array('name'=>'telp3', 'id'=>'telp3', 'class'=>'form-control', 'placeholder'=>'Masukkan nomor telepon pembeli'), $telp3);?>
                              <?php echo form_error('telp3'); ?>
                            </div>
                        </div>
                          <div class="form-group">
                            <label class="control-label col-sm-4" for="nama">Tempat Lahir:</label>
                            <div class="col-sm-8">
                              <?php echo form_input(array('name'=>'tempat', 'id'=>'tempat', 'class'=>'form-control', 'placeholder'=>'Masukkan tempat lahir'), $tempat);?>
                              <?php echo form_error('tempat'); ?>
                            </div>
                          </div>
                          
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="nama">Tanggal Lahir:</label>
                            <div class="col-sm-8">
                                <div class="date" data-date="" data-date-format="dd-mm-yyyy" data-link-field="dtp_input2" data-link-format="dd-mm-yyyy">
                                    <input class="form-control datepicker"  data-date-format="dd-mm-yyyy" type="text" name="tanggal" style="width:150px" placeholder="dd-mm-yyyy" autocomplete="off" value="<?=$tanggal?>" >
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="nama">Jenis Kelamin:</label>
                            <div class="col-sm-8">
                                <?php
                                    if($gen == 'P'){
                                        $laki=array('id'=>'laki','name'=>'gen', 'value'=>'L');  
                                        $wanita=array('id'=>'wanita','name'=>'gen', 'value'=>'P', 'checked'=>'checked');  
                                    } else{
                                        $laki=array('id'=>'laki','name'=>'gen', 'value'=>'L', 'checked'=>'checked');  
                                        $wanita=array('id'=>'wanita','name'=>'gen', 'value'=>'P');  
                                    }

                                    echo "<span style='margin-right:20px;'>".form_radio($laki). "Laki-laki </span>";
                                    echo "<span>".form_radio($wanita). "Perempuan </span>";
                                ?>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="control-label col-sm-4" for="nama">Alamat:</label>
                            <div class="col-sm-8">
                                <?php echo form_input(array('name'=>'alamat', 'id'=>'alamat', 'class'=>'form-control', 'placeholder'=>'Masukkan alamat'), $alamat);?>
                                <?php echo form_error('alamat'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="nama">RT/RW:</label>
                            <div class="col-sm-8">
                                <?php echo form_input(array('name'=>'rt', 'id'=>'rt', 'class'=>'form-control', 'placeholder'=>'Masukkan RT dan RW'), $rt);?>
                                <?php echo form_error('rt'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="nama">Kel/Desa:</label>
                            <div class="col-sm-8">
                                <?php echo form_input(array('name'=>'kel', 'id'=>'kel', 'class'=>'form-control', 'placeholder'=>'Masukkan Keluarahan dan Desa'), $kel);?>
                                <?php echo form_error('kel'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="nama">Kecamatan:</label>
                            <div class="col-sm-8">
                                <?php echo form_input(array('name'=>'kec', 'id'=>'kec', 'class'=>'form-control', 'placeholder'=>'Masukkan Kecamatan'), $kec);?>
                                <?php echo form_error('kec'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group"> 
                        <div class="col-sm-12" style="text-align:center;">
                           <button type="submit" class="btn btn-success btn-custom" id="submit" name="submit">Update Data</button>
                           <button type="submit" class="btn btn-warning btn-custom" id="cancel" name="cancel" value="cancel">Batal</button>
                        </div>
                    </div>
                    <div class="form-group"> 
                        <div class="col-sm-12">
                          <?=$msg;?>
                        </div>
                    </div>
                    <?php echo form_close(); ?>   
                </div>
            </div>
        <div class=" mb <?= $show_delete;?>" style="display:none;">
                <div class="header-div col-sm-10 col-sm-offset-1 mt" id="div-header">
                    <span class="fa fa-times"></span><span>HAPUS CUSTOMER</span>
                </div>
                <div class="col-sm-10 col-sm-offset-1 white-bg mb">
                     <?php 
                        $attributes = array('class' => 'form-horizontal', 'id' => 'update_karyawan');
                        echo form_open('Mastercustomeradmin/confirm_del', $attributes); 

                    ?>
                    <div class="col-sm-10 col-sm-offset-1">
                        <h4>Yakin untuk menghapus data ini?</h4>
                        <input type="hidden" value="<?=$kd_cust?>" name="kd_cust" id="kd_cust"/>
                        <div>No. KTP : <?php echo $ktp; ?></div>
                        <div>Nama : <?php echo $nama;?></div>
                        </br>
                        <div class="col-sm-12" style="text-align:center;">
                            <button type="submit" class="btn btn-success btn-custom" id="yes" name="yes" value="yes">Ya</button>
                            <button type="submit" class="btn btn-warning btn-custom" id="cancel" name="cancel" value="cancel">Batal</button>
                        </div>
                    </div>
                    <?php
                        echo form_close();
                    ?>
             </div>
        </div>
        <div class="header-div-plain col-sm-12 mt" id="div-header">
            <span class="fa fa-table"></span><span>DATA CUSTOMER</span>
        </div>
        <div class="detail-tabel col-sm-12">
             <div class="col-sm-12 pl pr">
                <div class="table-responsive">
                    <table id="tab" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>Kode</th>
                            <th>No. KTP</th>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>TTL(dd-mm-yyyy)</th>
                            <th>Gender</th>
                            <th>Alamat</th>
                            <th>Ubah</th>
                            <th>Hapus</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php

                                foreach ($cust as $row)
                                {
                                    echo"<tr>";
                                    echo "<td>" . $row->kd_cust ."</td>";
                                    echo "<td>" . $row->ktp ."</td>";
                                    echo "<td>" . $row->nama ."</td>";
                                    echo "<td>" . $row->telp ."</br>".$row->telp2 ."</br>". $row->telp3 ."</td>";
                                    echo "<td>" . $row->tempat_lahir.", ". $row->tgl_lahir ."</td>";
                                    echo "<td>" . $row->jenis."</td>";
                                    echo "<td>" . $row->alamat. "</br><b>RT/RW:</b> ". $row->rt . "</br><b>Kelurahan:</b> ". $row->kelurahan . "</br><b>Kecamatan:</b> ".  $row->kecamatan ."</td>";
                                    echo "<td>";
                                        echo form_open('Mastercustomeradmin/edit_data'); 
                                        echo "<input type='hidden' name='kd_cust' id='kd_cust' value=$row->kd_cust></input>";
                                        echo "<button type='submit' class='btn btn-info center-block'><span class='glyphicon glyphicon-pencil'></span></button>";
                                        echo form_close();
                                    echo "</td>";
                                        echo form_open('Mastercustomeradmin/delete_data'); 
                                        echo "<input type='hidden' name='kd_cust' id='kd_cust' value=$row->kd_cust></input>";
                                        echo "<td><button type='submit'  class='btn btn-danger center-block'><span class='glyphicon glyphicon-trash'></span></button></td>";
                                        echo form_close();
                                    echo"</tr>";
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
        $("#menu_customer").addClass('active');
        $("#err_msg").addClass('text-center');
        $('#tab').dataTable();
        $(".sldown").slideDown("slow");
        $(".slup").slideUp("slow");
        $(".slfadein").fadeIn("slow");
        $(".slhide").hide();
        $(".slshow").show();
   
   
  </script>

  </body>
</html>
