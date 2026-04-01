<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
    </div>
    <form method="post" action="<?= site_url('cheat/save'); ?>">
    <input type="hidden" name="id_user" value="<?= $user_id?>">
    <p style="color:blue;">Tanggal : <input type="date" name="tanggal" value="<?= date('Y-m-d');?>" class="form-control" style="width:200px"></p>
    <table class="table table-bordered">
    <thead>
        <th>Nama Kegiatan</th>
        <th hidden>Nama Sub Kegiatan</th>
        <th>Aksi</th>
    </thead>
    <tbody>
    <?php foreach($list as $u): ?>
        <tr>
            <td>
                <input type="text"
                        name="kegiatan[<?= $u->id_kegiatan ?>][nama]"
                        value="<?= $u->nama_kegiatan ?>" hidden>
                <?= $u->nama_kegiatan ?>
                <?php if($u->waktu_kegiatan): ?>
                        <input type="time"
                            name="kegiatan[<?= $u->id_kegiatan ?>][waktu]"
                            value="<?= substr($u->waktu_kegiatan,0,5) ?>" hidden>
                    <?php endif; ?>
                </td>

                <td hidden>
                    <?php if($u->sub): foreach($u->sub as $s): ?>
                        <div>
                            <input type="checkbox"
                                name="kegiatan[<?= $u->id_kegiatan ?>][sub][<?= $s->id_sub ?>]"
                                checked>

                            <?= $s->nama_subkegiatan ?>

                            <input type="time"
                                name="kegiatan[<?= $u->id_kegiatan ?>][sub_waktu][<?= $s->id_sub ?>]"
                                value="<?= substr($s->waktu,0,5) ?>" >
                        </div>
                    <?php endforeach; else:?>
                        
                    <?php endif; ?>
            </td>
            <td>
                <input type="checkbox" class="form-control form-control-sm"
                name="kegiatan[<?= $u->id_kegiatan ?>][aktif]"
                value="1"
                <?php if($u->waktu_kegiatan):  ?>checked<?php endif;?>>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<button type="submit" class="btn btn-success btn-block btn-sm form-control">Simpan</button>
<a href="javascript:history.back()" class="btn btn-secondary btn-block btn-sm form-control">Kembali</a>
</form>
</div>
