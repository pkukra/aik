<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="container mt-4">
    <h4>Tambah Unit</h4>

    <form method="post" action="<?= site_url('unit/save'); ?>">
        <div class="form-group">
            <label>Nama Unit</label>
            <input type="text" name="nama_unit" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Kode Unit</label>
            <input type="text" name="kode_unit" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success btn-block">Simpan</button>
        <a href="<?= site_url('unit'); ?>" class="btn btn-secondary btn-block mt-2">Kembali</a>
    </form>
</div>
