<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="m-0">List Pegawai <?= $unit->nama_unit;?></h4>
    </div>
    <a id="exportBtn" 
        href="<?= site_url('report/export_excel/'.$unit->id.'?m='.$m.'&y='.$y); ?>" 
        class="btn btn-success btn-sm navbar-btn">
        Export Excel
    </a>
    <a href="<?= site_url('dashboard'); ?>" class="btn btn-secondary btn-sm">Kembali</a>
    <p style="color:blue;">Bulan :</p>
    <select name="bulan" class="form-control mb-2" style="width:50%"
        onchange="window.location='<?= site_url('report?id='.$unit->id); ?>&m='+this.value+'&y=<?= $y ?>';">
        <?php 
        $bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        foreach ($bulan as $key => $nama) {
            $selected = ($key == $m) ? 'selected' : '';
            echo "<option value='$key' $selected>$nama</option>";
        }
        ?>
    </select>

    <p style="color:blue;">Tahun :</p>
    <select name="tahun" class="form-control mb-3" style="width:50%"
        onchange="window.location='<?= site_url('report?id='.$unit->id); ?>&m=<?= $m ?>&y='+this.value;">
        <?php
        $tahun_awal = date('Y') - 1; 
        $tahun_akhir = date('Y') + 0;

        for ($t = $tahun_akhir; $t >= $tahun_awal; $t--) {
            $selected = ($t == $y) ? 'selected' : '';
            echo "<option value='$t' $selected>$t</option>";
        }
        ?>
    </select>

    <table class="table table-bordered">
        <thead>
            <th>Nama</th>
            <th>Poin</th>
        </thead>
        <tbody>
            <?php if (!empty($list)): ?>
                <?php foreach($list as $u): ?>
                    <tr>
                        <td><?= $u->nama;?></td>
                        <td><?= $u->poin;?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td class="alert alert-info text-center" colspan="5">Belum ada data Kegiatan.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

