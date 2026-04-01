<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="container mt-3">
    <div class=" align-items-center mb-3">
        <div class="row">
            <div class="col-8 ">
                <h4 class="m-0"><?= $kegiatan->nama_kegiatan;?></h4>
            </div>
            <div class="col-4 d-flex justify-content-end pr-10">
                <a href="<?= site_url('kegiatan'); ?>" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
            <div class="col-12 ">
                <a href="<?= site_url('Subkegiatan/add?id='.$kegiatan->id_kegiatan); ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</a>
            </div>
        </div>
    </div>

    <?php if (!empty($list)): ?>
        <div class="row">
            <?php foreach($list as $u): ?>
                <div class="col-12 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="card-title"><?= $u->nama_subkegiatan; ?></h5>
                                </div>
                                <div class="col-4 d-flex justify-content-end">
                                    <div class="row">
                                        <div class="d-flex justify-content-between">
                                            <a href="<?= site_url('Subkegiatan/edit/'.$u->id_sub); ?>" class="btn btn-primary btn-sm flex-fill mr-1"><i class="fa fa-pencil"></i></a>
                                            <a href="javascript:void(0)"
                                            class="btn btn-danger btn-sm flex-fill ml-1"
                                            data-toggle="modal"
                                            data-target="#modalDelete"
                                            data-id="<?= $u->id_sub; ?>"
                                            data-nama="<?= $u->nama_subkegiatan; ?>">
                                            <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">Belum ada data Sub Kegiatan.</div>
    <?php endif; ?>
</div>
<!-- Modal Delete -->
<div class="modal fade modal-top" id="modalDelete" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body text-center">
                <p>Yakin ingin menghapus sub kegiatan:</p>
                <b id="namaSub"></b>
            </div>

            <div class="modal-footer justify-content-center">
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
$('#modalDelete').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id     = button.data('id');
    var nama   = button.data('nama');

    $('#namaSub').text(nama);
    $('#btnDelete').attr('href', '<?= site_url("Subkegiatan/delete/"); ?>' + id);
});
</script>


