<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="m-0">Edit User <?= $unit->nama_unit; ?></h4>
        <a href="javascript:history.back()" class="btn btn-secondary btn-sm">Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="<?= site_url('user/update/'.$user->id_user); ?>" method="post">

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" 
                           value="<?= $user->nama; ?>" required>
                </div>

                <div class="form-group">
                    <label>NIP (3 Angka)</label>
                    <input type="text" name="username" 
                           class="form-control" maxlength="3"
                           value="<?= $user->username; ?>" required readonly>
                </div>

                <div class="form-group">
                    <label>Password (kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" name="password" class="form-control" placeholder="******">
                </div>

                <div class="form-group">
                    <label>Pilih Unit</label>
                    <input type="hidden" name="role" class="form-control" value="<?= $user->role; ?>">
                    <input type="hidden" name="id_unit" class="form-control" value="<?= $user->id; ?>">
                    <select class="form-control" name="id_unit_update">
                        <?php foreach($allunit as $u): ?>
                        <option value="<?= $u->id; ?>" <?php if($user->id == $u->id): echo "selected"; endif;?>><?= $u->nama_unit; ?></option>
                        <?php endforeach;?>
                    </select>
                </div>

                <button class="btn btn-primary btn-block">Update User</button>

            </form>

        </div>
    </div>
</div>
