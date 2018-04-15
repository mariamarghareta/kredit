<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Master Kavling</title>

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

            <div class="<?=$show_insert;?>">
                <div class="header-div-plain col-sm-8 col-sm-offset-2 mt" id="div-header">
                    <span class="fa fa-file"></span><span>TRANSAKSI PENJUALAN IKAN</span>
                </div>
                <div class="col-sm-8 col-sm-offset-2 white-bg mb">
                    <?php
                    $attributes = array('class' => 'form-horizontal', 'id' => 'form_blok');
                    echo form_open('Masterblok/add_new_data', $attributes);
                    ?>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="tnama">Tanggal Penjualan:</label>
                        <div class="col-sm-6">
                            <?php echo form_input(array('name'=>'tnama', 'id'=>'tnama', 'class'=>'form-control', 'placeholder'=>'Masukkan Tanggal Penjualan'), $tnama);?>
                            <?php echo form_error('tnama'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="tnama">Customer:</label>
                        <div class="col-sm-6">
                            <select class="form-control">
                                <option>Maju Jaya</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="tnama">Kolam:</label>
                        <div class="col-sm-6">
                            <select class="form-control">
                                <option>A1</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="tnama">Tanggal Tebar:</label>
                        <div class="col-sm-6">
                            <label class="col-sm-4" for="tnama">2018-03-01</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="tnama">Jumlah Penjualan:</label>
                        <div class="col-sm-6">
                            <?php echo form_input(array('name'=>'tnama', 'id'=>'tnama', 'class'=>'form-control', 'placeholder'=>'Berapa kg ikan yang dijual'), $tnama);?>
                            <?php echo form_error('tnama'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="tnama">Harga penjualan ikan:</label>
                        <div class="col-sm-6">
                            <?php echo form_input(array('name'=>'tnama', 'id'=>'tnama', 'class'=>'form-control', 'placeholder'=>'Masukkan Harga Jual Ikan per kg'), $tnama);?>
                            <?php echo form_error('tnama'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="tnama">Total:</label>
                        <div class="col-sm-6">
                            <label class="col-sm-4" for="tnama">0</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="tnama">Keterangan:</label>
                        <div class="col-sm-6">
                            <?php echo form_input(array('name'=>'tnama', 'id'=>'tnama', 'class'=>'form-control', 'placeholder'=>'Masukkan Keterangan Tambahan'), $tnama);?>
                            <?php echo form_error('tnama'); ?>
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


            <div class="<?=$show_update;?>" style="display:none;">
                <div class="header-div-plain col-sm-10 col-sm-offset-1 mt" id="div-header">
                    <span class="fa fa-pencil"></span><span>EDIT KAVLING</span>
                </div>
                <div class="col-sm-10 col-sm-offset-1 white-bg">
                    <?php
                    $attributes = array('class' => 'form-horizontal', 'id' => 'update_karyawan');
                    echo form_open('Masterblok/update_data', $attributes);
                    ?>
                    <div class="form-group mb">
                        <label class="control-label col-sm-4" for="nama">Nama Kavling:</label>
                        <div class="col-sm-6">
                            <?php echo "<input type='hidden' name='kd_blok' id='kd_blok' value=$kd_blok></input>"; ?>
                            <?php echo form_input(array('name'=>'nama_bl', 'id'=>'nama_bl', 'class'=>'form-control', 'placeholder'=>'Masukkan nama blok'), $nama_bl);?>
                            <?php echo form_error('nama_bl'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12" style="text-align:center">
                            <button type="submit" class="btn btn-success" id="submit" name="submit">Update Data</button>
                            <button type="submit" class="btn btn-warning" id="cancel" name="cancel" value="cancel">Batal</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <?=$msg;?>
                        </div>
                    </div>

                    <?php echo form_close(); ?>
                </div>
            </div>

            <div class="<?= $show_delete;?>" style="display:none;">
                <div class="header-div-plain col-sm-10 col-sm-offset-1 mt" id="div-header">
                    <span class="fa fa-times"></span><span>HAPUS KAVLING</span>
                </div>
                <div class="col-sm-10 col-sm-offset-1 white-bg">
                    <div class="col-sm-10 col-sm-offset-1">
                        <?php
                        $attributes = array('class' => 'form-horizontal', 'id' => 'update_karyawan');
                        echo form_open('Masterblok/confirm_del', $attributes);
                        ?>
                        <h4>Yakin untuk menghapus data ini?</h4>
                        <input type="hidden" value="<?=$kd_blok?>" name="kd_blok" id="kd-blok"/>
                        <div>Nama Kavling : <?=$nama_bl?></div>
                        </br>
                        <div class="col-sm-12 mb" style="text-align:center;">
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
                <span class="fa fa-table"></span><span>DATA PENJUALAN IKAN</span>
            </div>
            <div class="detail-tabel col-sm-12">
                <div class="col-sm-12 pl pr">
                    <div class="table-responsive">
                        <table id="tbkaryawan" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Customer</th>
                                <th>Kolam</th>
                                <th>Tanggal Tebar</th>
                                <th>Jumlah Ikan Terjual (kg)</th>
                                <th>Harga per Kg</th>
                                <th>Total</th>
                                <th>Keterangan</th>
                                <th>Ubah</th>
                                <th>Hapus</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>2018-03-01</td>
                                <td>Maju Jaya</td>
                                <td>A1</td>
                                <td>2018-01-12</td>
                                <td>500</td>
                                <td>60000</td>
                                <td>30.000.000</td>
                                <td>-</td>
                                <td>
                                    <button type='submit' class='btn btn-info center-block'><span class='glyphicon glyphicon-pencil'></span></button>
                                </td>
                                <td>
                                    <button type='submit'  class='btn btn-danger center-block'><span class='glyphicon glyphicon-trash'></span></button>
                                </td>
                            </tr>

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
<script src="<?php echo base_url(); ?>/assets/js/common-scripts.js"></script>

<!--script for this page-->

<script type="text/javascript">

    $(document).ready(function(){
        $("#menu_bt").addClass('active');
        $("#sub_menu_bt").css("display", "block");
        $("#menu_blok").addClass('active');
        $("#err_msg").addClass('text-center');
        $('#tbkaryawan').dataTable();
        $(".sldown").slideDown("slow");
        $(".slup").slideUp("slow");
        $(".slfadein").fadeIn("slow");
        $(".slhide").hide();
        $(".slshow").show();

    });


</script>

</body>
</html>
