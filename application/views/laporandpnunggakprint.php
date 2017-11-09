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
            <td colspan="11" class="" style="border-top:none; border-bottom:2px solid #2E367C !important">
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
            <td colspan="11">
                <h4 class="text-center mt mb f-montserrat blue" style="">Laporan DP Nunggak</h4>
            </td>
        </tr>
        <tr>
            <th>No.</th>
            <th>No. Transaksi</th>
            <th>Agent</th>
            <th>Kavling</th>
            <th>Block</th>
            <th>Nama</th>
            <th>Tgl. Jatuh Tempo</th>
            <th>Telp.</th>
            <th>Alamat</th>
            <th>Nominal Cicilan</th>
            <th>Denda</th>
            <th>Catatan</th>

        </tr>

        <tbody>
        <?php

        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('GMT+7'));
        $ctr = 1;
        $total = 0;
        if(sizeof($detail) > 0){
            foreach ($detail as $row)
            {
                echo"<tr>";
                echo "<td>" . $ctr ."</td>";
                $ctr++;
                echo "<td>" . $row[0]['kd_trans'] ."</td>";
                echo "<td>" . $row[0]['nama_agen'] ."</td>";
                echo "<td>" . $row[0]['nama_blok'] ."</td>";
                echo "<td>" . $row[0]['nomor_tanah'] ."</td>";
                echo "<td>" . $row[0]['nama_cust'] ."</td>";
                echo "<td>" . $row[0]['jatuh_tempo'] ."</td>";
                echo "<td>" . $row[0]['telp'] ."</td>";
                echo "<td>" . $row[0]['alamat'] ."</td>";
                echo "<td>" . $row[0]['tunggakan'] ."</td>";
                $bulan_telat = $row[0]['bulan_telat'];
                if ($row[0]['bulan_telat'] == 0){$bulan_telat = 1;}
                echo "<td>". $bulan_telat  * $besar_denda ."</td>";

                echo "<td>";
                foreach($row[1] as $subrow){
                    echo "Tgl: $subrow[updated] </br>Catatan : $subrow[keterangan]</br>";
                    $attributes = array('class' => 'form-horizontal', 'id' => 'lihat_detail');
                    echo "</br>";
                }
                echo "</td>";

                echo"</tr>";
            }
        }

        ?>

        </tbody>
    </table>



</div>

</body>
</html>