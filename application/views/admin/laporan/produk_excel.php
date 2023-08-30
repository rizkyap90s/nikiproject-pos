<?php
if($this->input->get('cetak') == 'print'){
  echo '<script>window.print();</script>';
}else{

  header("Pragma: public");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
  header("Content-type:application/vnd.ms-excel");
  header("Content-disposition:attachment;filename=laporan_penjualan_".date('Y-m-d').".xls");
  header("Content-transfer-Encoding: binary ");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Excel</title>
    <?php
if($this->input->get('cetak') == 'print'){?>
    <style>
    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #customers td,
    #customers th {
        border: 1px solid #333;
        padding: 8px;
    }

    #customers tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #customers tr:hover {
        background-color: #ddd;
    }

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        color: #333;
    }
    </style>
    <?php }?>
</head>

<body>
    LAPORAN PENJUALAN<br>
    <?= $periode;?>
    <table id="customers">
        <tr>
            <th>No</th> 
            <th>Waktu</th>
            <th>No Bon</th>
            <th>Cabang</th>
            <th>Atas Nama</th>
            <th>Telepon</th>
            <th>Nama Kasir</th>
            <th>Pesnanan</th>
            <th>Kanal</th>
            <th>Akun Pembayaran</th>
            <th>Status</th>
            <th>Catatan</th>
            <th>Menu</th>
            <th>Harga Jual</th>
            <th>Qty</th>
            <th>Jumlah</th>
            <th>Diskon</th>
            <th>Grand Total</th>
        </tr>
        <?php $no =1; $hj = 0; $hb = 0; $qty = 0; foreach($transaksi as $r){?>
        <tr>
            <td><?= $no;?></td>
            <td><?= $r->created_at;?></td>
            <td><?= $r->no_bon;?></td>
            <td><?= $r->cabang;?></td>
            <td><?= $r->atas_nama;?></td>
            <td><?= $r->hp;?></td>
            <td><?= $r->nama_user;?></td>
            <td><?= $r->pesanan;?></td>
            <td><?= $r->chanel;?></td>
            <td><?= $r->chanel;?></td>
            <td><?= $r->status;?></td>
            <td><?= $r->catatan;?></td>
            <td><?= $r->nama_menu;?></td>
            <td><?= $r->harga_jual;?></td>
            <td><?= $r->qty;?></td>
            <td><?= $r->harga_jual * $r->qty;?></td>
            <td><?= $r->diskon;?></td>
            <td><?= $r->grandtotal;?></td>
        </tr>
        <?php $no++; $hj += $r->harga_jual * $r->qty; $hb += $r->harga_beli * $r->qty; $qty += $r->qty; }?>
        <!-- <tr>
            <th colspan="13">Total</th>
            <th>Rp<?= number_format($hj ?? 0);?></th>
            <th><?= $qty;?></th>
            <th>Rp<?= number_format($hj ?? 0);?></th>
            <th>Keuntungan </th>
            <th colspan="5"> Rp<?= number_format(($hj-$hb) ?? 0);?></th>
        </tr> -->
    </table>
</body>

</html>