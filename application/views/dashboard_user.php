<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
<?php endif; ?>
<div class="row">
    <div class="col-xs-12 pl-2">
        <div class="panel panel-default">
            <div class="panel-heading">Dashboard</div>
            <div class="panel-body">
                <p>Assalamu Alaikum, 🤝 <h4><?= $this->session->userdata('nama'); ?> </h4></p>
                <!--START-->  
                    <div class="row mt-3 pr-2">
                        <?php if($struktural):?>
                        <div class="col-12 px-3 mb-3">
                            <a href="<?= site_url('user?id='.$struktural); ?>" 
                            class="btn btn-info btn-block py-3"
                            style="border-radius: 10px;">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3 pr-3">
                                        <i class="fa-solid fa-users fa-xl"></i>
                                    </div>
                                    <div class="flex-grow-1 text-left">
                                        Manage Unit
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php if($user_id == 99):?>
                        <div class="col-12 px-3 mb-3">
                            <a href="<?= site_url('laporan'); ?>" 
                            class="btn btn-warning btn-block py-3"
                            style="border-radius: 10px;">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3 pr-3">
                                        <i class="fa-solid fa-scroll fa-xl"></i>
                                    </div>
                                    <div class="flex-grow-1 text-left">
                                        Laporan
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php else: ?>
                        <div class="col-12 px-3 mb-3">
                            <a href="<?= site_url('report?id='.$struktural.'&&m='.date('m').'&&y='.date('Y')); ?>" 
                            class="btn btn-warning btn-block py-3"
                            style="border-radius: 10px;">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3 pr-3">
                                        <i class="fa-solid fa-scroll fa-xl"></i>
                                    </div>
                                    <div class="flex-grow-1 text-left">
                                        Laporan
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php endif;?>
                        <?php if($struktural == '2'):?>
                        <div class="col-12 px-3 mb-3">
                            <a href="<?= site_url('deleteuser'); ?>" 
                            class="btn btn-danger btn-block py-3"
                            style="border-radius: 10px;">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3 pr-3">
                                        <i class="fa-solid fa-scroll fa-xl"></i>
                                    </div>
                                    <div class="flex-grow-1 text-left">
                                        User Dihapus
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php endif;?>
                        <?php endif;?>
                        <div class="col-12 px-3 mb-3">
                            <a href="<?= site_url('aktivitas_user'); ?>" 
                            class="btn btn-success btn-block py-3"
                            style="border-radius: 10px;">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3 pr-3">
                                        <i class="fa-solid fa-book fa-xl"></i>
                                    </div>
                                    <div class="flex-grow-1 text-left">
                                        Kegiatan
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 px-3 mb-3">
                            <a href="<?= site_url('setting?id='.$user_id); ?>" 
                            class="btn btn-secondary btn-block py-3"
                            style="border-radius: 10px;">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3 pr-3">
                                        <i class="fa-solid fa-gear fa-xl"></i>
                                    </div>
                                    <div class="flex-grow-1 text-left">
                                        Account
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 px-3 mb-3">
                            <a href="<?= site_url('chart?id='.$user_id) ?>" 
                            class="btn btn-primary btn-block py-3"
                            style="border-radius: 10px;">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3 pr-3">
                                        <i class="fas fa-chart-line fa-xl"></i>
                                    </div>
                                    <div class="flex-grow-1 text-left">
                                        Perolehan Poin
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- <div class="col-12 px-3 mb-3">
                            <a href="<?= site_url('galery') ?>" 
                            class="btn btn-info btn-block py-3"
                            style="border-radius: 10px;">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3 pr-3">
                                        <i class="fas fa-image fa-xl"></i>
                                    </div>
                                    <div class="flex-grow-1 text-left">
                                        Galery
                                    </div>
                                </div>
                            </a>
                        </div> -->
                        <div class="col-12 px-3 mb-3">
                            <a href="<?= site_url('galery?id='.$user_id) ?>" 
                            class="btn btn-info btn-block py-3"
                            style="border-radius: 10px;">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3 pr-3">
                                        <i class="fas fa-image fa-xl"></i>
                                    </div>
                                    <div class="flex-grow-1 text-left">
                                        Galery
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <!--END-->  
            </div>
        </div>
    </div>
</div>

