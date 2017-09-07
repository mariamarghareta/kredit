<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Laporan Tanah</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <?php include 'import.php' ?>
   
</head>
<body>
    
    <div class="col-sm-10 col-sm-offset-1 f-arial">
    <table id="tab" class="table " cellspacing="0" width="100%">
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
            <td colspan="5">
                <h4 class="text-center f-montserrat mt blue" style="">Laporan Tanah Kavling</h4>
            </td>
        </tr>    
    </table>
    <table id="tab" class="table " cellspacing="0" width="100%">
                            
        
        <tr>
            <th>No.</th>
            <th>Kavling</th>
            <th>Blok</th>
            <th>Status</th>
            <th>Tgl. Terjual</th>
        </tr>
        
        <tbody>
            <?php
                $date = new DateTime();
                $date->setTimezone(new DateTimeZone('GMT+7'));
                $ctr = 1;
                if(($arr != null)){
                    foreach ($arr as $row)
                    {
                        echo"<tr>";
                        echo "<td>" . $ctr ."</td>";
                        $ctr++;
                        echo "<td>" . $row['nama_blok'] ."</td>";
                        echo "<td>" . $row['nomor_tanah'] ."</td>";

                        if($row['kd_trans'] == null){
                            echo "<td class='error'>Belum Terjual</td>";    
                            echo "<td class='text-center'>-</td>";    
                            
                        }else{
                            echo "<td class='ok'>Terjual</td>";
                            echo "<td class=''>".$row['tgl_bayar']."</td>";    
                            
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