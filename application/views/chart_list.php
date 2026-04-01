<div class="container mt-3">
    <div class="d-flex justify-content-end align-items-center mb-3">
        <a href="javascript:history.back()" class="btn btn-secondary mt-2">Kembali</a>
    </div>
</div>
<div class="card">
    <?php
    if (!empty($labels)) {
        $tahun_awal  = min($labels);
        $tahun_akhir = max($labels);
    } else {
        $tahun_awal  = '-';
        $tahun_akhir = '-';
    }
    ?>
    <div class="card-header bg-primary text-white">
        Perolehan Poin Tahun <?= $tahun_awal ?> – <?= $tahun_akhir ?>
    </div>
    <div class="card-body">
        <canvas id="poinChart" height="120"></canvas>
    </div>
</div>

<div class="card">
    <div class="card-header bg-light">
        <b>Detail Poin Tahunan</b>
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered table-striped mb-0">
            <thead class="thead-dark">
                <tr>
                    <th width="10%">No</th>
                    <th>Tahun</th>
                    <th>Total Poin</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($labels)): ?>
                    <?php foreach ($labels as $i => $tahun): ?>
                        <tr>
                            <td><?= $i + 1; ?></td>
                            <td><?= $tahun; ?></td>
                            <td><b><?= $dataPoin[$i]; ?></b></td>
                            <td><?php $param = date('m-Y',strtotime($tahun)); ?>
                                <a href="<?= site_url('chart/detail?p='.$param); ?>"
                                class="btn btn-sm btn-info">
                                    Detail
                                </a>
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
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('poinChart'), {
    type: 'bar',  
    data: {
        labels: <?= json_encode($labels); ?>,
        datasets: [{
            label: 'Total Poin',
            data: <?= json_encode($dataPoin); ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.7)',
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 50 }
            }
        }
    }
});
</script>

