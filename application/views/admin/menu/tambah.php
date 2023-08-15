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
                <form method="POST" action="<?= base_url('menu/store');?>" enctype="multipart/form-data">
                    <div class="card card-rounded">
                        <div class="card-header bg-primary text-white">
                            <i class="fa fa-plus"></i> <?= $title_web;?>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Kode Menu</label>
                                <input type="text" class="form-control" value="<?= $kode;?>" name="kode_menu"
                                    id="kode_menu" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="">Kategori</label>
                                <select class="form-control" name="id_kategori">
                                    <option value="" disabled selected>- pilih -</option>
                                    <?php foreach($kat as $r){?>
                                    <option value="<?= $r->id;?>"><?= $r->kategori;?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Nama Menu</label>
                                <input type="text" class="form-control" name="nama" id="nama" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="">Harga Pokok</label>
                                <input type="number" class="form-control" name="harga_pokok" id="harga_pokok"
                                    placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="">Harga Jual</label>
                                <input type="number" class="form-control" name="harga_jual" id="harga_jual"
                                    placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="">Cabang</label>
                                <select class="form-control" name="id_cabang">
                                    <option value="" disabled selected>- pilih -</option>
                                    <?php foreach($cabang as $r){?>
                                    <option value="<?= $r->id;?>"><?= $r->cabang;?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <textarea class="form-control" name="keterangan" id="keterangan"
                                    placeholder=""></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Gambar</label>
                                <br>
                                <input type="file" class="form-control-file" accept="image/*" name="gambar"
                                    placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="">Stok Minim</label>
                                <br>
                                <input type="number" name="stok_minim" value="" class="form-control" required
                                    placeholder="" />
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            <div class="float-right">
                                <button type="submit" class="btn btn-primary btn-md">
                                    <b><i class="fa fa-save"></i> Submit</b></button>
                                <a href="<?= base_url('menu');?>" class="btn btn-danger btn-md">
                                    <b><i class="fa fa-angle-double-left"></i> Kembali</b></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>