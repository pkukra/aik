<div class="row">
    <div class="col-xs-12 pl-2">
        <div class="panel panel-default">
            <div class="panel-heading">Dashboard</div>
            <div class="panel-body">
                <p>Assalamu Alaikum, <a href="<?= site_url('cheat'); ?>">🤝</a> <h4><?= $this->session->userdata('nama'); ?> </h4></p>
                <div class="d-flex justify-content-end align-items-center mb-3 mr-3">
                    <a href="<?= site_url('dashboard'); ?>" class="btn btn-secondary btn-sm">Kembali</a>
                </div>

                <div class="row card mr-3 ml-1 mt-3 mb-3">
                    <div class="card-header alert-primary">
                        <div><b>Poin Bulan <?= $bulan;?> : <?= $persen ?>% (<?= $totbulan ?> / 2000)</div>
                    </div>
                    <div class="card-body">
                        <div class="col-12">
                            

                            <div class="progress mb-3 mr-3" style="height: 28px;" >
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-<?= $barColor ?>"
                                    role="progressbar"
                                    style="width: <?= $persen ?>%; color:#000; font-weight:bold;"
                                    aria-valuenow="<?= $persen ?>"
                                    aria-valuemin="0"
                                    aria-valuemax="100">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    
                </div>
                <!--START-->  
                    <div class="row mt-3 pr-2">
                        <?php $i = 0; ?>
                        <?php foreach($list as $u): ?>
                            <?php 
                                $btnColor = $colors[$i % count($colors)];
                                $i++;
                            ?>
                            <div class="col-12 px-3 mb-3">
                                <a href="<?= site_url('aktivitas?id='.$u->id_kegiatan); ?>" 
                                class="btn btn-<?= $btnColor ?> btn-block py-3"
                                style="border-radius: 10px;">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3 pr-3">
                                            <?php if($u->icon): ?>
                                                <i class="<?= $u->icon; ?> fa-xl"></i>
                                            <?php endif ?>
                                        </div>
                                        <div class="flex-grow-1 text-left">
                                            <?= $u->nama_kegiatan ?>
                                        </div>
                                        <div class="flex-grow-1 text-right">
                                            <span >Total Poin : </span> <?= $u->total ?>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <!--END-->  
            </div>
        </div>
    </div>
</div>