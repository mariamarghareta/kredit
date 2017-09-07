<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Laporan Bonus Agen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <?php include 'import.php' ?>
   
</head>
<body>
    
    <div class="col-sm-10 col-sm-offset-1 pr pl f-arial">
        <div class="">
            <table id="tab" class="table table-laporan" cellspacing="0" width="100%">
                <tr>
                    <td colspan="5" style="border-top:none; border-bottom:2px solid #2E367C !important">
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
                    <td colspan="5" class="">
                        <h4 class="text-center mt f-montserrat blue" style="">Laporan Bonus Agen/Sales</h4>
                    </td>
                </tr>    
            </table>
            <table id="tab" class="table table-laporan" cellspacing="0" width="100%">
                        
                
                  <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Kode Transaksi - Tgl. Pembayaran PPJB - Bonus</th>
                    <th>Total Bonus</th>

                  </tr>
                
                <tbody>
                    <?php
                        $date = new DateTime();
                        $date->setTimezone(new DateTimeZone('GMT+7'));
                        $ctr = 1;
                        $total = 0;
                        if(($detail != null)){
                            foreach ($detail as $row)
                            {
                                echo"<tr>";
                                echo "<td>" . $ctr ."</td>";
                                $ctr++;
                                echo "<td>" . $row[0]['nama'] ."</td>";
                                echo "<td>" . $row[0]['nama_role'] ."</td>";

                                echo "<td>";
                                foreach($row[1] as $subrow){
                                     echo "Kavling: " . $subrow['nama_blok'] . " " . $subrow['nomor_tanah']. "</br>Tgl Bayar PPJB: " . $subrow['tgl_bayar'] . "</br>Bonus: Rp " . number_format($subrow['bonus_agen'],0,",",".") . "</br></br>";
                                }
                                echo "</td>";

                                echo "<td class='text-right'>" . number_format($row[0]['total_bonus'],0,",",".")  ."</td>";


                                $total += $row[0]['total_bonus'];
                                echo"</tr>";
                            }   
                        }

                    ?>

                </tbody>
            </table>

         </div>

    </div>
    <div class="col-sm-10 col-sm-offset-1 text-center mt f-arial">
        <h3><?="Total : Rp " . number_format($total,0,",",".")?></h3>
    </div>
</body>
</html>