<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>নতুন পাসওয়ার্ড সেট করুন — OnionTrade Pro</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('brand/onion.svg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: #0f1a12;
            font-family: 'DM Sans', sans-serif;
        }

        .glass {
            background: #162019;
            border: 1px solid #2a3d2f;
            border-radius: 20px;
        }

        .field {
            width: 100%;
            padding: 11px 14px;
            border-radius: 10px;
            background: #1e2d22;
            border: 1px solid #2a3d2f;
            color: #e8f5ea;
            font-size: 14px;
            outline: none;
            transition: .2s;
            font-family: 'DM Sans', sans-serif;
        }

        .field:focus {
            border-color: rgba(74, 222, 128, .5);
            box-shadow: 0 0 0 3px rgba(74, 222, 128, .08);
        }

        .field::placeholder {
            color: #5a7560;
        }

        .field.has-error {
            border-color: rgba(248, 113, 113, .5);
        }

        .btn-green {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            transition: .2s;
            background: linear-gradient(135deg, #4ade80, #16a34a);
            color: #000;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-green:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(74, 222, 128, .3);
        }

        .lbl {
            display: block;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .5px;
            text-transform: uppercase;
            color: #9ab09e;
            margin-bottom: 7px;
        }

        .err {
            background: rgba(248, 113, 113, .1);
            border: 1px solid rgba(248, 113, 113, .2);
            color: #f87171;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .field-error {
            font-size: 11px;
            color: #f87171;
            margin-top: 5px;
        }

        @media (max-width: 640px) {
            .glass {
                padding: 1.25rem !important;
            }
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">

    <div class="fixed inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
        <div class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] rounded-full"
            style="background:radial-gradient(circle,rgba(74,222,128,.07),transparent 65%)"></div>
    </div>

    <div class="w-full max-w-sm relative z-10">

        <div class="text-center mb-8">
            {{-- ✅ FIXED: img tag instead of link tag --}}
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-4"
                style="background:linear-gradient(135deg,#4ade80,#16a34a);box-shadow:0 8px 30px rgba(74,222,128,.3)">
                <img src="{{ asset('brand/onion.svg') }}" alt="OnionTrade" class="w-10 h-10">
            </div>
            <h1 style="font-family:Syne,sans-serif;font-weight:800;font-size:22px;color:#f0fdf4">OnionTrade Pro</h1>
        </div>

        <div class="glass p-8">
            <div style="text-align:center;margin-bottom:24px">
                <div style="font-size:36px;margin-bottom:8px">🔒</div>
                <h2 style="font-family:Syne,sans-serif;font-weight:700;font-size:18px;color:#f0fdf4">
                    নতুন পাসওয়ার্ড সেট করুন</h2>
            </div>

            @if($errors->any())
                <div class="err">❌ {{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div style="margin-bottom:16px">
                    <label class="lbl">ইমেইল</label>
                    <input type="email" name="email" value="{{ old('email', $email) }}"
                        class="field {{ $errors->has('email') ? 'has-error' : '' }}" placeholder="আপনার ইমেইল" required
                        autocomplete="email">
                    @error('email')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div style="margin-bottom:16px">
                    <label class="lbl">নতুন পাসওয়ার্ড</label>
                    <div style="position:relative">
                        <input type="password" name="password" id="pw-new"
                            class="field {{ $errors->has('password') ? 'has-error' : '' }}"
                            placeholder="কমপক্ষে ৮ অক্ষর" required style="padding-right:44px" oninput="checkMatch()">
                        <button type="button" onclick="togglePw('pw-new','eye-new')"
                            style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;font-size:15px">
                            <span id="eye-new">👁️</span>
                        </button>
                    </div>
                    @error('password')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div style="margin-bottom:24px">
                    <label class="lbl">পাসওয়ার্ড নিশ্চিত করুন</label>
                    <div style="position:relative">
                        <input type="password" name="password_confirmation" id="pw-conf" class="field"
                            placeholder="আবার দিন" required style="padding-right:44px" oninput="checkMatch()">
                        <button type="button" onclick="togglePw('pw-conf','eye-conf')"
                            style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;font-size:15px">
                            <span id="eye-conf">👁️</span>
                        </button>
                    </div>
                    <p id="match-lbl" style="font-size:10px;margin-top:4px;color:#5a7560"> </p>
                </div>

                <button type="submit" class="btn-green">পাসওয়ার্ড পরিবর্তন করুন →</button>
            </form>

            <div style="text-align:center;margin-top:20px">
                <a href="{{ route('login') }}" style="font-size:13px;color:#5a7560;text-decoration:none"
                    onmouseover="this.style.color='#4ade80'" onmouseout="this.style.color='#5a7560'">
                    ← লগইনে ফিরুন
                </a>
            </div>
        </div>

        <p style="text-align:center;font-size:11px;color:#5a7560;margin-top:20px">
            © {{ date('Y') }} OnionTrade Pro
        </p>
    </div>

    <script>
        function togglePw(id, eyeId) {
            const i = document.getElementById(id);
            const e = document.getElementById(eyeId);
            i.type = i.type === 'password' ? 'text' : 'password';
            e.textContent = i.type === 'password' ? '👁️' : '🙈';
        }
        function checkMatch() {
            const p1 = document.getElementById('pw-new').value;
            const p2 = document.getElementById('pw-conf').value;
            const lbl = document.getElementById('match-lbl');
            if (!p2) { lbl.textContent = ' '; return; }
            if (p1 === p2) { lbl.style.color = '#4ade80'; lbl.textContent = '✓ পাসওয়ার্ড মিলেছে'; }
            else { lbl.style.color = '#f87171'; lbl.textContent = '✗ পাসওয়ার্ড মিলছে না'; }
        }
    </script>
</body>

</html>