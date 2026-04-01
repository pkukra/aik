<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="m-0">Tambah User <?= $unit->nama_unit; ?></h4>
        <a href="javascript:history.back()" class="btn btn-secondary btn-sm">Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="<?= site_url('user/save'); ?>" method="post">

                

                <div class="form-group">
                    <label>NIP (3 Angka)</label>
                    <input type="text" name="username" id="username" class="form-control" maxlength="3" required>
                    <div id="result"></div>
                </div>
                
                <div class="form-group">
                    <label>Password (default 123456)</label>
                    <input type="password" name="password" class="form-control" value="123456" required>
                </div>
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="form-group" hidden>
                    <label>Pilih Unit</label>
                    <input type="hidden" name="role" class="form-control" value="Staff" >
                    <input type="hidden" name="id_unit" class="form-control" value="<?= $unit->id; ?>" >
                    <input type="text" name="unit_name" class="form-control" value="<?= $unit->nama_unit; ?>" disabled>
                </div>

                <button class="btn btn-success btn-block" id="simpan" disabled>Simpan User</button>

            </form>

        </div>
    </div>
</div>
<script>
$(document).ready(function(){

    let timer = null;

    $('#username').on('keyup', function(){
        $('#simpan').prop('disabled', true);
        clearTimeout(timer);
        let username = $(this).val();

        if(username.length < 3){
            $('#result').html('<span style="color:red">Minimal 3 karakter</span>');
            return;
        }

        timer = setTimeout(function(){

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

        }, 400); // debounce 400ms
    });

});
</script>