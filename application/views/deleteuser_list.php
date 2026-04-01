<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
<?php endif; ?>
<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="m-0">Kelola User Dihapus</h4>
        <<a href="<?= site_url('dashboard'); ?>" class="btn btn-secondary btn-sm">Kembali</a>
    </div>
    <?php if (!empty($list)): ?>
        <table class="table table-bordered table-striped mb-0">
            <thead class="thead-dark">
                <tr>
                    <th >User</th>
                    <th style="width:50%">Nama</th>
                    <th colspan="2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($list)):?>
                    <?php foreach ($list as $u): ?>
                        <tr>
                            <td ><?= $u->username?></td>
                            <td><?= $u->nama?></td>
                            <td><a href="<?= site_url('deleteuser/edit?id='.$u->id_user); ?>"
                                class="btn btn-sm btn-info">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </td>
                            <td><button type="button" class="btn btn-sm btn-danger btn-delete" data-name="<?= $u->nama?>" data-id="<?= $u->id_user?>">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data</td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>        
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
        '<?= site_url("deleteuser/delete/"); ?>' + userId
    );

    $('#deleteModal').modal('show');
});
</script>

