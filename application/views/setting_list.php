<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="m-0">Setting User</h4>
        <a href="javascript:history.back()" class="btn btn-secondary btn-sm ">Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="<?= site_url('setting/update/'.$user->id_user); ?>" method="post">

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
                    <input type="text" class="form-control" value="<?= $user->nama_unit; ?>" readonly>
                </div>

                <button class="btn btn-primary btn-block">Perbaharui</button>

            </form>

        </div>
    </div>
</div>
