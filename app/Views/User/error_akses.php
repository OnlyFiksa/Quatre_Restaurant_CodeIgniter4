<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Akses Ditolak' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet" />
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-pattern {
            background-image: radial-gradient(#cbdcd3 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
</head>
<body class="bg-[#f4f7f5] text-[#2f483a] h-screen flex flex-col items-center justify-center p-6 text-center bg-pattern">

    <div class="bg-white p-10 rounded-[40px] shadow-2xl shadow-[#558b6e]/10 border border-[#cbdcd3] max-w-sm w-full relative overflow-hidden">
        
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-red-50 rounded-full blur-3xl opacity-60"></div>
        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-[#558b6e]/10 rounded-full blur-3xl opacity-60"></div>

        <div class="relative z-10 w-24 h-24 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm border border-red-100 animate-bounce">
            <span class="material-symbols-outlined text-5xl">no_meals</span>
        </div>

        <h1 class="relative z-10 text-2xl font-extrabold mb-3 text-[#2f483a]"><?= $title ?></h1>
        
        <p class="relative z-10 text-sm text-[#2f483a]/70 leading-relaxed mb-8 font-medium">
            <?= $pesan ?>
        </p>

        <div class="relative z-10 bg-[#f4f7f5] p-4 rounded-2xl border border-[#cbdcd3] flex items-center gap-3 text-left">
            <div class="bg-white p-2 rounded-full text-[#558b6e] shadow-sm">
                <span class="material-symbols-outlined text-xl">qr_code_scanner</span>
            </div>
            <div>
                <p class="text-[10px] font-bold text-[#2f483a]/50 uppercase tracking-wider">Solusi</p>
                <p class="text-xs font-bold text-[#2f483a]">Silakan pindah & scan QR di meja lain.</p>
            </div>
        </div>

    </div>

    <p class="mt-8 text-xs text-[#2f483a]/40 font-bold tracking-widest uppercase">Quatre Resto System</p>

</body>
</html>