<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="m-0">Edit User <?= $unit->nama_unit; ?></h4>
        <a href="<?= site_url('deleteuser'); ?>" class="btn btn-secondary btn-sm">Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="<?= site_url('deleteuser/update/'.$user->id_user); ?>" method="post">

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" 
                           value="<?= $user->nama; ?>" required>
                </div>

                <div class="form-group">
                    <label>NIP (3 Angka)</label>
                    <input type="text" name="username"  id="username"
                    class="form-control" maxlength="3"
                    value="<?= $user->username; ?>" required>
                    <span id="result"></span>
                </div>

                <div class="form-group">
                    <label>Password (kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" name="password" class="form-control" placeholder="******">
                </div>

                <div class="form-group">
                    <label>Pilih Unit</label>
                    <input type="hidden" name="role" class="form-control" value="<?= $user->role; ?>">
                    <select class="form-control" name="id_unit">
                        <?php foreach($allunit as $u): ?>
                        <option value="<?= $u->id; ?>" <?php if($user->id == $u->id): echo "selected"; endif;?>><?= $u->nama_unit; ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <input type="hidden" name="aktifkan" id="aktifkan" value="0">
                <button type="button" class="btn btn-primary btn-block" id="simpan">
                    Update dan Aktifkan
                </button>
            </form>

        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade " id="aktifModal" tabindex="-1" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
        <div class="modal-header bg-danger text-white">
            <h5 class="modal-title">Konfirmasi Aktifkan User</h5>
            <button type="button" class="close text-white" data-dismiss="modal">
            <span>&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Apakah ingin mengaktifkan user?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" id="btnTidak">
                Tidak
            </button>
            <button type="button" class="btn btn-primary" id="btnYa">
                Ya
            </button>
        </div>

        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    var username = $('#username').val();
    let timer = null;

    $('#simpan').on('click', function (e) {
        e.preventDefault();
        $('#aktifModal').modal('show');
    });

    $('#btnYa').on('click', function () {
        $('#aktifkan').val('1'); // aktifkan
        $('form').submit();
    });

    // TIDAK → submit TANPA ubah flag
    $('#btnTidak').on('click', function () {
        $('#aktifkan').val('0');
        $('form').submit();
    });

    $('#username').on('keyup', function () {
        $('#simpan').prop('disabled', true);

        let username = $(this).val().trim();
        let old = "<?= addslashes($user->username); ?>";

        // ✅ JIKA TIDAK BERUBAH
        if (username === old) {
            $('#result').html('<span style="color:green">Username tidak berubah</span>');
            $('#simpan').prop('disabled', false);
            return;
        }

        // ❌ VALIDASI PANJANG BARU DICEK SETELAH ITU
        if (username.length < 3) {
            $('#result').html('<span style="color:red">Minimal 3 karakter</span>');
            return;
        }

        // ✅ DEBOUNCE AJAX
        clearTimeout(timer);
        timer = setTimeout(function () {
            cek_username(username);
        }, 400);
    });

    function cek_username(username){
        $.ajax({
            url: "<?= site_url('user/username'); ?>",
            type: "POST",
            data: { username: username },
            dataType: "json",
            beforeSend: function(){
                $('#result').html('Checking...');
            },
            success: function(res){
                if(res.status){
                    $('#result').html(
                        '<span style="color:green">'+res.message+'</span>'
                    );
                    $('#simpan').prop('disabled', false);
                }else{
                    $('#result').html(
                        '<span style="color:red">'+res.message+'</span>'
                    );
                }
            },
            error: function(xhr){
                console.log(xhr.responseText);
                $('#result').html('<span style="color:red">Error server</span>');
            }
            });
        
    }


});
</script>
