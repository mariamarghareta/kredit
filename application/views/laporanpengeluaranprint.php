<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Laporan Pengeluaran</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <?php include 'import.php' ?>
   
</head>
<body>
    
    <div class="col-sm-10 col-sm-offset-1 pr pl f-arial">
        
        <table id="tab" class="table table-laporan" cellspacing="0" width="100%">
            <tr>
                <td colspan="7" class="" style="border-top:none; border-bottom:2px solid #2E367C !important">
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
                    <h4 class="text-center mt mb f-montserrat blue" style="">Laporan Pengeluaran</h4>
                </td>
            </tr>
              <tr>
                <th>No.</th>
                <th>Tanggal Pengeluaran</th>
                <th>Karyawan yang Melakukan Pengeluaran</th>
                <th>Keterangan</th>
                <th>Karyawan Input Data</th>
                <th>Jenis Pengeluaran</th>
                <th>Pengeluaran</th>

              </tr>
            
            <tbody>
                <?php

                    $ctr = 1;
                    $total = 0;
                    if(($arr != null)){
                        foreach ($arr as $row)
                        {
                            echo"<tr>";
                            echo "<td>" . $ctr ."</td>";
                            $ctr++;
                            echo "<td>" . $row['tgl_pengeluaran'] ."</td>";
                            echo "<td>" . $row['penanggung_jawab'] ."</td>";
                            echo "<td>" . $row['keterangan'] ."</td>";
                            echo "<td>" . $row['nama_kar'] ."</td>";
                            echo "<td>" . $row['name'] ."</td>";
                            echo "<td class='text-right'>" . number_format( $row['pengeluaran'],0,",",".")  ."</td>";
                           

                            $total += $row['pengeluaran'];
                            echo"</tr>";
                        }   
                    }

                ?>

            </tbody>
        </table>

         

    </div>
    
    <div class="col-sm-10 col-sm-offset-1 text-center mt f-arial">
        <h3><?="Total : Rp " . number_format($total,0,",",".")?></h3>
    </div>
</body>
</html>