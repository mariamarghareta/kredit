<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Laporan Pendapatan</title>
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
                    <h4 class="text-center mt mb f-montserrat blue" style="">Laporan Transaksi</h4>
                </td>
            </tr>
              <tr>
                <th>No.</th>
                <th>Kode Transaksi</th>
                <th>Kavling</th>
                <th>Keterangan</th>
                <th>Total (Rp)</th>

              </tr>
            
            <tbody>
                <?php
                    $date = new DateTime();
                    $date->setTimezone(new DateTimeZone('GMT+7'));
                    $ctr = 1;
                    $total = 0;
                    $tot_transfer = 0;
                    if(sizeof($detail)>0){
                        foreach ($detail as $row)
                        {
                            $ctr_cash = 0; $ctr_cicilan = 0; $ctr_dp = 0; $ctr_bn =0;
                            echo"<tr>";
                            echo "<td>" . $ctr ."</td>";
                            $ctr++;
                            echo "<td>" . $row[0]['kd_trans'] ."</td>";
                            echo "<td>" ;
                            if(substr($row[0]['kd_trans'],0,1) == "M"){echo "-";} else {echo $row[0]['keterangan'];}

                            echo "</td>";
                            echo "<td>";
                            echo "Agen: ". $row[0]['nama_karyawan']."</br></br>";
                            if(sizeof($row[1]) > 0 ){

                                foreach($row[1] as $temp){
                                    if($temp["is_transfer"] == 1){
                                        $temp["is_transfer"] = "Ya";
                                    } else {
                                        $temp["is_transfer"] = "Tidak";
                                    }
                                    if(strlen($temp["catatan"])>0){
                                        $catatan = " (". $temp["catatan"].")";
                                    }else{
                                        $catatan = " (-)";
                                    }
                                    if(substr($temp['kd_nota'],0,1) == "C"){
                                        $ctr_cash += 1;
                                        echo "Cash ke-$ctr_cash: ". number_format($temp['bayar'],0,",",".") ."</br>Tgl. Bayar: ". $temp['tgl_trans'] ."</br> Transfer:". $temp["is_transfer"].$catatan."</br>";
                                    }else if(substr($temp['kd_nota'],0,1) == "I"){
                                        $ctr_cicilan+=1;
                                        echo "Cicilan ke-$ctr_cicilan: ". number_format($temp['bayar'],0,",",".")  ."</br>Tgl. Bayar: ". $temp['tgl_trans'] ."</br> Transfer:". $temp["is_transfer"].$catatan."</br>";
                                    }else if(substr($temp['kd_nota'],0,1) == "B"){
                                        echo "Booking: ". number_format($temp['bayar'],0,",",".")  ."</br>Tgl. Bayar: ". $temp['tgl_trans'] ."</br> Transfer:". $temp["is_transfer"].$catatan."</br>";
                                    }else if(substr($temp['kd_nota'],0,1) == "D"){
                                        $ctr_dp += 1;
                                        echo "DP/UM ke-$ctr_dp: ". number_format($temp['bayar'],0,",",".")  ."</br>Tgl. Bayar: ". $temp['tgl_trans'] ."</br> Transfer:". $temp["is_transfer"].$catatan."</br>";
                                    }else if(substr($temp['kd_nota'],0,1) == "P"){
                                        echo "PPJB: ". number_format($temp['bayar'],0,",",".")  ."</br>Tgl. Bayar: ". $temp['tgl_trans'] ."</br> Transfer:". $temp["is_transfer"].$catatan."</br>";
                                    }else if(substr($temp['kd_nota'],0,1) == "N"){
                                        $ctr_bn += 1;
                                        echo "Balik Nama ke-$ctr_bn: ". number_format($temp['bayar'],0,",",".")  ."</br>Tgl. Bayar: ". $temp['tgl_trans'] ."</br> Transfer:". $temp["is_transfer"].$catatan."</br>";
                                    }

                                    if(substr($temp['kd_nota'],0,1) == "M"){
                                        echo "$temp[keterangan]</br>Tgl. Bayar: $temp[tgl_trans] </br>Transfer: $temp[is_transfer] $catatan</br>Jenis Pemasukan: $temp[name]";
                                    } 
                                     echo "</br>";
                                    if ($temp["is_transfer"] == "Tidak"){
                                        $total += $temp["bayar"];
                                    }else{
                                        $tot_transfer += $temp["bayar"];
                                    }
                                }


                            }
                            echo "</td>";
                            echo "<td class='text-right'>" . number_format($row[0]['bayar'],0,",",".")  ."</td>";



                            //$total += $row[0]['bayar'];
                            echo"</tr>";
                        }   
                    }

                ?>

            </tbody>
        </table>

         

    </div>
    <div class="col-sm-10 col-sm-offset-1 text-center mt f-arial">
        <h3><?="Total Keseluruhan: Rp " . number_format($tot_transfer + $total,0,",",".")?></h3>
        <h3><?="Total (Transfer): Rp " . number_format($tot_transfer,0,",",".")?></h3>
        <h3><?="Pengeluaran: Rp " . number_format($total_pengeluaran,0,",",".")?></h3>
        <h3><?="Total Keseluruhan: Rp " . number_format( $total - $total_pengeluaran,0,",",".")?></h3>
    </div>
</body>
</html>