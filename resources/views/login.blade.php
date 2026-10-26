<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login | Sanitasi</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <style>
            /* Tailwind utility base */
            *,::after,::before{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}::after,::before{--tw-content:''}html{line-height:1.5;-webkit-text-size-adjust:100%;font-family:Figtree, sans-serif}body{margin:0;line-height:inherit}button,input,optgroup,select,textarea{font-family:inherit;font-size:100%;line-height:inherit;color:inherit;margin:0;padding:0}button,select{text-transform:none}[type=button],[type=reset],[type=submit],button{-webkit-appearance:button;background-color:transparent;background-image:none}table{text-indent:0;border-color:inherit;border-collapse:collapse}textarea{resize:vertical}input::placeholder,textarea::placeholder{opacity:1;color:#9ca3af}button{cursor:pointer}:disabled{cursor:default}
            body{background: radial-gradient(circle at top,#f8fafc 0%,#e2e8f0 40%,#cbd5e1 100%); color:#0f172a;}
            .page{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:2rem;}
            .card{max-width:1080px;width:100%;display:grid;grid-template-columns:1.1fr 1fr;gap:2rem;background:#ffffffee;border-radius:1.75rem;box-shadow:0 35px 80px rgba(15,23,42,.12);overflow:hidden;}
            .card__side{padding:3rem;display:flex;flex-direction:column;justify-content:center;}
            .hero{padding:3rem;background:linear-gradient(135deg,#4ade80,#166534);color:#fff;display:flex;flex-direction:column;justify-content:center;gap:1.5rem;position:relative;overflow:hidden;}
            .hero::after{content:'';position:absolute;top:-50%;left:-50%;width:200%;height:200%;background:radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 50%);z-index:1;animation: pulse 8s ease-in-out infinite;}
            @keyframes pulse { 0% { transform: scale(1); } 50% { transform: scale(1.05); } 100% { transform: scale(1); } }
            .hero > * {z-index:2;position:relative;}
            .hero__badge{display:inline-flex;align-items:center;gap:.75rem;padding:.65rem 1rem;border-radius:9999px;background:rgba(255,255,255,.15);font-weight:700;font-size:.95rem;text-transform:uppercase;letter-spacing:.08em;}
            .hero h1{font-size:2.5rem;line-height:1.05;margin:0;}
            .hero p{margin:0;color:rgba(255,255,255,.82);max-width:38rem;}
            .hero__list{display:grid;gap:.85rem;margin-top:1rem;}
            .hero__list li{display:flex;align-items:center;gap:.75rem;font-weight:600;color:rgba(255,255,255,.9);}
            .hero__list li::before{content:'✓';display:inline-flex;width:1.5rem;height:1.5rem;align-items:center;justify-content:center;border-radius:9999px;background:rgba(255,255,255,.18);}
            .form-title{font-size:1.75rem;font-weight:800;margin-bottom:.75rem;color:#0f172a;}
            .form-text{margin:.25rem 0 1.5rem;color:#475569;}
            .input-group{display:grid;gap:.75rem;margin-bottom:1rem;}
            .input-group label{font-size:.92rem;font-weight:600;color:#334155;}
            .input-group input{width:100%;border:1px solid #cbd5e1;border-radius:.95rem;padding:.95rem 1rem;font-size:1rem;color:#0f172a;background:#fff;transition:box-shadow .2s ease,border-color .2s ease;}
            .input-group input:focus{outline:none;border-color:#16a34a;box-shadow:0 0 0 4px rgba(22, 163, 74, 0.15);}
            .checkbox-row{display:flex;align-items:center;gap:.65rem;color:#475569;font-size:.95rem;}
            .button{display:inline-flex;align-items:center;justify-content:center;padding:1rem 1.2rem;border-radius:9999px;font-weight:700;background:#166534;color:#fff;border:none;transition:transform .2s ease,background .2s ease,box-shadow .2s ease;}
            .button:hover{background:#14532d;transform:translateY(-2px);box-shadow:0 10px 15px -3px rgba(22, 101, 52, 0.3);}
            .minor{color:#64748b;font-size:.95rem;margin-top:1.25rem;}
            .minor a{color:#166534;text-decoration:none;font-weight:700;}
            .hero-logo{width:260px;height:260px;object-fit:contain;margin-bottom:1.5rem;filter:drop-shadow(0 10px 15px rgba(0,0,0,0.15));}
            .alert{border-radius:1rem;padding:1rem 1.2rem;margin-bottom:1rem;background:#fee2e2;color:#991b1b;border:1px solid #fecaca;}
            @media (max-width:900px){.card{grid-template-columns:1fr;}.hero{padding:2rem;}.card__side{padding:2rem;}}        
        </style>
    </head>
    <body>
        <div class="page">
            <div class="card">
                <section class="hero">
                    <img src="{{ asset('images/logo_sibersih.png') }}" alt="Logo Si Bersih" class="hero-logo">
                    <span class="hero__badge">SI BERSIH</span>
                    <h1>Sistem Informasi Sanitasi Bersih</h1>
                    <p>Kelola data sanitasi rumah tangga, komunal, laporan, dan jaringan SPAL Kecamatan Mojoroto dengan mudah dan modern.</p>
                </section>

                <section class="card__side">
                    <div>
                        <p class="form-title">Login</p>
                        <p class="form-text">Masukkan username dan password Anda untuk lanjut.</p>

                        @if ($errors->any())
                            <div class="alert">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.submit') }}">
                            @csrf
                            <div class="input-group">
                                <label for="username">Username</label>
                                <input id="username" name="username" type="text" placeholder="username Anda" value="{{ old('username') }}" required autofocus>
                            </div>

                            <div class="input-group">
                                <label for="password">Password</label>
                                <div style="position: relative; display: flex; align-items: center;">
                                    <input id="password" name="password" type="password" placeholder="••••••••" required style="width: 100%; padding-right: 3rem;">
                                    <button type="button" id="togglePassword" style="position: absolute; right: 0.75rem; background: transparent; border: none; cursor: pointer; color: #64748b; padding: 0.2rem; display: flex; align-items: center; justify-content: center;">
                                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    </button>
                                </div>
                            </div>

                            <div class="checkbox-row">
                                <input id="remember" name="remember" type="checkbox" style="width:1.1rem;height:1.1rem;border:1px solid #cbd5e1;border-radius:.35rem;">
                                <label for="remember">Ingat saya</label>
                            </div>

                            <button type="submit" class="button">Masuk sekarang</button>
                        </form>

                        <p class="minor">Belum punya akun? Hubungi admin untuk pembuatan user.</p>
                    </div>
                </section>
            </div>
        </div>
        <script>
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');
            const eyeIcon = document.querySelector('#eyeIcon');

            togglePassword.addEventListener('click', function (e) {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                if (type === 'text') {
                    eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
                } else {
                    eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
                }
            });
        </script>
    </body>
</html>
