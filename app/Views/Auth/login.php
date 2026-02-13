<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login - Quatre Restaurant</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              "primary": "#11d452",
              "sage": { 50: "#f4f7f4", 100: "#e3ebe3", 200: "#c5d6c5", 500: "#587a58", 900: "#102216" }
            }
          }
        }
      }
    </script>

    <link rel="stylesheet" href="<?= base_url('assets/style-login.css') ?>">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-50 overflow-hidden">

<div class="flex h-screen w-full">
    
    <div class="hidden lg:flex lg:w-3/5 relative overflow-hidden bg-sage-900 shadow-2xl z-10">
        <div id="bg-slider" class="absolute inset-0 bg-cover bg-center transform scale-105"
             style="background-image: url('https://images.unsplash.com/photo-1544025162-d76694265947?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-sage-900/80 to-transparent mix-blend-multiply"></div>

        <div class="relative z-20 flex flex-col justify-end h-full p-20 pb-24 text-white animate-fade-in">
            <div class="mb-6">
                <span class="px-3 py-1 border border-primary text-primary text-xs font-bold tracking-widest uppercase rounded-full">Admin Portal</span>
            </div>
            <h2 class="text-6xl font-bold leading-tight mb-4 drop-shadow-lg">
                Taste the <span class="text-primary">Extraordinary</span>
            </h2>
            <p class="text-sage-100 text-xl max-w-lg border-l-4 border-primary pl-6">
                Manage your restaurant efficiently with Quatre System.
            </p>
        </div>
    </div>

    <div class="w-full lg:w-2/5 flex items-center justify-center p-6 relative bg-gray-100">
        
        <div class="absolute top-10 right-10 w-40 h-40 bg-sage-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute bottom-10 left-10 w-40 h-40 bg-primary/20 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>

        <div class="w-full max-w-lg glass-panel rounded-3xl px-12 py-20 animate-fade-in relative z-20">
            
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-sage-100 text-sage-900 mb-6 shadow-sm">
                    <span class="material-icons" style="font-size: 40px;">restaurant</span>
                </div>
                <h1 class="text-4xl font-bold text-gray-800">Hello Again!</h1>
                <p class="text-base text-gray-500 mt-3">Welcome back to Quatre Dashboard</p>
            </div>

            <form action="<?= base_url('/login/auth') ?>" method="POST" class="space-y-8">
                <?= csrf_field() ?>

                <div>
                    <label class="block text-sm font-bold text-gray-500 uppercase mb-3">Username</label>
                    <input class="w-full px-6 py-5 rounded-xl bg-gray-50 border border-gray-200 text-gray-800 text-base focus:outline-none input-focus transition-all" 
                           id="username" name="username" type="text" placeholder="Enter username" required autofocus>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-3">
                        <label class="block text-sm font-bold text-gray-500 uppercase">Password</label>
                        <a href="#" class="text-sm text-sage-500 hover:text-sage-700">Forgot?</a>
                    </div>
                    <div class="relative">
                        <input class="w-full px-6 py-5 rounded-xl bg-gray-50 border border-gray-200 text-gray-800 text-base focus:outline-none input-focus transition-all" 
                               id="password" name="password" type="password" placeholder="••••••••" required>
                        <div class="absolute inset-y-0 right-0 pr-6 flex items-center cursor-pointer" id="togglePasswordBtn">
                            <span class="material-icons text-gray-400 text-xl" id="eyeIcon">visibility_off</span>
                        </div>
                    </div>
                </div>

                <button class="w-full mt-8 py-5 rounded-xl bg-sage-900 text-white font-bold text-lg shadow-lg hover:bg-sage-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1" type="submit">
                    Sign In
                </button>
            </form>

            <div class="mt-12 text-center border-t border-gray-200 pt-8">
                <p class="text-sm text-gray-400">© 2026 Quatre Restaurant System</p>
            </div>

        </div>
    </div>
</div>

<div id="flash-data" 
     data-error="<?= session()->getFlashdata('error_login') ?>" 
     data-success="<?= session()->getFlashdata('sukses_logout') ?>">
</div>

<script src="<?= base_url('assets/script-login.js') ?>"></script>

</body>
</html>