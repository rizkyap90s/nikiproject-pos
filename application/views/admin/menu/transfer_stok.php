<div class="clearfix"></div>
<div id="home">
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-7 mx-auto">
                <?php 
                   $successFlash = $this->session->flashdata('success');
            if(!empty($successFlash)){  
                echo alert_success($this->session->flashdata('success')); 
            }
            $failedFlash = $this->session->flashdata('failed');
            if(!empty($failedFlash)){ 
                echo alert_failed($this->session->flashdata('failed'));
            }
                ?>
                <form action="<?= base_url("menu/transferStock") ?>" method="post">
                <div class="form-group">
    <label for="from_menu_id">From Menu ID</label>
    <div class="input-group">
        <input type="number" class="form-control" id="from_menu_id" name="from_menu_id" required>
        <div class="input-group-append">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modelIdFrom">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="to_menu_id">To Menu ID</label>
    <div class="input-group">
        <input type="number" class="form-control" id="to_menu_id" name="to_menu_id" required>
        <div class="input-group-append">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modelIdTo">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>
</div>

            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" class="form-control" name="quantity" required min="1">
            </div>

            <button type="submit" class="btn btn-primary">Transfer Stock</button>
        </form>

            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div style="padding-bottom:9pc;"></div>

<div class="modal fade" id="modelIdFrom" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fa fa-users"></i> Daftar Menu (From Menu ID)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="example1From" style="font-size:10.5pt" class="table-sm table table-bordered table-striped table" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Kode Menu</th>
                                <th>Kategori</th>
                                <th>Nama Menu</th>
                                <th>Harga Pokok</th>
                                <th>Harga Jual</th>
                                <th>Cabang</th>
                                <th>Stok</th>
                                <th>Stok Minim</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modelIdTo" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fa fa-users"></i> Daftar Menu (To Menu ID)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="example1To" style="font-size:10.5pt" class="table-sm table table-bordered table-striped table" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Kode Menu</th>
                                <th>Kategori</th>
                                <th>Nama Menu</th>
                                <th>Harga Pokok</th>
                                <th>Harga Jual</th>
                                <th>Cabang</th>
                                <th>Stok</th>
                                <th>Stok Minim</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>

var tabel = null;
var base_url = "<?= base_url('');?>";
$(document).ready(function() {
    $.fn.dataTable.ext.errMode = 'none';

    var tableFrom = $('#example1From').DataTable({
        "processing": true,
        "serverSide": true,
        'responsive': true,
        "ordering": true, // Set true agar bisa di sorting
        "order": [
            [0, 'desc']
        ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": "<?= base_url('menu/data_menu');?>", // URL file untuk proses select datanya
            "type": "POST"
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
            <?php if($this->session->userdata('ses_level') == 'Admin'){?> {
                data: 'harga_pokok',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            <?php }?> {
                data: 'harga_jual',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                'data': 'cabang'
            },
            {
                'data': 'stok'
            },
            {
                'data': 'stok_minim'
            },
            {
                "data": "id",
                "render": function(data, type, row, meta) {
                    return `<a href="javascript:void(0)" data-id="${row.id}" 
                                    class="btn btn-info btn-sm pilih_cek" title="Pilih Menu" role="button">
                                    <i class="fa fa-check"></i> Pilih
                                </a>`;
                }
            },
        ],
        "fnDrawCallback": function() {
            $('.portfolio-popup').magnificPopup({
                type: 'image',
                removalDelay: 300,
                mainClass: 'mfp-fade',
                gallery: {
                    enabled: true,
                },
                zoom: {
                    enabled: true,
                    duration: 300,
                    easing: 'ease-in-out',
                    opener: function(openerElement) {
                        return openerElement.is('img') ? openerElement : openerElement
                            .find('img');
                    }
                },
                callbacks: {
                    close: function() {
                        $('#modelId').modal('show');
                    }
                }
            });
            $('.portfolio-popup').click(function(e) {
                $('#modelId').modal('hide');
            });
        }
    });

    var tableTo = $('#example1To').DataTable({
        "processing": true,
        "serverSide": true,
        'responsive': true,
        "ordering": true, // Set true agar bisa di sorting
        "order": [
            [0, 'desc']
        ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": "<?= base_url('menu/data_menu');?>", // URL file untuk proses select datanya
            "type": "POST"
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
            <?php if($this->session->userdata('ses_level') == 'Admin'){?> {
                data: 'harga_pokok',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            <?php }?> {
                data: 'harga_jual',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                'data': 'cabang'
            },
            {
                'data': 'stok'
            },
            {
                'data': 'stok_minim'
            },
            {
                "data": "id",
                "render": function(data, type, row, meta) {
                    return `<a href="javascript:void(0)" data-id="${row.id}" 
                                    class="btn btn-info btn-sm pilih_cek" title="Pilih Menu" role="button">
                                    <i class="fa fa-check"></i> Pilih
                                </a>`;
                }
            },
        ],
        "fnDrawCallback": function() {
            $('.portfolio-popup').magnificPopup({
                type: 'image',
                removalDelay: 300,
                mainClass: 'mfp-fade',
                gallery: {
                    enabled: true,
                },
                zoom: {
                    enabled: true,
                    duration: 300,
                    easing: 'ease-in-out',
                    opener: function(openerElement) {
                        return openerElement.is('img') ? openerElement : openerElement
                            .find('img');
                    }
                },
                callbacks: {
                    close: function() {
                        $('#modelId').modal('show');
                    }
                }
            });
            $('.portfolio-popup').click(function(e) {
                $('#modelId').modal('hide');
            });
        }
    });

});
$('#stok_jml').hide();
$('#example1From tbody').on('click', '.pilih_cek', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                type: 'POST',
                url: '<?= base_url('menu/get_menu');?>',
                data: {
                    'id': id
                },
                dataType: 'json',
                success: function(data) {
                    if (data.errors != null) {
                        console.log(data.errors);
                    } else {
                        // Fill the input fields or perform other actions
                        $('#from_menu_id').val(data[0].id);
                        // Close the modals
                        $('#modelIdFrom, #modelIdTo').modal('hide');
                    }
                }
            });
        });

        $('#example1To tbody').on('click', '.pilih_cek', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                type: 'POST',
                url: '<?= base_url('menu/get_menu');?>',
                data: {
                    'id': id
                },
                dataType: 'json',
                success: function(data) {
                    if (data.errors != null) {
                        console.log(data.errors);
                    } else {
                        // Fill the input fields or perform other actions
                        $('#to_menu_id').val(data[0].id);
                        // Close the modals
                        $('#modelIdFrom, #modelIdTo').modal('hide');
                    }
                }
            });
        });
</script>