<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Data Karyawan</title>

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
              <div class=" <?=$hide_insert;?>">
                <div class="header-div-plain col-sm-10 col-sm-offset-1 mt" id="div-header">
                    <span class="fa fa-file"></span><span>MASTER KARYAWAN</span>
                </div>
                <div class="col-sm-10 col-sm-offset-1 white-bg ">
                     <?php 
                        $attributes = array('class' => 'form-horizontal', 'id' => 'form_karyawan');
                        echo form_open('Masterkaryawan/add_new_data', $attributes); 
                    ?>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="uname">Username:</label>
                                <div class="col-sm-8">
                                  <?php echo form_input(array('name'=>'uname', 'id'=>'uname', 'class'=>'form-control', 'placeholder'=>'Masukkan username'), $tuname);?>
                                  <?php echo form_error('uname'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="name">Nama:</label>
                                <div class="col-sm-8"> 
                                  <?php echo form_input(array('name'=>'name', 'id'=>'name', 'class'=>'form-control', 'placeholder'=>'Masukkan nama lengkap'), $tname);?>
                                  <?php echo form_error('name'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="alamat">Alamat:</label>
                                <div class="col-sm-8"> 
                                  <?php echo form_input(array('name'=>'alamat', 'id'=>'alamat', 'class'=>'form-control', 'placeholder'=>'Masukkan alamat'), $talamat);?>
                                  <?php echo form_error('alamat'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="telp">Telp:</label>
                                <div class="col-sm-8"> 
                                  <?php echo form_input(array('name'=>'telp', 'id'=>'telp', 'class'=>'form-control', 'placeholder'=>'Masukkan telepon'), $telp);?>
                                  <?php echo form_error('telp'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="pass">Password:</label>
                                <div class="col-sm-6"> 
                                  <?php echo form_password(array('name'=>'pass', 'id'=>'pass', 'class'=>'form-control seepass', 'placeholder'=>'Masukkan password'));?>
                                  <?php echo form_error('pass'); ?>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-info fa fa-eye see" id=""></button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="repass">Masukkan ulang password:</label>
                                <div class="col-sm-6"> 
                                  <?php echo form_password(array('name'=>'repass', 'id'=>'repass', 'class'=>'form-control', 'placeholder'=>'Masukkan ulang password'));?>
                                  <?php echo form_error('repass'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="role">Role:</label>
                                <div class="col-sm-8"> 
                                    <select id="jrole" name="jrole" class="form-control">
                                        <?php
                                            foreach($rolenya as $row){
                                                if($row->kd_role == $jrole){
                                                    echo"<option value='".$row->kd_role."' selected='selected'>$row->nama_role</option>";
                                                }else{
                                                    echo"<option value='".$row->kd_role."'>$row->nama_role</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                    <?php echo form_error('role'); ?>
                                </div>
                            </div>
                        </div>
                          <div class="form-group"> 
                            <div class="col-sm-12">
                              <button type="submit" class="btn btn-success center-block btn-custom" id="submit" name="submit">Tambahkan Data Baru</button>
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
            <div class="<?= $show_update;?>" style="display:none;" >
                <div class="header-div-plain col-sm-10 col-sm-offset-1 mt" id="div-header">
                    <span class="fa fa-pencil"></span><span>EDIT KARYAWAN</span>
                </div>
                <div class="col-sm-10 col-sm-offset-1 white-bg">
                     <?php 
                        $attributes = array('class' => 'form-horizontal', 'id' => 'update_karyawan');
                        echo form_open('Masterkaryawan/update_data', $attributes); 
                    ?>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="uname">Username:</label>
                                <div class="col-sm-8">
                                  <?php echo "<input type='hidden' name='kd_kar' id='kd_kar' value=$kd_kar></input>"; ?>
                                  <?php echo form_input(array('name'=>'uname', 'id'=>'uname', 'class'=>'form-control', 'placeholder'=>'Masukkan username'), $tuname);?>
                                  <?php echo form_error('uname'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="name">Nama:</label>
                                <div class="col-sm-8"> 
                                  <?php echo form_input(array('name'=>'name', 'id'=>'name', 'class'=>'form-control', 'placeholder'=>'Masukkan nama lengkap'), $tname);?>
                                  <?php echo form_error('name'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="alamat">Alamat:</label>
                                <div class="col-sm-8"> 
                                  <?php echo form_input(array('name'=>'alamat', 'id'=>'alamat', 'class'=>'form-control', 'placeholder'=>'Masukkan alamat'), $talamat);?>
                                  <?php echo form_error('alamat'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="telp">Telp:</label>
                                <div class="col-sm-8"> 
                                  <?php echo form_input(array('name'=>'telp', 'id'=>'telp', 'class'=>'form-control', 'placeholder'=>'Masukkan telepon'), $telp);?>
                                  <?php echo form_error('telp'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="pass">Password:</label>
                                <div class="col-sm-6"> 
                                  <?php echo form_password(array('name'=>'pass', 'id'=>'pass', 'class'=>'form-control seepass', 'placeholder'=>'Masukkan password'), $pass);?>
                                  <?php echo form_error('pass'); ?>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-info fa fa-eye see" id=""></button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="repass">Masukkan ulang password:</label>
                                <div class="col-sm-6"> 
                                  <?php echo form_password(array('name'=>'repass', 'id'=>'repass', 'class'=>'form-control', 'placeholder'=>'Masukkan ulang password'), $repass);?>
                                  <?php echo form_error('repass'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="role">Role:</label>
                                <div class="col-sm-8"> 
                                    <select id="jrole" name="jrole" class="form-control">
                                        <?php
                                            foreach($rolenya as $row){
                                                if($row->kd_role == $jrole){
                                                    echo"<option value='".$row->kd_role."' selected='selected'>$row->nama_role</option>";
                                                }else{
                                                    echo"<option value='".$row->kd_role."'>$row->nama_role</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                    <?php echo form_error('role'); ?>
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
            <div class=" <?= $show_delete;?>" style="margin-bottom:30px; display:none;">
                <div class="header-div-plain col-sm-10 col-sm-offset-1 mt" id="div-header">
                    <span class="fa fa-times"></span><span>HAPUS KARYAWAN</span>
                </div>
                <div class="col-sm-10 col-sm-offset-1 pl pr white-bg">
                    <div class="col-sm-10 col-sm-offset-1 mb">
                        <?php 
                            $attributes = array('class' => 'form-horizontal', 'id' => 'update_karyawan');
                            echo form_open('Masterkaryawan/confirm_del', $attributes); 
                        ?>
                        <h4>Yakin untuk menghapus data ini?</h4>

                        <input type="hidden" value="<?php echo $kd_kar; ?>" name="kd_kar" id="kd-kar"></input>

                        <div>Username : <?= $uname?></div>
                        </br>
                        <div class="col-sm-12" style="text-align:center;">
                            <button type="submit" class="btn btn-success btn-custom" id="yes" name="yes" value="yes">Ya</button>
                            <button type="submit" class="btn btn-warning btn-custom" id="cancel" name="cancel" value="cancel">Batal</button>
                        </div>
                        <?php
                            echo form_close();
                        ?>
                    </div>
                    
                 </div>
            </div>
            
            <div class="header-div-plain col-sm-12 mt" id="div-header">
                <span class="fa fa-table"></span><span>DATA KARYAWAN</span>
            </div>
            <div class="detail-tabel col-sm-12">
                <div class="col-sm-12 pl pr">
                    <div class="table-responsive">
                         <table id="tbkaryawan" class="table table-striped table-bordered" cellspacing="0" >
                            <thead>
                              <tr>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Telp</th>
                                <th>Jabatan</th>
                                <th>Ubah</th>
                                <th>Hapus</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($karyawan as $row)
                                    {
                                        echo"<tr>";
                                        echo "<td>" . $row->uname ."</td>";
                                        echo "<td>" . $row->nama ."</td>";
                                        echo "<td>" . $row->alamat ."</td>";
                                        echo "<td>" . $row->telp ."</td>";
                                        echo "<td>" . $row->nama_role ."</td>";
                                        echo "<td>";
                                            echo form_open('Masterkaryawan/edit_data'); 
                                            echo "<input type='hidden' name='kd_kar' id='kd_kar' value=$row->kd_kar></input>";
                                            echo "<button type='submit' class='btn btn-info center-block'><span class='glyphicon glyphicon-pencil'></span></button>";
                                            echo form_close();
                                        echo "</td>";
                                            echo form_open('Masterkaryawan/delete_data'); 
                                            echo "<input type='hidden' name='kd_kar' id='kd_kar' value=$row->kd_kar></input>";
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
    <script src="<?php echo base_url(); ?>/assets/js/common-scripts.js"></script>

    <!--script for this page-->
    
  <script type="text/javascript">
    
    $(document).ready(function(){
        $(document).ready(function(){
            $("#menu_karyawan").addClass('active');
            $("#err_msg").addClass('text-center');
            $('#tbkaryawan').dataTable();
            $(".sldown").slideDown("slow");
            $(".slup").slideUp("slow");
            $(".slfadein").fadeIn("slow");
            $(".slhide").hide();
            $(".slshow").show();
            
        });
    });
    $(".see").click(function(){
        if($(".seepass").attr("type") == "password"){
            $(".seepass").attr("type", "text");
        } else{
            $(".seepass").attr("type", "password");
        }
        
    });
   
  </script>

  </body>
</html>
