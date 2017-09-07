<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Laporan Transaksi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <?php include 'import.php' ?>
   
</head>
<body>
    <div class="col-sm-10 col-sm-offset-1 pr pl f-arial">
        <table id="tab" class="table table-laporan" cellspacing="0" width="100%">
            <tr>
                <td colspan="7" style="border-top:none; border-bottom:2px solid #2E367C !important">
                    <div class="col-xs-12" style="padding:0px;">
                        <div class="col-xs-2 col-xs-offset-2">
                            <img src="<?php echo base_url(); ?>bootstrap/img/logo.png" class="" id="logo">
                        </div>
                        <div class="col-xs-8 nota-header f-arial">
                            <h4 class="f-montserrat nota-nama">TANAH KAVLING BAMBU KUNING</h4>

                            <div><span class="fa fa-home"></span>Jl. Simo Angin-Angin RT 06 RW 02 Wonoayu, Sidoarjo</div>
                            <div><span class="fa fa-phone"></span>03199891627, 08113255757, 08113350557</div>
                            <div><span class="fa fa-envelope"></span>lucasbk@gmail.com</div>


                        </div>

                    </div>

                </td>
            </tr>
            <tr>
                <td colspan="7">
                    <h4 class="text-center mt f-montserrat blue" style="">Laporan Transaksi</h4>
                </td>
            </tr>
        </table>
        <table id="tab" class="table table-laporan" cellspacing="0" width="100%">
            

              <tr>
                <th>No.</th>
                <th>Jatuh Tempo</th>
                <th>Kode Transaksi</th>
                <th>Kavling</th>
                <th>Blok</th>
                <th>Customer</th>
                <th>Status</th>

              </tr>

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
                                    echo "<td class='error'>" . $row->jatuh_tempo ."</td>";
                                }else{
                                    echo "<td>" . $row->jatuh_tempo ."</td>";
                                }
                            }  else {
                                echo "<td class='text-center'>-</td>";
                            }

                            echo "<td>" . $row->kd_trans ."</td>";
                            echo "<td>" . $row->nama_blok ."</td>";
                            echo "<td>" . $row->nomor_tanah ."</td>";
                            echo "<td>" . $row->nama ." </br>Telp : ". $row->telp. "</br>Alamat : ". $row->alamat." </br>RT/RW : ". $row->rt ." </br>Kelurahan : ". $row->kelurahan ." </br>Kecamatan : ". $row->kecamatan.  "</td>";
                            if($row->status == 0){
                                echo "<td class=' error'>Belum Lunas</td>";    
                            }else{
                                echo "<td class='ok'>Lunas</td>";
                            }

                            echo"</tr>";
                        }   
                    }

                ?>

            </tbody>
        </table>
    </div>
</body>
</html>