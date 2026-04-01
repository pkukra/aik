<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
<?php endif; ?>
<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="m-0">Kelola User <br>Unit <?= $unit->nama_unit; ?></h4>
        <a href="javascript:history.back()" class="btn btn-secondary btn-sm">Kembali</a>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="<?= site_url('user/add?id='.$unit->id); ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add</a>
    </div>
    <?php if (!empty($list)): ?>
        <div class="row">
            <?php foreach($list as $user): ?>
                <div class="col-12 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-8">
                                    <b><?= $user->nama; ?>
                                    <?php if($user->id_struktural && $user->id_us == $user->id_user):?> <span style="color:red"> (Leader)</span> 
                                    <a href="<?= site_url('user/delete_supervisor/?id='.$user->id_struktural.'&u='.$unit->id); ?>" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> </a>
                                    <?php endif;?></b>
                                </div>
                                <div class="col-4">
                                    <?php if($user->id_user != $user_id):?>
                                    <a href="<?= site_url('user/edit/'.$user->id_user); ?>" class="btn btn-primary btn-sm btn-block"><i class="fa fa-pencil"></i></a>
                                    <a href="#"
                                    class="btn btn-danger btn-sm btn-block btn-delete"
                                    data-id="<?= $user->id_user; ?>"
                                    data-name="<?= $user->nama; ?>">
                                    <i class="fa fa-trash"></i>
                                    </a>
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-2">
                                    <?php if($user->id_us != $user->id_user):?>
                                        <a href="<?= site_url('user/add_supervisor/'.$user->id_user); ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Leader</a>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">Belum ada user yang terdaftar.</div>
    <?php endif; ?>
</div>
<!-- Modal Konfirmasi Hapus -->
<div class="modal fade " id="deleteModal" tabindex="-1" role="dialog">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Konfirmasi Hapus</h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Yakin ingin menghapus user:</p>
        <b id="namaUser"></b>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <a href="#" id="btnConfirmDelete" class="btn btn-danger">Hapus</a>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
$(document).on('click', '.btn-delete', function () {
    let userId = $(this).data('id');
    let userName = $(this).data('name');

    $('#namaUser').text(userName);
    $('#btnConfirmDelete').attr(
        'href',
        '<?= site_url("user/delete/"); ?>' + userId
    );

    $('#deleteModal').modal('show');
});
</script>

