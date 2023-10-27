<div class="clearfix"></div>
<div id="home">
    <div class="container-fluid mt-5">
        <!-- Button trigger modal -->
        <div class="row">
            <div class="col-md-9">
                <button type="button" class="btn btn-primary btn-md mt-2" data-toggle="modal"
                    data-target="#modelIdFilter">
                    <i class="fa fa-search"></i> Pencarian
                </button>
                <a href="<?= $urlexcel;?>" class="btn btn-success mt-2 btn-md ml-1">
                    <i class="fa fa-download"></i> File Excel
                </a>
                <?php if($this->input->get('a', true)){?>
                <a href="<?= $urlexcel;?>&cetak=print" target="_blank" class="btn btn-primary mt-2 btn-md ml-1">
                    <i class="fa fa-print"></i> Cetak
                </a>
                <?php }else{?>
                <a href="<?= $urlexcel;?>?cetak=print" target="_blank" class="btn btn-primary mt-2 btn-md ml-1">
                    <i class="fa fa-print"></i> Cetak
                </a>
                <?php }?>
                <a href="<?= base_url('laporan');?>" class="btn btn-warning mt-2 btn-md ml-1">
                    <i class="fa fa-refresh"></i> Refresh
                </a>
            </div>
            <div class="col-md-3">
                <!-- <form method="GET" action="">
                    <div class="form-group">
                        <input type="text" name="nama" id="nama" value="<?= $this->input->get('nama');?>"
                            class="form-control" placeholder="Cari Nama Produk">
                    </div>
                </form> -->
            </div>
        </div>
        <div class="clearfix"></div>
        <br>
        <?php 
            $flashSuccess = $this->session->flashdata('success');
            $flashFailed = $this->session->flashdata('failed');
            if(!empty($flashSuccess)){  
                echo alert_success($this->session->flashdata('success')); 
            }
            if(!empty($flashFailed)){ 
                echo alert_failed($this->session->flashdata('failed'));
            }
        ?>
        <div class="card card-rounded">
            <div class="card-header bg-primary text-white">
                <i class="fa fa-cubes"></i> <?= $title_web;?>
                <?= $periode;?>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-sm table-striped table" width="100%">
                        <thead>
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
                                <th>Diskon(%)</th>
                                <th>Diskon(Rp)</th>
                                <th>Grand Total</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <!-- <tfoot>
                            <tr>
                                <th colspan="4">Total</th>
                                <th><?= $total->qty;?></th>
                                <th>Rp<?= number_format(isset($total->hb) ? $total->hb : 0); ?>,-</th>
                                <th>Rp<?= number_format(isset($total->hj) ? $total->hj : 0); ?>,-</th>
                                <th>Keuntungan </th>
                                <th colspan="5">
                                    Rp<?= number_format((isset($total->hj) && isset($total->hb)) ? ($total->hj - $total->hb) : 0); ?>,-
                                </th>
                            </tr>
                        </tfoot> -->
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modelIdFilter" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-search"></i> Pencarian Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="GET" action="<?= base_url('laporan/produk');?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Tanggal Start</label>
                        <input type="date" required class="form-control" value="<?= $this->input->get('a')?>" name="a"
                            placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal End</label>
                        <input type="date" required class="form-control" value="<?= $this->input->get('b')?>" name="b"
                            placeholder="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
    $isAtrue = $this->input->get('a',true);
    if(!empty($isAtrue)){
        $url = base_url('laporan/data_produk?a='.$this->input->get('a').'&b='.$this->input->get('b'));
    }else{
        $url = base_url('laporan/data_produk');
    }
    // if(!empty($this->input->get('a'))){
    //     if(!empty($this->input->get('nama'))){
    //         $url = base_url('laporan/data_produk?nama='.$this->input->get('nama').'&a='.$this->input->get('a').'&b='.$this->input->get('b'));
    //     }else{
    //         $url = base_url('laporan/data_produk?a='.$this->input->get('a').'&b='.$this->input->get('b'));
    //     }
    // }else{
    //     if(!empty($this->input->get('nama'))){
    //         $url = base_url('laporan/data_produk?nama='.$this->input->get('nama'));
    //     }else{
    //         $url = base_url('laporan/data_produk');
    //     }
    // }
?>
<script>
var tabel = null;
var base_url = "<?= base_url('');?>";
$(document).ready(function() {
    $.fn.dataTable.ext.errMode = 'none';
    tabel = $('#example1').DataTable({
        "processing": true,
        "serverSide": true,
        'responsive': true,
        "ordering": true, // Set true agar bisa di sorting
        "order": [
            [0, 'desc']
        ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": "<?= $url;?>", // URL file untuk proses select datanya
            "type": "POST"
        },
        <?php 
        $getName = $this->input->get('nama');
        if(!empty($getName)){?> "search": {
            "search": "<?= $this->input->get('nama');?>"
        },
        <?php }?> "deferRender": true,
        "aLengthMenu": [
            [10, 25, 50, 100, 150],
            [10, 25, 50, 100, 150]
        ], // Combobox Limit
        "columns": [{
                "data": 'id',
                "sortable": false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                'data': 'created_at'
            },
            {
                'data': 'no_bon'
            },
            {
                'data': 'cabang'
            },
            {
                'data': 'atas_nama'
            },
            {
                'data': 'hp'
            },
            {
                'data': 'nama_user'
            },
            {
                "data": "pesanan",
                "render": function(data, type, row, meta) {
                    if (row.pesanan == 'Ditempat') {
                        return '<span class="badge badge-primary"><i class="fa fa-home"> </i> ' +
                            row.pesanan +
                            '</span>';
                    }
                    if (row.pesanan == 'Delivery') {
                        return '<span class="badge badge-success"><i class="fa fa-motorcycle"> </i> ' +
                            row.pesanan +
                            '</span>';
                    }
                    if (row.pesanan == 'Booking') {
                        return '<span class="badge badge-warning"><i class="fa fa-ticket"> </i> ' +
                            row.pesanan +
                            '</span>';
                    }
                }
            },
            {
                'data': 'kanal'
            },
            {
                'data': 'pembayaran'
            },
            {
                "data": "status",
                "render": function(data, type, row, meta) {
                    if (row.status == 'Bayar Nanti') {
                        return '<span class="badge badge-danger"><i class="fa fa-info-circle"> </i> ' +
                            row.status +
                            '</span>';
                    } else {
                        return '<span class="badge badge-success"><i class="fa fa-check"> </i> ' +
                            row.status +
                            '</span>';
                    }
                }
            },
            {
                'data': 'catatan'
            },
            {
                'data': 'nama_menu'
            },
            {
                'data': 'harga_jual'
            },
            {
                'data': 'qty'
            },
            {
                data: 'harga_jual',
                "render": function(data, type, row, meta) {
                    return 'Rp' + number_format(row.harga_jual * row.qty) + ',-';
                }
            },
            {
                data: 'diskon',
                "render": function(data, type, row, meta) {
                    return number_format(row.diskon) + '%';
                }
            },
            {
                data: 'voucher',
                "render": function(data, type, row, meta) {
                    return 'Rp' + number_format(row.voucher);
                }
            },
            {
                data: 'grandtotal',
                "render": function(data, type, row, meta) {
                    return 'Rp' + number_format(row.grandtotal) + ',-';
                }
            },
            
        ],
        "fnDrawCallback": function() {
            $('.portfolio-popup').magnificPopup({
                type: 'image',
                removalDelay: 300,
                mainClass: 'mfp-fade',
                gallery: {
                    enabled: true
                },
                zoom: {
                    enabled: true,
                    duration: 300,
                    easing: 'ease-in-out',
                    opener: function(openerElement) {
                        return openerElement.is('img') ? openerElement : openerElement
                            .find('img');
                    }
                }
            });
        }
    });
});

function number_format(number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}
</script>