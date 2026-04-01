<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Aktivitas</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>

<div class="container mt-4">
    <h4>
        Tambah Aktivitas <br>
        <b class="text-primary"><?= $kegiatan->nama_kegiatan; ?></b>
    </h4>

    <form method="post" action="<?= site_url('aktivitas/save'); ?>" enctype="multipart/form-data" id="formAktivitas">

        <!-- NAMA AKTIVITAS -->
        <div class="form-group">
            <label>Nama Aktivitas <?= $kegiatan->nama_kegiatan?></label>

            <?php if ($sub): ?>
                <select name="id_sub" class="form-control">
                    <?php foreach ($sub as $u): ?>
                        <option value="<?= $u->id_sub; ?>">
                            <?= $u->nama_subkegiatan; ?>
                        </option>
                    <?php endforeach ?>
                </select>
            <?php else: ?>
                <input type="text" name="nama_aktivitas" class="form-control" required>
            <?php endif ?>
        </div>

        <!-- TANGGAL & JAM -->
        <div class="form-group">
            <div class="row">

                <!-- TANGGAL -->
                <div class="col-md-6">
                    <label>Tanggal</label>
                    <input
                        type="text"
                        name="tanggal"
                        id="tanggal"
                        class="form-control"
                        placeholder="Klik untuk pilih tanggal"
                        readonly
                        required
                        <?php if ($kegiatan->id_kegiatan != '15' && $kegiatan->id_kegiatan != '16'): ?>
                            value="<?= date('Y-m-d'); ?>"
                        <?php endif; ?>
                    >

                    <!-- NOTIF HARI KHUSUS -->
                    <?php if ($kegiatan->id_kegiatan == '15'): ?>
                        <small class="badge badge-info mt-1">📅 Hanya hari Selasa</small>
                    <?php elseif ($kegiatan->id_kegiatan == '16'): ?>
                        <small class="badge badge-warning mt-1">📅 Hanya hari Jumat</small>
                    <?php endif; ?>

                    <!-- NOTIF BULAN OPSIONAL -->
                   <small
                        id="bulanNotif"
                        class="badge badge-secondary mt-1 d-block"
                        style="
                            display:none;
                            max-width: 100%;
                            white-space: normal;
                            word-break: break-word;
                            overflow-wrap: break-word;
                        "
                    >
                        ⏳ Pengisian Bulan sebelumnya ditutup setelah tanggal 3 <?= date('F')?>
                    </small>
                </div>

                <!-- JAM -->
                <div class="col-md-6">
                    <label>Jam</label>
                    <input
                        type="time"
                        name="jam"
                        class="form-control"
                        required
                        value="<?= date('H:i'); ?>"
                    >
                </div>

            </div>
        </div>

        <!-- KETERANGAN -->
        <div class="form-group">
            <label>Keterangan <span class="text-primary">(Opsional)</span></label>
            <input type="text" name="keterangan" class="form-control">
            <input type="hidden" name="id_kegiatan" value="<?= $id_kegiatan; ?>">
        </div>

        <!-- UPLOAD -->
        <div class="form-group">
            <label>
                Upload
                <?php if ($kegiatan->id_kegiatan == '19'): ?>
                    <span class="text-danger">*</span>
                <?php else: ?>
                    <span class="text-primary">(Opsional)</span>
                <?php endif; ?>
            </label>

            <input
                type="file"
                name="upload"
                id="upload"
                accept="image/jpeg, image/png"
                class="form-control"
                <?= ($kegiatan->id_kegiatan == '19') ? 'required' : ''; ?>
            >

            <?php if ($kegiatan->id_kegiatan == '19'): ?>
                <span id="uploadNotif" class="text-danger small">
                    Upload wajib diisi untuk kegiatan ini
                </span>
            <?php endif; ?>
        </div>

        <!-- BUTTON -->
        <button type="submit" class="btn btn-success btn-block">Simpan</button>
        <a href="javascript:history.back()" class="btn btn-secondary btn-block mt-2">Kembali</a>

    </form>
</div>

<!-- MODAL VALIDASI TANGGAL -->
<div class="modal fade" id="tanggalModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Peringatan</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Tanggal wajib diisi sebelum menyimpan aktivitas.
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const idKegiatan = "<?= $kegiatan->id_kegiatan ?>";
    const notifBulan = document.getElementById('bulanNotif');

    const today = new Date();
    const todayDate = today.getDate();

    let minDate = "<?= date('Y-m-01'); ?>";
    console.log(todayDate);
    

    if (todayDate <= 3) {
        minDate = "<?= date('Y-m-01', strtotime('-1 month')); ?>";
        if (notifBulan) notifBulan.style.display = 'inline-block';
    }

    flatpickr("#tanggal", {
        dateFormat: "Y-m-d",
        minDate: minDate,
        maxDate: "<?= date('Y-m-t'); ?>",
        disable: [
            function (date) {
                if (idKegiatan === '15') return date.getDay() !== 2;
                if (idKegiatan === '16') return date.getDay() !== 5;
                return false;
            }
        ]
    });

});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const upload = document.getElementById('upload');
    const notif  = document.getElementById('uploadNotif');

    if (!upload || !notif) return;

    upload.addEventListener('change', function () {
        notif.style.display = this.files.length ? 'none' : 'inline';
    });

});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const form    = document.getElementById('formAktivitas');
    const tanggal = document.getElementById('tanggal');

    form.addEventListener('submit', function (e) {
        if (!tanggal.value) {
            e.preventDefault();
            tanggal.classList.add('is-invalid');
            $('#tanggalModal').modal('show');
        } else {
            tanggal.classList.remove('is-invalid');
        }
    });

    $('#tanggalModal').on('hidden.bs.modal', function () {
        tanggal.focus();
    });

});
</script>

</body>
</html>
