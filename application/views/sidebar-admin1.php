<!--sidebar start-->
  <aside>
      <div id="sidebar"  class="nav-collapse ">
          <!-- sidebar menu start-->
          <ul class="sidebar-menu" id="nav-accordion">

              <h5 class="centered"><?php echo strtoupper($_SESSION['uname']);?></h5>

              <li class="mt" >
                  <a href="<?= base_url();?><?= index_page();?>/Transaksibayar" id="trans_bayar">
                      <i class="fa fa-money"></i>
                      <span>Bayar Cicilan</span>
                  </a>
              </li>

              <li class="sub-menu">
                  <a href="<?= base_url();?><?= index_page();?>/Transaksiadmin2_baru" id="trans_baru" >
                      <i class="fa fa-usd"></i>
                      <span>Transaksi Baru</span>
                  </a>
              </li>

              <li class="sub-menu">
                  <a href="<?= base_url();?><?= index_page();?>/Mastercustomer" id="master-customer">
                      <i class="fa fa-user"></i>
                      <span>Master Customer</span>
                  </a>
              </li>
              <li class="sub-menu">
                  <a href="<?= base_url();?><?= index_page();?>/Changepass" id="menu_pass" >
                      <i class="fa fa-key"></i>
                      <span>Ubah Password</span>
                  </a>
              </li>
              <li class="sub-menu">
                  <a class="" href="#" id="menu_lap">
                      <i class="fa fa-book"></i>
                      <span>Laporan</span>
                  </a>
                  <ul class="sub" id="sub_menu_lap">
                      <li class="" id="menu_transaksi">
                          <a href="<?= base_url();?><?= index_page();?>/Masteradmin" id="">
                              <i class="fa fa-list"></i>
                              <span>Transaksi</span>
                          </a>
                      </li>
                      <li class="" id="menu_tanah">
                          <a href="<?= base_url();?><?= index_page();?>/Laporantanah" id="">
                              <i class="fa fa-book"></i>
                              <span>Blok</span>
                          </a>
                      </li>
                  </ul>
              </li>
          </ul>
          <!-- sidebar menu end-->
      </div>
  </aside>
  <!--sidebar end-->