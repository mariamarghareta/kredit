<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Transaksi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <?php include 'import.php' ?>
    <style type="text/css">
        .va td{
            vertical-align:top;
        }
        table td{
            padding:0px;
            margin:0px;
        }
        .body-font{
        
        }
    </style>
</head>
<body style="letter-spacing:0.5px; font-family:rudareg!important;">
    <img src="<?php echo base_url(); ?>bootstrap/img/bg-logo.png" class="img-responsive block-center" id="bg-logo">
    <table style="width:100%; height:11.5cm; border:1px solid #2E367C;" cellpadding="0" class="va">
        <tr>
            <td colspan="2" style="margin-top:0px;">
                <table style="border-bottom:2px solid #2E367C !important; width:95%; margin:10px auto;">
                    <tr>
                        <td style="width:15%;padding:5px;">
                            <img src="<?php echo base_url(); ?>bootstrap/img/logo.png" class="img-responsive block-center" id="logo" style="height:110px; width:auto;">
                        </td>
                        <td style="width:60%; padding-left:20px;padding-top:8px;">
                            <h3 class="f-montserrat nota-nama">TANAH KAVLING BAMBU KUNING</h3>

                            <div><span class="fa fa-home"></span>Jl. Simo Angin-Angin RT 06 RW 02 Wonoayu, Sidoarjo</div>
                            <div><span class="fa fa-phone"></span>03199891627, 08113255757, 08113350557</div>
                            <div><span class="fa fa-envelope"></span>lucasbk@gmail.com</div>
                        </td>
                        <td style="width:15%; vertical-align:top;" >
                            <div class="npl blue-color " style="font-size:10pt; padding-top:20px;">No. Kuitansi:</div>
                            <div class=" npl eng ">Number</div>
                        </td>
                        <td style="width:10%; font-size:9pt; vertical-align:top; padding-top:20px;">
                            <?php echo $obj->kd_nota;?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="width:60%">
                <table id="tab-nota-detail" style="width:80%; margin: 0 auto;" class="va">
                    <tr>
                        <td style="width:40%">
                            <div class="npl blue-color ">Sudah diterima Dari</div>
                            <div class="npl eng"> Received From </div>
                        </td>
                        <td >
                            : <?php echo $obj->nama;?>
                        </td>
                    </tr>
                    <tr>
                        <td >
                            <div class="npl blue-color ">Banyaknya Uang</div>
                            <div class="npl eng"> Amount </div>
                        </td>
                        <td >
                            :
                            <?php
                                $tipenya = substr($kd_nota,0,1);
                                if($tipenya != "N"){
                            ?>
                                    <?php echo "Rp " . number_format($obj->bayar,0,",",".") ;?>
                            <?php
                                } else {
                            ?>
                                    <?php echo "Rp " . number_format($obj->balik_nama,0,",",".") ;?>
                            <?php
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td >
                            <div class="npl blue-color ">Melalui Transfer</div>
                            <div class="npl eng"> Transfer </div>
                        </td>
                        <td>
                            <?php
                                if($obj->is_transfer == 1){
                            ?>
                                : Ya
                            <?php
                                } else {
                            ?>
                                : Tidak
                            <?php
                                }
                            if (strlen($obj->keterangan)>0){
                                print " ($obj->keterangan)";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td >
                            <div class="npl blue-color ">Tipe Pembayaran</div>
                            <div class="npl eng"> Payment Type </div>
                        </td>
                        <td >
                            : 
                            <?php
                                if($tipenya=="D"){
                                    echo "DP ke-" . $ctr->jumlah;
                                } else if($tipenya=="C"){
                                    echo "Cash ke-". $ctr->jumlah;
                                }else if($tipenya=="I"){
                                    echo "Angsuran ke-". $ctr->jumlah;
                                }else if($tipenya=="B"){
                                    echo "Booking";
                                }else if($tipenya=="N"){
                                    echo "Balik Nama ke-" . $ctr->jumlah;
                                }else if($tipenya=="P"){
                                    echo "Bayar PPJB";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td >
                            <div class="npl blue-color">Untuk Pembayaran</div>
                            <div class="npl eng"> For Payment </div>
                        </td>
                        <td >
                            : <?php echo $obj->nama_blok. " " . $obj->nomor_tanah;?>
                        </td>
                    </tr>
                     <?php
                        if($tipenya=="I" && $obj->denda != 0){
                    ?>

                        <tr>
                            <td >
                                <div class="npl blue-color ">Dikenai Denda</div>
                                <div class="npl eng">Fined</div>
                            </td>
                            <td >
                                : Rp <?php echo number_format($obj->denda,0,",",".");?> (Dibayarkan pada pembayaran bulan depan)
                                <div class=" eng"> Fines paid at the next month's payment</div>
                            </td>
                        </tr>

                    <?php
                        }
                    ?>
                </table>
                
               
               
            </td>
            <td style="width:40%">
                <table class="va" style="width:92%; margin: 0 auto;"> 
                    <tr>
                        <td>
                            <div class="npl blue-color">Kode Transaksi</div>
                            <div class="npl eng">Transaction Code</div>
                        </td>
                        <td>
                            : <?php echo $obj->kd_trans;?>
                        </td>
                    </tr>
                    <?php
                        if($tipenya != "N" && $tipenya != "P"){
                    ?>
                        <tr>
                            <td>
                                <div class="npl blue-color">Tgl. Jatuh Tempo</div>
                                <div class="npl eng">The next due date</div>
                            </td>
                            <td>
                                : <?php 
                                        $newDate = new DateTime($obj->jatuh_tempo);
                                        echo $newDate->format('d-m-Y');
                                    ?>
                            </td>
                        </tr>

                    <?php
                        }
                    ?>
                    <tr>
                        <td>
                            <div class="npl blue-color ">Tgl. Pembayaran</div>
                            <div class="npl eng">Payment date</div>
                        </td>
                        <td>
                            : <?php 
                                $tipenya = substr($kd_nota,0,1);
                                if($tipenya == "N"){
                                    $newDate = new DateTime($obj->tgl_balik_nama);
                                    echo $newDate->format('d-m-Y');
                                }else{
                                    $newDate = new DateTime($obj->tgl_trans);
                                    echo $newDate->format('d-m-Y');
                                }

                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="vertical-align:middle;">
                            <div class="blue-color col-xs-10 col-xs-offset-1" style="font-family:rudareg!important;padding-top:20px;">Sidoarjo,</div>
                            <div class="col-xs-12 text-center npl" style="margin-top:60px;">
                                (<?=$obj->nama_karyawan?>)
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
   

</body>
</html>