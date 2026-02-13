<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="<?= base_url('assets/style-dashboard.css') ?>">
</head>
<body>

    <div class="sidebar">
        <div class="logo">
            <i class='bx bxs-store-alt'></i>
            <span>Admin Resto</span>
        </div>
        <ul class="nav-links">
            <li class="<?= uri_string() == 'admin/dashboard' ? 'active' : '' ?>"> 
                <a href="<?= base_url('admin/dashboard') ?>">
                    <i class='bx bxs-dashboard'></i>
                    <span class="link-name">Dashboard</span>
                </a>
            </li>
            
            <li class="<?= uri_string() == 'admin/menu' ? 'active' : '' ?>">
                <a href="<?= base_url('admin/menu') ?>"> <i class='bx bxs-food-menu'></i>
                    <span class="link-name">Kelola Menu</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bxs-fridge'></i>
                    <span class="link-name">Ketersediaan Menu</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bxs-receipt'></i>
                    <span class="link-name">Pesanan</span>
                </a>
            </li>
            
            <?php if (in_array(session()->get('jabatan'), ['Owner', 'Supervisor'])) : ?>
            <li>
                <a href="#">
                    <i class='bx bxs-bar-chart-alt-2'></i>
                    <span class="link-name">Laporan</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bxs-group'></i>
                    <span class="link-name">Kelola Admin</span>
                </a>
            </li>
            <?php endif; ?>

            <li class="logout">
                <a href="#" id="logout-btn">
                    <i class='bx bxs-log-out'></i>
                    <span class="link-name">Logout</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <header>
            <h2><?= $this->renderSection('title') ?></h2> <div class="user-wrapper">
                <i class='bx bxs-user-circle'></i>
                <div>
                    <h4><?= session()->get('nama') ?></h4>
                    <small><?= session()->get('jabatan') ?></small>
                </div>
            </div>
        </header>

        <main>
            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <div class="popup-overlay" id="logout-popup">
        <div class="popup-box">
            <h2>Konfirmasi Logout</h2>
            <p>Apakah Anda yakin ingin keluar?</p>
            <div class="popup-buttons">
                <button class="btn-cancel" id="cancel-logout-btn">Batal</button>
                <a href="<?= base_url('logout') ?>" class="btn-confirm">Yakin</a>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/script-dashboard.js') ?>"></script>

</body>
</html>