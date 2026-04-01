<div class="row">
    <div class="col-xs-12 pl-2">
        <div class="panel panel-default">
            <div class="panel-heading">Dashboard</div>
            <div class="panel-body">
                <p>Assalamu Alaikum, 🤝 <h4><?= $this->session->userdata('nama'); ?> </h4></p>
                <!--START-->  
                    <div class="row mt-3 pr-2">
                        <div class="col-12 px-3 mb-3">
                            <a href="<?= site_url('unit'); ?>" 
                            class="btn btn-primary btn-block py-3"
                            style="border-radius: 10px;">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3 pr-3">
                                        <i class="fa-solid fa-users fa-xl"></i>
                                    </div>
                                    <div class="flex-grow-1 text-left">
                                        Manage User
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 px-3 mb-3">
                            <a href="<?= site_url('kegiatan'); ?>" 
                            class="btn btn-success btn-block py-3"
                            style="border-radius: 10px;">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3 pr-3">
                                        <i class="fa-solid fa-book fa-xl"></i>
                                    </div>
                                    <div class="flex-grow-1 text-left">
                                        Manage Kegiatan
                                    </div>
                                </div>
                            </a>
                        </div>
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
                    </div>
                <!--END-->  
            </div>
        </div>
    </div>
</div>

