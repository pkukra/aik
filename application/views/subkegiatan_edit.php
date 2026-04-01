<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="container mt-4">
    <h4>Edit Sub Kegiatan</h4>

    <form method="post" action="<?= site_url('subkegiatan/update/'.$detail->id_sub); ?>">
        <div class="form-group">
            <label>Nama Unit</label>
            <input type="text" name="nama_subkegiatan" class="form-control" value="<?= $detail->nama_subkegiatan; ?>" required>
            <input type="hidden" name="id_kegiatan" class="form-control" value="<?= $detail->id_kegiatan; ?>" required>
        </div>

        <button class="btn btn-primary btn-block">Update</button>
        <a href="<?= site_url('kegiatan'); ?>" class="btn btn-secondary btn-block mt-2">Kembali</a>
    </form>
</div>
