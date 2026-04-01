<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
<?php endif; ?>
<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="m-0">Kelola Laporan </h4>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <button 
            type="button" 
            class="btn btn-success btn-sm"
            data-toggle="modal"
            data-target="#modalPilihBulan">
            Export Excel
        </button>
    </div>

    <?php if (!empty($list)): ?>
        <div class="row mt-3 pr-2">
            <?php $i = 0; ?>
            <?php foreach($list as $u): ?>
                <?php 
                    $btnColor = $colors[$i % count($colors)];
                    $i++;
                ?>
                <div class="col-12 px-3 mb-3">
                    <a href="<?= site_url('report?id='.$u->id.'&&m='.date('m')); ?>" 
                    class="btn btn-<?= $btnColor ?> btn-block py-3"
                    style="border-radius: 10px;">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 text-left">
                                <?= $u->nama_unit ?>
                            </div>
                            <div class="flex-grow-1 text-right">
                                <span >Jumlah Pegawai : </span> <?= $u->total ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">Belum ada Unit yang terdaftar.</div>
    <?php endif; ?>
</div>
<div>
    <a href="javascript:history.back()" class="btn btn-secondary btn-sm">Kembali</a>
</div>
<div class="modal fade" id="modalPilihBulan" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Bulan Export</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <select id="pilihBulan" class="form-control">
                    <option value="prev"></option>
                    <option value="now"></option>
                </select>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                <button 
                    id="btnExport"
                    class="btn btn-success btn-sm"
                    onclick="exportExcel()">
                    <span id="textExport">Export</span>
                    <span id="loadingExport" class="spinner-border spinner-border-sm d-none" role="status"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
const namaBulan = [
    'Januari','Februari','Maret','April','Mei','Juni',
    'Juli','Agustus','September','Oktober','November','Desember'
];

document.addEventListener('DOMContentLoaded', function () {
    const now  = new Date();
    const prev = new Date();
    prev.setMonth(prev.getMonth() - 1);

    document.querySelector('#pilihBulan option[value="now"]').text =
        namaBulan[now.getMonth()] + ' ' + now.getFullYear();

    document.querySelector('#pilihBulan option[value="prev"]').text =
        namaBulan[prev.getMonth()] + ' ' + prev.getFullYear();
});

function exportExcel() {
    // tampilkan loading
    document.getElementById('textExport').classList.add('d-none');
    document.getElementById('loadingExport').classList.remove('d-none');

    // disable tombol biar ga dobel klik
    document.getElementById('btnExport').disabled = true;

    const pilih = document.getElementById('pilihBulan').value;
    const d = new Date();

    if (pilih === 'prev') {
        d.setMonth(d.getMonth() - 1);
    }

    const bulan = d.getMonth() + 1;
    const tahun = d.getFullYear();

    // redirect export
    window.location.href =
        "<?= site_url('report/export_excel_all'); ?>?m=" + bulan + "&y=" + tahun;
}
</script>


