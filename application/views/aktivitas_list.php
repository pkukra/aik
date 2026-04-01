<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="m-0">Aktivitas <?= $kegiatan->nama_kegiatan;?></h4>
        <a href="<?= site_url('aktivitas_user'); ?>" class="btn btn-secondary btn-sm">Kembali</a>
    </div>
    <p style="color:blue;">Bulan <?= date('F')?></p>
    <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="<?= site_url('aktivitas/add?id='.$kegiatan->id_kegiatan); ?>" class="btn btn-success btn-sm">
        <i class="fa fa-plus"></i> Add
    </a>
    </div>
    <table class="table table-bordered">
        <thead>
            <th  hidden>Tanggal</th>
            <th width="40%">Tgl/Jam</th>
            <th width="50%">Nama Aktivitas</th>
            <th width="10%">Aksi</th>
        </thead>
        <tbody>
            <?php if (!empty($list)): ?>
                <?php foreach($list as $u): ?>
                    <tr>
                        <td hidden><?= date('d M Y H:i:s',strtotime($u->created_at));?></td>
                        <td><?= date('d M y H:i',strtotime($u->waktu_aktivitas));?></td>
                        <td>
                            <?= $u->nama_aktivitas;?><?= $u->nama_subkegiatan;?>
                            <?php if (!empty($u->keterangan)): ?><br><b>Keterangan : </b> <?= $u->keterangan;?><?php endif ?>
                            <?php if (!empty($u->filename)): ?>
                                <a href="<?= base_url('uploads/'.$u->filename); ?>" target="_blank">
                                    <img src="<?= base_url('uploads/'.$u->filename); ?>"
                                        alt="gambar"
                                        style="width:80px; height:80px; object-fit:cover; border-radius:6px;">
                                </a>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        
                        <td><a href="<?= site_url('aktivitas/delete/'.$u->id_aktivitas); ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Hapus Aktivitas ini?');">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td class="alert alert-info text-center" colspan="5">Belum ada data Kegiatan.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div>
    
</div>
