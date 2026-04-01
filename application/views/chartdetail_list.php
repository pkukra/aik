
<div class="container mt-3">
    <div class="d-flex justify-content-end align-items-center mb-3">
        <a href="javascript:history.back()" class="btn btn-secondary mt-2">Kembali</a>
    </div>
</div>
<div class="card">
    <div class="card-header bg-light">
        <b>Detail Poin Bulanan</b>
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered table-striped mb-0">
            <thead class="thead-dark">
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Aktivitas</th>
                    <th>Total Poin</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($list)): $tot = 0;?>
                    <?php foreach ($list as $d): ?>
                        <tr>
                            <td style="width:25%"><?= date('d M Y',strtotime($d->waktu_aktivitas))?></td>
                            <td>
                                <?php 
                                if (!empty($d->kegiatan_detail)): ?>
                                        <?php foreach ($d->kegiatan_detail as $k): ?>
                                                <?php if($k->nama_aktivitas): echo $k->nama_aktivitas; else: echo $k->nama_subkegiatan; endif; ?>,
                                                
                                        <?php endforeach; ?>
                                <?php endif; ?>
                            </td>
                            <td><?= $d->totharian;?><?php $tot += $d->totharian?> </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <th colspan="2" class="text-right">Total Poin</th><th><?= $tot?></th>
                    </tr>
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

