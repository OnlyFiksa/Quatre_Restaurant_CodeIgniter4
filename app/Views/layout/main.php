<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - Admin Resto</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#558b6e",       
                        "primary-hover": "#3d6650", 
                        "background-light": "#f4f7f5", 
                        "background-dark": "#1b2a25",
                        "sage-soft": "#e1ece6",     
                        "sage-text": "#2f483a",     
                        "sage-border": "#cbdcd3"    
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans", "sans-serif"]
                    }
                },
            },
        }
    </script>
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        
        .nav-item-active {
            background-color: #558b6e !important; 
            color: white !important;
            box-shadow: 0 4px 15px rgba(85, 139, 110, 0.3); 
        }
        .nav-item-active span { color: white !important; }
        
        .nav-item-hover:hover {
            background-color: #e1ece6; 
            color: #2f483a; 
        }
    </style>
</head>
<body class="bg-background-light text-sage-text h-screen overflow-hidden flex">

    <?php $uri = uri_string(); ?>

    <aside class="w-72 bg-white border-r border-sage-border flex flex-col transition-all duration-300 z-20 shadow-sm">
        <div class="p-8 flex items-center gap-3">
            <div class="size-10 bg-primary rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary/20">
                <span class="material-symbols-outlined text-2xl">restaurant</span>
            </div>
            <div>
                <h1 class="font-bold text-lg tracking-tight leading-tight text-sage-text">Quatre Resto</h1>
                <p class="text-xs text-sage-text/60 font-medium">Admin Panel</p>
            </div>
        </div>

        <nav class="flex-1 px-4 py-2 space-y-2 overflow-y-auto no-scrollbar">
            <a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group <?= $uri == 'admin/dashboard' ? 'nav-item-active' : 'text-sage-text nav-item-hover' ?>" href="<?= base_url('admin/dashboard') ?>">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="font-semibold text-sm">Dashboard</span>
            </a>

            <a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group <?= strpos($uri, 'admin/menu') === 0 ? 'nav-item-active' : 'text-sage-text nav-item-hover' ?>" href="<?= base_url('admin/menu') ?>">
                <span class="material-symbols-outlined">restaurant_menu</span>
                <span class="font-medium text-sm">Kelola Menu</span>
            </a>

            <a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group <?= strpos($uri, 'admin/pesanan') === 0 ? 'nav-item-active' : 'text-sage-text nav-item-hover' ?>" href="<?= base_url('admin/pesanan') ?>">
                <span class="material-symbols-outlined">receipt_long</span>
                <span class="font-medium text-sm">Pesanan</span>
            </a>

            <?php if (in_array(session()->get('jabatan'), ['Owner', 'Supervisor'])) : ?>
                
                <a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group <?= strpos($uri, 'admin/kategori') === 0 ? 'nav-item-active' : 'text-sage-text nav-item-hover' ?>" href="<?= base_url('admin/kategori') ?>">
                    <span class="material-symbols-outlined">category</span>
                    <span class="font-medium text-sm">Kelola Kategori</span>
                </a>

                <a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group <?= strpos($uri, 'admin/meja') === 0 ? 'nav-item-active' : 'text-sage-text nav-item-hover' ?>" href="<?= base_url('admin/meja') ?>">
                    <span class="material-symbols-outlined">table_restaurant</span>
                    <span class="font-medium text-sm">Kelola Meja</span>
                </a>

                <a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group <?= strpos($uri, 'admin/laporan') === 0 ? 'nav-item-active' : 'text-sage-text nav-item-hover' ?>" href="<?= base_url('admin/laporan') ?>">
                    <span class="material-symbols-outlined">bar_chart</span>
                    <span class="font-medium text-sm">Laporan</span>
                </a>

                <a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group <?= strpos($uri, 'admin/users') === 0 ? 'nav-item-active' : 'text-sage-text nav-item-hover' ?>" href="<?= base_url('admin/users') ?>">
                    <span class="material-symbols-outlined">group</span>
                    <span class="font-medium text-sm">Kelola Staff</span>
                </a>
            <?php endif; ?>
        </nav>

        <div class="p-4 border-t border-sage-border">
            <button id="logout-btn" onclick="document.getElementById('logout-popup').classList.remove('hidden');" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-500 hover:bg-red-50 transition-all group cursor-pointer">
                <span class="material-symbols-outlined">logout</span>
                <span class="font-semibold text-sm">Logout</span>
            </button>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-full overflow-hidden relative bg-background-light">
        
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-sage-border flex items-center justify-end px-8 sticky top-0 z-10 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold leading-none text-sage-text"><?= session()->get('nama') ?></p>
                    <p class="text-[10px] text-primary font-bold uppercase tracking-tighter mt-1"><?= session()->get('jabatan') ?></p>
                </div>
                <div class="size-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary border border-primary/20">
                     <span class="material-symbols-outlined">person</span>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-6 md:p-8">
            <?php if (session()->getFlashdata('sukses')) : ?>
                <div class="mb-6 p-4 rounded-xl bg-primary/10 border border-primary/20 text-primary flex items-center gap-3 shadow-sm flash-msg animate-fade-in-down">
                    <span class="material-symbols-outlined">check_circle</span>
                    <span class="font-medium"><?= session()->getFlashdata('sukses') ?></span>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-600 flex items-center gap-3 shadow-sm flash-msg animate-fade-in-down">
                    <span class="material-symbols-outlined">error</span>
                    <span class="font-medium"><?= session()->getFlashdata('error') ?></span>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>

            <footer class="mt-12 pt-6 border-t border-sage-border text-xs text-sage-text/40 font-medium text-center">
                <p>© 2026 Quatre Restaurant Admin.</p>
            </footer>
        </div>
    </main>

    <div id="logout-popup" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-sage-text/40 backdrop-blur-sm transition-all">
        <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-sm text-center transform scale-100 transition-all border border-sage-border">
            <div class="size-14 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4 border border-red-100">
                <span class="material-symbols-outlined text-3xl">logout</span>
            </div>
            <h2 class="text-xl font-bold text-sage-text mb-2">Konfirmasi Logout</h2>
            <p class="text-sage-text/60 mb-8 text-sm">Apakah Anda yakin ingin keluar dari aplikasi?</p>
            <div class="flex gap-3 justify-center">
                <button onclick="document.getElementById('logout-popup').classList.add('hidden');" class="px-5 py-2.5 rounded-xl bg-background-light text-sage-text font-semibold hover:bg-sage-soft border border-sage-border transition-all">Batal</button>
                <a href="<?= base_url('logout') ?>" class="px-5 py-2.5 rounded-xl bg-red-500 text-white font-semibold hover:bg-red-600 shadow-lg shadow-red-500/30 transition-all">Ya, Keluar</a>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/script-dashboard.js') ?>"></script>
    
    <script>
        // Auto-hide flash message
        setTimeout(() => {
            const msgs = document.querySelectorAll('.flash-msg');
            msgs.forEach(msg => {
                msg.style.transition = 'opacity 0.5s ease';
                msg.style.opacity = '0';
                setTimeout(() => msg.remove(), 500);
            });
        }, 4000);
    </script>
</body>
</html>