<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="container mt-4">
    <h4>Sub Kegiatan <?= $kegiatan->nama_kegiatan;?></h4>

    <form method="post" action="<?= site_url('subkegiatan/save'); ?>">
        <div class="form-group">
            <label>Nama Sub Kegiatan</label>
            <input type="text" name="nama_subkegiatan" class="form-control" required>
            <input type="hidden" name="id_kegiatan" class="form-control" value="<?= $kegiatan->id_kegiatan; ?>" >
        </div>

        <button type="submit" class="btn btn-success btn-block">Simpan</button>
        <a href="<?= site_url('subkegiatan?id='.$kegiatan->id_kegiatan); ?>" class="btn btn-secondary btn-block mt-2">Kembali</a>
    </form>
</div>
