<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Pesanan Berhasil - Quatre Resto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { sage: { 50: '#f4f7f5', 500: '#558b6e', 900: '#2f483a' } },
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    animation: { 'bounce-slow': 'bounce 2s infinite' }
                }
            }
        }
    </script>
</head>
<body class="bg-sage-50 font-sans min-h-screen flex items-center justify-center p-6 relative overflow-hidden">

    <div class="fixed top-0 left-0 w-64 h-64 bg-sage-500/10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
    <div class="fixed bottom-0 right-0 w-64 h-64 bg-sage-500/10 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>

    <div class="bg-white w-full max-w-md p-8 rounded-[40px] shadow-2xl text-center relative z-10 border border-white/50">
        
        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce-slow">
            <i class='bx bx-check text-5xl text-green-600'></i>
        </div>

        <h1 class="text-3xl font-extrabold text-sage-900 mb-2">Pesanan Diterima!</h1>
        <p class="text-gray-500 text-sm mb-8 leading-relaxed">
            Terima kasih! Pesanan Anda sedang disiapkan dengan penuh cinta oleh chef kami.
        </p>

        <div class="bg-sage-50 border-2 border-dashed border-sage-500/30 p-6 rounded-2xl mb-8 relative">
            <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-6 h-6 bg-white rounded-full"></div>
            <div class="absolute -right-3 top-1/2 -translate-y-1/2 w-6 h-6 bg-white rounded-full"></div>
            
            <p class="text-xs font-bold text-sage-500 uppercase tracking-widest mb-1">ID Pesanan Anda</p>
            <p class="text-2xl font-black text-sage-900 tracking-wider font-mono select-all">
                <?= esc($id_order) ?>
            </p>
        </div>

        <a href="<?= base_url('/') ?>" class="block w-full bg-sage-900 text-white font-bold py-4 rounded-2xl shadow-lg shadow-sage-900/20 active:scale-95 transition-transform hover:bg-sage-800">
            Pesan Lagi
        </a>
        
        <p class="mt-6 text-xs text-gray-400">Harap tunjukkan ID ini saat pembayaran di kasir.</p>
    </div>

</body>
</html>