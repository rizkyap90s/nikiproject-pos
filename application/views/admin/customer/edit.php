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
                <form method="POST" action="<?= base_url('customer/update');?>">
                    <div class="card card-rounded">
                        <div class="card-header bg-primary text-white">
                            <i class="fa fa-user-plus"></i> <?= $title_web;?>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Kode Customer</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?= $edit->kode_customer;?>"
                                        name="kode_customer" id="kode_customer" placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Nama Customer</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?= $edit->nama;?>" name="nama"
                                        id="nama" placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Alamat</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="alamat" id="alamat"
                                        placeholder=""><?= $edit->alamat;?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">HP / WA</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="hp" value="<?= $edit->hp;?>" id="hp"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Keterangan</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="keterangan" id="keterangan"
                                        placeholder=""><?= $edit->keterangan;?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            <div class="float-right">
                                <input type="hidden" value="<?= $edit->id;?>" name="id">
                                <button type="submit" class="btn btn-primary btn-md">
                                    <b><i class="fa fa-save"></i> Submit</b></button>
                                <a href="<?= base_url('customer');?>" class="btn btn-danger btn-md">
                                    <b><i class="fa fa-angle-double-left"></i> Kembali</b></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>