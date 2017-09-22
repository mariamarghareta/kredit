<!--sidebar start-->
  <aside>
      <div id="sidebar"  class="nav-collapse ">
          <!-- sidebar menu start-->
          <ul class="sidebar-menu" id="nav-accordion">

              <h5 class="centered"><?php echo strtoupper($_SESSION['uname']);?></h5>

              
              
              <li class="sub-menu" >
                  <a href="<?= base_url();?><?= index_page();?>/Transaksimaster" id="trans_admin2">
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
                  <a href="<?= base_url();?><?= index_page();?>/Masterpemasukan" id="menu_pemasukan" >
                      <i class="fa fa-plus"></i>
                      <span>Transaksi Pemasukan</span>
                  </a>
              </li>
              <li class="sub-menu">
                  <a href="<?= base_url();?><?= index_page();?>/Masterpengeluaran" id="menu_pengeluaran" >
                      <i class="fa fa-money"></i>
                      <span>Transaksi Pengeluaran</span>
                  </a>
              </li>
              <li class="sub-menu">
                  <a href="<?= base_url();?><?= index_page();?>/Masterjenispengeluaran" id="menu_jenis_pengeluaran" >
                      <i class="fa fa-exchange"></i>
                      <span>Master Jenis Pengeluaran</span>
                  </a>
              </li>
              <li class="sub-menu">
                  <a href="<?= base_url();?><?= index_page();?>/Mastercustomeradmin"  id="menu_customer">
                      <i class="fa fa-users"></i>
                      <span>Master Customer</span>
                  </a>
              </li>

              <li class="sub-menu">
                  <a href="<?= base_url();?><?= index_page();?>/Masterkaryawan" id="menu_karyawan" >
                      <i class="fa fa-user"></i>
                      <span>Master Karyawan</span>
                  </a>
              </li>
              <li class="sub-menu">
                  <a class="" href="#" id="menu_bt">
                      <i class="fa fa-pencil"></i>
                      <span>Master Kavling & Blok</span>
                  </a>
                  <ul class="sub" id="sub_menu_bt">
                      <li class="" id="menu_blok"><a  href="<?= base_url();?><?= index_page();?>/Masterblok" >Master Kavling</a></li>
                      <li id="menu_mtanah"><a  href="<?= base_url();?><?= index_page();?>/Mastertanah" >Master Blok</a></li>
                  </ul>
              </li>
              <li class="sub-menu">
                  <a href="<?= base_url();?><?= index_page();?>/Mastertime" id="menu_time" >
                      <i class="fa fa-clock-o"></i>
                      <span>Ubah Timeout Session</span>
                  </a>
              </li>
              <li class="sub-menu">
                  <a href="<?= base_url();?><?= index_page();?>/Changepass" id="menu_pass" >
                      <i class="fa fa-key"></i>
                      <span>Ubah Password</span>
                  </a>
              </li>
              <li class="sub-menu" style="margin-bottom:50px;">
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
                      <li class="" id="menu_penjualan">
                          <a href="<?= base_url();?><?= index_page();?>/Laporanpenjualan" id="">
                              <i class="fa fa-plus"></i>
                              <span>Pendapatan</span>
                          </a>
                      </li>
                      <li class="" id="menu_lappengeluaran">
                          <a href="<?= base_url();?><?= index_page();?>/Laporanpengeluaran" id="">
                              <i class="fa fa-minus"></i>
                              <span>Pengeluaran</span>
                          </a>
                      </li>
                      <li class="" id="menu_bonus">
                          <a href="<?= base_url();?><?= index_page();?>/Laporanbonus" id="">
                              <i class="fa fa-user"></i>
                              <span>Bonus Agen/Sales</span>
                          </a>
                      </li>
                      <li class="" id="menu_dpnunggak">
                          <a href="<?= base_url();?><?= index_page();?>/Laporandpnunggak" id="">
                              <i class="fa fa-book"></i>
                              <span>DP Jatuh Tempo</span>
                          </a>
                      </li>
                      <li class="" id="menu_cicilannunggak">
                          <a href="<?= base_url();?><?= index_page();?>/Laporancicilannunggak" id="">
                              <i class="fa fa-book"></i>
                              <span>Cicilan Jatuh Tempo</span>
                          </a>
                      </li>
                  </ul>
              </li>
          </ul>
          <!-- sidebar menu end-->
      </div>
  </aside>
  <!--sidebar end-->