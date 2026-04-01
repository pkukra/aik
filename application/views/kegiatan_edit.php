<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="container mt-4">
    <h4>Edit Kegiatan</h4>

    <form method="post" action="<?= site_url('kegiatan/update/'.$detail->id_kegiatan); ?>">
        <div class="form-group">
            <label>Nama Unit</label>
            <input type="text" name="nama_unit" class="form-control" value="<?= $detail->nama_kegiatan; ?>" required>
            <label>Poin</label>
            <input type="number" id="poin" name="poin" class="form-control" required min="0" max="100" value="<?= $detail->poin; ?>">
            <label>Icon</label>
            <div class="dropdown">
                <button class="btn btn-info dropdown-toggle" data-toggle="dropdown" id="iconBtn" >
                    <?php if($detail->icon): ?>
                    <i class="<?= $detail->icon; ?>"></i> 
                    <?php else: ?>
                    Pilih Icon
                    <?php endif ?>
                </button>

                <div class="dropdown-menu" >
                    <?php foreach($icon as $u): ?>
                        <a class="dropdown-item pilih-item" data-icon="<?= $u->fa_icon; ?>">
                            <i class="<?= $u->fa_icon; ?>"></i>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <input type="hidden" name="icon" id="icon_input" value="<?= $detail->icon; ?>">
        </div>

        <button class="btn btn-primary btn-block">Update</button>
        <a href="<?= site_url('kegiatan'); ?>" class="btn btn-secondary btn-block mt-2">Kembali</a>
    </form>
</div>
<script>
$(".pilih-item").click(function(){
    console.log('tes');
    let icon = $(this).data("icon");
    $("#icon_input").val(icon);
    $("#iconBtn").html(`<i class='${icon}'></i>`);
});
$("#poin").on("input", function () {
    let value = parseInt($(this).val());

    if (value > 100) {
        $(this).val(100);   // otomatis dibatasi ke 100
    }
    if (value < 0) {
        $(this).val(0);     // otomatis dibatasi ke 0
    }
});
</script>
