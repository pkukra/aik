<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="container mt-3">
    <div class=" align-items-center mb-3">
        <div class="row">
            <div class="col-8 ">
                <h4 class="m-0">Kelola Unit</h4>
            </div>
            <div class="col-4 d-flex justify-content-end pr-10">
                <a href="<?= site_url('dashboard'); ?>" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
            <div class="col-12 ">
                <a href="<?= site_url('unit/add'); ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah Unit</a>
            </div>
        </div>
    </div>

    <?php if (!empty($list)): ?>
        <div class="row">
            <?php foreach($list as $u): ?>
                <div class="col-12 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <h5 class="card-title mb-0"><?= $u->nama_unit; ?></h5>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex justify-content-end">
                                        <a href="<?= site_url('user?id='.$u->id); ?>" class="btn btn-success btn-sm mr-1">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                        <a href="<?= site_url('unit/edit/'.$u->id); ?>" class="btn btn-primary btn-sm mr-1">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="#" 
                                        class="btn btn-danger btn-sm btn-delete"
                                        data-id="<?= $u->id; ?>"
                                        data-nama="<?= $u->nama_unit; ?>"
                                        data-toggle="modal"
                                        data-target="#deleteModal">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">Belum ada data unit.</div>
    <?php endif; ?>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Konfirmasi Hapus</h5>
            <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <p>
                Apakah yakin ingin menghapus unit  
                <strong id="namaUnit"></strong>?
            </p>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                Batal
            </button>
            <a href="#" id="btnConfirmDelete" class="btn btn-danger btn-sm">
                Ya, Hapus
            </a>
        </div>
        </div>
    </div>
</div>
<script>
$(document).on('click', '.btn-delete', function () {
    let id   = $(this).data('id');
    let nama = $(this).data('nama');

    $('#namaUnit').text(nama);
    $('#btnConfirmDelete').attr(
        'href',
        '<?= site_url("unit/delete/"); ?>' + id
    );
});
</script>

