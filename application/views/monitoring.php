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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                <div class="row">
                    <div class="header-div-plain col-sm-3 col-sm-offset-1 mt" id="div-header">
                        <span class="fa fa-file"></span><span>Sisa Stok Pakan ASD</span>
                    </div>
                    <div class="header-div-plain col-sm-3 col-sm-offset-1 mt" id="div-header">
                        <span class="fa fa-file"></span><span>Kolam A1</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 white-bg col-sm-offset-1 mb text-center">
                        100
                    </div>
                    <div class="col-sm-3 col-sm-offset-1 white-bg mb text-center">
                        <div>
                            Pagi : <span class="fa fa-check"></span>
                        </div>
                        <div>
                            Sore : <span class="fa fa-check"></span>
                        </div>
                        <div>
                            Malam : <span class="fa fa-ban"></span>
                        </div>
                    </div>
                </div>


            </div>


            <div class="<?=$show_update;?>" style="display:none;">
                <div class="header-div-plain col-sm-3 mt" id="div-header">
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
                <span class="fa fa-table"></span><span>DATA PEMBELIAN</span>
            </div>
            <div class="detail-tabel col-sm-12">
                <div class="col-sm-12 pl pr">
                    <div class="table-responsive">
                        <table id="tbkaryawan" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis Pembelian</th>
                                <th>Nama Item</th>
                                <th>Jumlah Item</th>
                                <th>Harga per Item</th>
                                <th>Total</th>
                                <th>Keterangan</th>
                                <th>Ubah</th>
                                <th>Hapus</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>2018-03-01</td>
                                <td>Pakan</td>
                                <td>Vit A</td>
                                <td>100</td>
                                <td>1000</td>
                                <td>100.000</td>
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
