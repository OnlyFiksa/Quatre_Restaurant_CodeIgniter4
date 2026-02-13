<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="cards-container">
    <div class="card">
        <div>
            <h3>Rp <?= number_format($pendapatan_hari_ini, 0, ',', '.') ?></h3>
            <span>Pendapatan Hari Ini</span>
        </div>
        <div><i class='bx bxs-wallet'></i></div>
    </div>

    <div class="card">
        <div>
            <h3><?= $pesanan_baru ?></h3>
            <span>Pesanan Baru</span>
        </div>
        <div><i class='bx bxs-bell'></i></div>
    </div>

    <div class="card">
        <div>
            <h3><?= $meja_terisi ?></h3>
            <span>Meja Terisi</span>
        </div>
        <div><i class='bx bxs-group'></i></div>
    </div>
</div>

<?= $this->endSection() ?>