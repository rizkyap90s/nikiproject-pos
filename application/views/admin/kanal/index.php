<div class="clearfix"></div>
<div id="home">
    <div class="container mt-5">
        <?php 
            $flashSuccess = $this->session->flashdata('success');
            if (!empty($flashSuccess)) {
                echo alert_success($this->session->flashdata('success')); 
            }
            $flashFailed = $this->session->flashdata('failed');
            if(!empty($flashFailed)){ 
                echo alert_failed($this->session->flashdata('failed'));
            }
        ?>
        <div class="row">
            <div class="col-sm-4">
                <form method="post" action="<?= $url;?>">
                    <div class="card mt-4 card-rounded">
                        <div class="card-header bg-primary text-white">
                            <?php
                                $id = $this->input->get('id');
                                if (!empty($id)) {
                                    // Your code here
                                ?>
                            <i class="fa fa-edit"></i> kanal
                            <?php }else{?>
                            <i class="fa fa-plus"></i> kanal
                            <?php }?>
                        </div>
                        <div class="card-body">
                            <?php
                            $id = $this->input->get('id');
                            if (!empty($id)) {
                                // Your code here
                            ?>
                            <div class="form-group">
                                <label for="">Nama kanal</label>
                                <input type="text" required class="form-control" value="<?= $edit->kanal;?>"
                                    name="kanal" id="kanal" placeholder="">
                            </div>
                            <input type="hidden" name="id" value="<?= $edit->id;?>">
                            <?php }else{?>
                            <div class="form-group">
                                <label for="">Nama kanal</label>
                                <input type="text" required class="form-control" name="kanal" id="kanal"
                                    placeholder="">
                            </div>
                            <?php }?>
                        </div>
                        <div class="card-footer text-muted">
                            <div class="float-right">
                                <button class="btn btn-primary btn-md"><i class="fa fa-save"></i> Save</button>
                                <?php
                                $id = $this->input->get('id');
                                if (!empty($id)) {
                                    // Your code here
                                ?>
                                <a href="<?= base_url('kanal');?>" class="btn btn-danger btn-md">
                                    <i class="fa fa-angle-double-left"></i> Kembali</a>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-8">
                <div class="card mt-4 card-rounded">
                    <div class="card-header bg-primary text-white">
                        <i class="fa fa-tags"></i> kanal
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="table1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama kanal</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $no =1;
                                        foreach($kat as $r){
                                    ?>
                                    <tr>
                                        <td scope="row"><?= $no;?></td>
                                        <td><?= $r->kanal;?></td>
                                        <td>
                                            <a href="<?= base_url('kanal?id='.$r->id);?>"
                                                class="btn btn-primary btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <?php if($r->id > 1){?>
                                            <a href="<?= base_url('kanal/delete?id='.$r->id);?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="javascript:return confirm('Apakah kanal ingin dihapus ?')">
                                                <i class="fa fa-times"></i>
                                            </a>
                                            <?php }?>
                                        </td>
                                    </tr>
                                    <?php $no++; }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>