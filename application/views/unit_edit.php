<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="container mt-4">
    <h4>Edit Unit</h4>

    <form method="post" action="<?= site_url('unit/update/'.$detail->id); ?>">
        <div class="form-group">
            <label>Nama Unit</label>
            <input type="text" name="nama_unit" class="form-control" value="<?= $detail->nama_unit; ?>" required>
        </div>

        <div class="form-group">
            <label>Kode Unit</label>
            <input type="text" name="kode_unit" class="form-control" value="<?= $detail->kode_unit; ?>" required>
        </div>

        <button class="btn btn-primary btn-block">Update</button>
        <a href="<?= site_url('unit'); ?>" class="btn btn-secondary btn-block mt-2">Kembali</a>
    </form>
</div>
