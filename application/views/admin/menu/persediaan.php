<div class="clearfix"></div>
<div id="home">
    <div class="container mt-5">
        <?php 
            $successFlash = $this->session->flashdata('success');
            if(!empty($successFlash)){  
                echo alert_success($this->session->flashdata('success')); 
            }
            $failedFlash = $this->session->flashdata('failed');
            if(!empty($failedFlash)){ 
                echo alert_failed($this->session->flashdata('failed'));
            }
            
            $sql = "SELECT nama FROM menu WHERE stok <= stok_minim";
            $cek = $this->db->query($sql)->num_rows();
            if($cek > 0){
        ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>
                Ada <?= $cek;?> Menu yang dibawah Stok minim
                <a href="<?= base_url('menu/persediaan?cek=limit');?>" class="text-dark mr-2">Cek Disini</a>
            </strong>
        </div>
        <?php }?>
        <div class="card card-rounded">
            <div class="card-header bg-primary text-white">
                <i class="fa fa-cubes"></i> <?= $title_web;?> <?= $this->input->get('cek') == 'limit' ? 'Limit' : ''?>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-sm table-striped table" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Kode Menu</th>
                                <th>Kategori</th>
                                <th>Nama Menu</th>
                                <th>Stok</th>
                                <th>Stok Minim</th>
                                <?php if($this->session->userdata('ses_level') == 'Admin'){?>
                                <th>Harga Pokok</th>
                                <?php }?>
                                <th>Harga Jual</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
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
            <?php if($this->input->get('cek')){?> "url": "<?= base_url('menu/data_menu?cek=limit');?>", // URL file untuk proses select datanya
            "type": "POST"
            <?php }else{?> "url": "<?= base_url('menu/data_menu');?>", // URL file untuk proses select datanya
            "type": "POST"
            <?php }?>
        },
        "deferRender": true,
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
                "data": "gambar",
                "render": function(data, type, row, meta) {
                    if (data == '-') {
                        return '<center><i class="fa fa-image fa-3x"></i> <br>' +
                            '<small><b> Tidak Ada Gambar !</b></small></center>';
                    } else {
                        return '<div id="portfolio">' +
                            '<div class="portfolio-item">' +
                            '<a href="' + base_url + 'assets/image/produk/' + data +
                            '" class="portfolio-popup">' +
                            '<img src="' + base_url + 'assets/image/produk/' + data +
                            '" style="border-radius:10px 10px 10px 10px;height:70px;width:100%" class="img-fluid"/>' +
                            '<div class="portfolio-overlay">' +
                            '' +
                            '</div>' +
                            '</a>' +
                            '</div>' +
                            '</div>';
                    }
                }
            },
            {
                'data': 'kode_menu'
            },
            {
                'data': 'kategori'
            },
            {
                'data': 'nama'
            },
            {
                'data': 'stok'
            },
            {
                'data': 'stok_minim'
            },
            <?php if($this->session->userdata('ses_level') == 'Admin'){?> {
                data: 'harga_pokok',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            <?php }?> {
                data: 'harga_jual',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                "data": "id",
                "render": function(data, type, row, meta) {
                    return `<a href="${base_url}menu/stok?id=${row.id}" 
                                class="btn btn-primary btn-sm" title="Detail Menu" role="button">
                                <i class="fa fa-plus mr-1"></i> Stok
                            </a>
                            `;
                }
            }
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
</script>