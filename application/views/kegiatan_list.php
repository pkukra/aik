<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="container mt-3">
    <div class=" align-items-center mb-3">
        <div class="row">
            <div class="col-8 ">
                <h4 class="m-0">Kelola Kegiatan</h4>
            </div>
            <div class="col-4 d-flex justify-content-end pr-10">
                <a href="<?= site_url('dashboard'); ?>" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
            <div class="col-12 ">
                <a href="<?= site_url('kegiatan/add'); ?>" class="btn btn-success btn-sm">
                    <i class="fa fa-plus"></i> Kegiatan
                </a>
            </div>
        </div>
    </div>

    <?php if (!empty($list)): ?>
        <div class="row">
            <?php foreach($list as $u): ?>
                <div class="col-12 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">

                            <!-- Baris judul + tombol edit/delete -->
                            <div class="row mb-2">
                                <div class="col-8">
                                    <h5 class="card-title mb-0">
                                        <?php if($u->icon): ?><i class="<?= $u->icon; ?>"></i> <?php endif ?>
                                        <?= $u->nama_kegiatan; ?>
                                    </h5>
                                </div>
                                <div class="col-4 d-flex justify-content-end">
                                    <span class="text-primary">(<?= $u->poin; ?> Poin)</span>
                                </div>
                                <div class="col-12">
                                    <a href="<?= site_url('subkegiatan?id='.$u->id_kegiatan); ?>" 
                                        class="btn btn-success btn-sm mr-1">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                    <a href="<?= site_url('kegiatan/edit/'.$u->id_kegiatan); ?>" 
                                        class="btn btn-primary btn-sm mr-1">
                                        <i class="fa fa-pencil"></i>
                                    </a>

                                    <a href="javascript:void(0)"
                                    class="btn btn-danger btn-sm btn-delete"
                                    data-url="<?= site_url('kegiatan/delete/'.$u->id_kegiatan); ?>"
                                    data-nama="<?= $u->nama_kegiatan; ?>">
                                    <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- Baris subkegiatan -->
                            <div class="row mt-2">
                                <div class="col-12">
                                    <?php foreach($u->sub as $s): ?>
                                        <a href="<?= site_url('Subkegiatan/edit/'.$s->id_sub); ?>" class="btn btn-info btn-sm mb-1">
                                            <?= $s->nama_subkegiatan;?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">Belum ada data Kegiatan.</div>
    <?php endif; ?>
</div>
<!-- Modal Delete -->
<div class="modal fade modal-top" id="deleteModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Konfirmasi Hapus</h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Yakin ingin menghapus kegiatan <b id="namaKegiatan"></b>?</p>
      </div>
      <div class="modal-footer">
        <a href="#" id="btnDelete" class="btn btn-danger btn-sm">
          <i class="fa fa-trash"></i> Hapus
        </a>
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
          Batal
        </button>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
$(document).on('click', '.btn-delete', function () {
    let url  = $(this).data('url');
    let nama = $(this).data('nama');

    $('#btnDelete').attr('href', url);
    $('#namaKegiatan').text(nama);
    $('#deleteModal').modal('show');
});
</script>

