mysqldump -u mariam34_satria -psatriadev mariam34_satriadev 2>> "/backup/filename_`date '+%Y-%m-%d'`.sql"

mysqldump -u mariam34_satria -psatriadev mariam34_satriadev > /home/mariam34/public_html/$(date +\%Y-\%m-\%d-\%H.\%M.\%S).sql
mysqldump -u mariam34_satria -psatriadev mariam34_satriadev > /home/mariam34/public_html/dev/kredit/backup/$(date +\%Y-\%m-\%d-\%H.\%M.\%S).sql

if(sizeof($cbpilih) > 0 { if(in_array("cash", $cbpilih)){echo "checked";}}

select `satriadev`.`cicilan`.`kd_trans` AS `kd_trans`,`satriadev`.`cicilan`.`tgl_trans` AS `tgl_trans`,`satriadev`.`cicilan`.`bayar` AS `bayar`,`satriadev`.`cicilan`.`kd_nota` AS `kd_nota` , concat(blok.nama_blok, " ", tanah.nomor_tanah) as keterangan
from `satriadev`.`cicilan` , transaksi, tanah, blok
where transaksi.kd_trans = cicilan.kd_trans and transaksi.kd_tanah = tanah.kd_tanah and tanah.kd_blok = blok.kd_blok and transaksi.deleted = 0
union 
select `satriadev`.`dp`.`kd_trans` AS `kd_trans`,`satriadev`.`dp`.`tgl_trans` AS `tgl_trans`,`satriadev`.`dp`.`bayar` AS `bayar`,`satriadev`.`dp`.`kd_nota` AS `kd_nota` , concat(blok.nama_blok, " ", tanah.nomor_tanah) as keterangan
from `satriadev`.`dp` , transaksi, tanah, blok
where transaksi.kd_trans = dp.kd_trans and transaksi.kd_tanah = tanah.kd_tanah and tanah.kd_blok = blok.kd_blok and transaksi.deleted = 0
union 
select `satriadev`.`cash`.`kd_trans` AS `kd_trans`,`satriadev`.`cash`.`tgl_trans` AS `tgl_trans`,`satriadev`.`cash`.`bayar` AS `bayar`,`satriadev`.`cash`.`kd_nota` AS `kd_nota` , concat(blok.nama_blok, " ", tanah.nomor_tanah) as keterangan
from `satriadev`.`cash` , transaksi, tanah, blok
where transaksi.kd_trans = cash.kd_trans and transaksi.kd_tanah = tanah.kd_tanah and tanah.kd_blok = blok.kd_blok and transaksi.deleted = 0
union 
select `satriadev`.`booking`.`kd_trans` AS `kd_trans`,`satriadev`.`booking`.`tgl_trans` AS `tgl_trans`,`satriadev`.`booking`.`bayar` AS `bayar`,`satriadev`.`booking`.`kd_nota` AS `kd_nota` , concat(blok.nama_blok, " ", tanah.nomor_tanah) as keterangan
from `satriadev`.`booking` , transaksi, tanah, blok
where transaksi.kd_trans = booking.kd_trans and transaksi.kd_tanah = tanah.kd_tanah and tanah.kd_blok = blok.kd_blok and transaksi.deleted = 0
union 
select `satriadev`.`balik_nama`.`kd_trans` AS `kd_trans`,`satriadev`.`balik_nama`.`tgl_trans` AS `tgl_trans`,`satriadev`.`balik_nama`.`bayar` AS `bayar`,`satriadev`.`balik_nama`.`kd_nota` AS `kd_nota` , concat(blok.nama_blok, " ", tanah.nomor_tanah) as keterangan
from `satriadev`.`balik_nama` , transaksi, tanah, blok
where transaksi.kd_trans = balik_nama.kd_trans and transaksi.kd_tanah = tanah.kd_tanah and tanah.kd_blok = blok.kd_blok and transaksi.deleted = 0
union 
select `satriadev`.`ppjb`.`kd_trans` AS `kd_trans`,`satriadev`.`ppjb`.`tgl_bayar` AS `tgl_bayar`,`satriadev`.`ppjb`.`bayar` AS `bayar`,`satriadev`.`ppjb`.`kd_nota` AS `kd_nota` , concat(blok.nama_blok, " ", tanah.nomor_tanah) as keterangan
from `satriadev`.`ppjb`, transaksi, tanah, blok
where transaksi.kd_trans = ppjb.kd_trans and transaksi.kd_tanah = tanah.kd_tanah and tanah.kd_blok = blok.kd_blok and transaksi.deleted = 0
union
select null, p.tgl_pemasukan as tgl_bayar, p.pemasukan as bayar, p.kd_pemasukan as kd_nota, p.keterangan
from pemasukan p

select ta.nomor_tanah, bl.nama_blok, DATE_FORMAT(g.tgl_trans, '%d-%m-%Y') as tgl_trans, g.kd_trans, g.kd_nota, g.bayar, g.keterangan
from pendapatan g
LEFT JOIN transaksi t on g.kd_trans = t.kd_trans
left join tanah ta on t.kd_tanah = ta.kd_tanah
LEFT JOIN blok bl on bl.kd_blok = ta.kd_blok
where t.deleted = 0  order by g.tgl_trans