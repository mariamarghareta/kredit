<?php

?>
<div class="col-sm-6">
    
        <ul class="nav navbar-nav navbar-right menu-navbar">
          <li  name="menu_dtanah" id="menu_dtanah" class="active"><a href="<?= base_url();?><?= index_page();?>/Masteradmin">Data Tanah</a></li>
          <li name="menu_mcustomer" id="menu_mcustomer" class=""><a href="<?= base_url();?><?= index_page();?>/Mastercustomeradmin">Master Customer</a></li>
          <li name="menu_mkaryawan" id="menu_mkaryawan" class=""><a href="<?= base_url();?><?= index_page();?>/Masterkaryawan">Master Karyawan</a></li>
          <li name="menu_mtanah" id="menu_mtanah" class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Master Tanah
            <span class="caret"></span></a>
            <ul class="dropdown-menu">  
                <li><a href="<?= base_url();?><?= index_page();?>/Masterblok">Master Blok</a></li>
                <li><a href="<?= base_url();?><?= index_page();?>/Mastertanah">Master Tanah</a></li>
            </ul>
          </li>
        </ul>
    
</div>

