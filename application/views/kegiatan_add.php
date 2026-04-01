<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="container mt-4">
    <h4>Tambah Kegiatan</h4>

    <form method="post" action="<?= site_url('kegiatan/save'); ?>">
        <div class="form-group">
            <label>Nama Kegiatan</label>
            <input type="text" name="nama_kegiatan" class="form-control" required>
            <label>Poin</label>
            <input type="number" id="poin" name="poin" class="form-control" required min="0" max="100">
            <label>Icon</label>
            <div class="dropdown">
                <button class="btn btn-info dropdown-toggle" data-toggle="dropdown" id="iconBtn" >
                    Pilih Icon
                </button>

                <div class="dropdown-menu" >
                    <?php foreach($icon as $u): ?>
                        <a class="dropdown-item pilih-item" data-icon="<?= $u->fa_icon; ?>">
                            <i class="<?= $u->fa_icon; ?>"></i>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <input type="hidden" name="icon" id="icon_input">
        </div>

        <button type="submit" class="btn btn-success btn-block">Simpan</button>
        <a href="<?= site_url('kegiatan'); ?>" class="btn btn-secondary btn-block mt-2">Kembali</a>
    </form>
</div>
<script>
$(document).ready(function() {
    $(".pilih-item").click(function(){
        console.log('tes');
        let icon = $(this).data("icon");
        $("#icon_input").val(icon);
        $("#iconBtn").html(`<i class='${icon}'></i>`);
    });

    $("#poin").on("input", function () {
        let value = parseInt($(this).val());

        if (value > 100) $(this).val(100);
        if (value < 0) $(this).val(0);
    });
});
</script>

