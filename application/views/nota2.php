<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Transaksi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include 'import.php' ?>
   
</head>
<body>
    <div class="col-xs-12" style="padding:0px; border-bottom:2px solid #2E367C !important; padding-bottom:20px;margin-bottom:25px;">
        <div class="col-xs-2">
            <img src="<?php echo base_url(); ?>bootstrap/img/logo.png" class="img-responsive block-center" id="logo">
        </div>
        <div class="col-xs-6 nota-header f-arial">
            <h4 class="f-montserrat nota-nama">TANAH KAVLING BAMBU KUNING</h4>

            <div><span class="fa fa-home"></span>Jl. Simo Angin-Angin RT 06 RW 02 Wonoayu, Sidoarjo</div>
            <div><span class="fa fa-phone"></span>08113255757, 08113350557, +623199891627</div>
            <div><span class="fa fa-envelope"></span>lucasbk@gmail.com</div>


        </div>
        <div class="col-xs-4 f-arial sub-header ">
            <div class="col-xs-12"> </div>
            <div class="col-xs-12">
                <div class="col-xs-4 npl bold ">No</div>
                <div class="col-xs-8">: <?php echo $obj->kd_nota;?></div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-4 bt npl bold ">Number</div>
                <div class="col-xs-8"></div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-4 npl bold">Tanggal</div>
                <div class="col-xs-8">: 
                    <?php 
                        $tipenya = substr($kd_nota,0,1);
                        if($tipenya == "N"){
                            $newDate = new DateTime($obj->tgl_balik_nama);
                            echo $newDate->format('d-m-Y');
                        }else{
                            $newDate = new DateTime($obj->tgl_trans);
                            echo $newDate->format('d-m-Y');
                        }

                    ?>
                </div>
            </div>
            <div class="col-xs-12" >
                <div class="col-xs-4 bt npl bold">Date</div>
                <div class="col-xs-8">

                </div>
            </div>
            
            
        </div>
    </div>
    <div class="col-xs-6 f-arial" style="font-size:10pt;">
        <div class="row">
            <div class="col-xs-5 npl blue-color bold">Diterima Dari<span style="float:right;">:</span>
                <div class="npl eng">Received From</div>
            </div>
            <div class="col-xs-7"><?php echo $obj->nama;?></div>
        </div>
        <div class="row">
            <div class="col-xs-5 npl blue-color bold">Banyaknya Uang<span style="float:right;">:</span>
                <div class="col-xs-12 npl eng">Amount of Money</div>
            </div>
            <div class="col-xs-7 ">
                <?php echo "Rp " . number_format($obj->bayar,0,",",".") ;?>
            </div>
        
        </div>
        
        
        
        
        <div class="row">    
            <div class="col-xs-5 npl blue-color bold">Tipe Pembayaran<span style="float:right;">:</span>
                <div class="npl eng">Payment Type</div>
            </div>
            <div class="col-xs-7">
                PPJB
            </div>
        </div>
        <div class="row">    
            <div class="col-xs-5 npl blue-color bold">Nama Agen/Sales<span style="float:right;">:</span>
                <div class="npl eng">Sales/Agent Name</div>
            </div>
            <div class="col-xs-7">
                <?php echo $obj->nama_kar;?>
            </div>
        </div>
        
    </div>
    <div class="col-xs-6 f-arial" style="font-size:10pt;">
        <div class="row">
            <div class="col-xs-5 npl bold blue-color">Kode Transaksi<span style="float:right;">:</span>
                <div class="npl eng">Transaction Code</div>
            </div>
            <div class="col-xs-7"><?php echo $obj->kd_trans;?></div>
        </div>
        <div class="row">
            <div class="col-xs-5  npl blue-color bold">Untuk Pembayaran<span style="float:right;">:</span>
                <div class="npl eng">For Payment</div>
            </div>
            <div class="col-xs-7"><?php echo $obj->nama_blok. " " . $obj->nomor_tanah;?></div>
        </div>
        
        
        
        
        
        <div class="col-xs-12" style="margin-top:38px;">
            <div class="col-xs-12 text-center npl" >
                Sidoarjo,......................
            </div>
            <div class="col-xs-12 text-center npl" style="margin-top:70px;">
                (<?=$obj->nama_karyawan?>)
            </div>
        </div>
    </div>
    

</body>
</html>