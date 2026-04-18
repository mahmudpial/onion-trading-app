<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>রেজিস্ট্রেশন — OnionTrade Pro</title>
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

        .field-error {
            font-size: 11px;
            color: #f87171;
            margin-top: 5px;
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

        .strength-bar {
            height: 4px;
            border-radius: 2px;
            transition: .3s;
            margin-top: 6px;
        }

        @media (max-width: 640px) {
            .glass {
                padding: 1.25rem !important;
            }
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 py-10">

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
            <p class="text-sm mt-1" style="color:#5a7560">পেঁয়াজ বাজার ব্যবস্থাপনা</p>
        </div>

        <div class="glass p-8">
            <h2 style="font-family:Syne,sans-serif;font-weight:700;font-size:18px;color:#f0fdf4;margin-bottom:6px">
                অ্যাকাউন্ট তৈরি করুন
            </h2>
            <p style="font-size:13px;color:#5a7560;margin-bottom:24px">
                ফ্রিতে শুরু করুন — কোনো ক্রেডিট কার্ড লাগবে না
            </p>

            @if($errors->any())
                <div class="err">❌ {{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('register.post') }}" id="reg-form">
                @csrf

                <div style="margin-bottom:16px">
                    <label class="lbl">পুরো নাম</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="field {{ $errors->has('name') ? 'has-error' : '' }}" placeholder="যেমন: মো. রফিকুল ইসলাম"
                        required autocomplete="name">
                    @error('name')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div style="margin-bottom:16px">
                    <label class="lbl">ইমেইল</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="field {{ $errors->has('email') ? 'has-error' : '' }}" placeholder="আপনার ইমেইল" required
                        autocomplete="email">
                    @error('email')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div style="margin-bottom:16px">
                    <label class="lbl">পাসওয়ার্ড (কমপক্ষে ৮ অক্ষর)</label>
                    <div style="position:relative">
                        <input type="password" name="password" id="pw-reg"
                            class="field {{ $errors->has('password') ? 'has-error' : '' }}"
                            placeholder="শক্তিশালী পাসওয়ার্ড দিন" required oninput="checkStrength(this.value)"
                            style="padding-right:44px">
                        <button type="button" onclick="togglePw('pw-reg','eye-reg')"
                            style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;font-size:15px">
                            <span id="eye-reg">👁️</span>
                        </button>
                    </div>
                    <div id="strength-bar" class="strength-bar" style="background:#2a3d2f;width:100%">
                        <div id="strength-fill" style="height:100%;border-radius:2px;width:0;transition:.3s"></div>
                    </div>
                    <p id="strength-label" style="font-size:10px;color:#5a7560;margin-top:3px"> </p>
                    @error('password')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div style="margin-bottom:24px">
                    <label class="lbl">পাসওয়ার্ড নিশ্চিত করুন</label>
                    <div style="position:relative">
                        <input type="password" name="password_confirmation" id="pw-confirm" class="field"
                            placeholder="আবার একই পাসওয়ার্ড দিন" required style="padding-right:44px">
                        <button type="button" onclick="togglePw('pw-confirm','eye-confirm')"
                            style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;font-size:15px">
                            <span id="eye-confirm">👁️</span>
                        </button>
                    </div>
                    <p id="match-label" style="font-size:10px;margin-top:3px;color:#5a7560"> </p>
                </div>

                <p style="font-size:11px;color:#5a7560;margin-bottom:16px;line-height:1.6">
                    রেজিস্ট্রেশন করলে আপনি আমাদের
                    <span style="color:#9ab09e">সেবার শর্তাবলী</span> ও
                    <span style="color:#9ab09e">গোপনীয়তা নীতি</span> মেনে নিচ্ছেন।
                </p>

                <button type="submit" class="btn-green">অ্যাকাউন্ট তৈরি করুন →</button>
            </form>

            <div style="text-align:center;margin-top:20px;font-size:13px;color:#9ab09e">
                ইতিমধ্যে অ্যাকাউন্ট আছে?
                <a href="{{ route('login') }}" style="color:#4ade80;text-decoration:none;font-weight:600"
                    onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                    লগইন করুন
                </a>
            </div>
        </div>

        <p style="text-align:center;font-size:11px;color:#5a7560;margin-top:20px">
            © {{ date('Y') }} OnionTrade Pro — সর্বস্বত্ব সংরক্ষিত
        </p>
    </div>

    <script>
        function togglePw(id, eyeId) {
            const i = document.getElementById(id);
            const e = document.getElementById(eyeId);
            i.type = i.type === 'password' ? 'text' : 'password';
            e.textContent = i.type === 'password' ? '👁️' : '🙈';
        }

        function checkStrength(pw) {
            const fill = document.getElementById('strength-fill');
            const label = document.getElementById('strength-label');
            if (!pw) { fill.style.width = '0'; label.textContent = ' '; return; }
            let score = 0;
            if (pw.length >= 8) score++;
            if (/[A-Z]/.test(pw)) score++;
            if (/[0-9]/.test(pw)) score++;
            if (/[^A-Za-z0-9]/.test(pw)) score++;
            const levels = [
                { pct: '25%', color: '#f87171', text: 'দুর্বল পাসওয়ার্ড' },
                { pct: '50%', color: '#f87171', text: 'দুর্বল পাসওয়ার্ড' },
                { pct: '66%', color: '#fbbf24', text: 'মোটামুটি পাসওয়ার্ড' },
                { pct: '85%', color: '#fbbf24', text: 'ভালো পাসওয়ার্ড' },
                { pct: '100%', color: '#4ade80', text: 'শক্তিশালী পাসওয়ার্ড ✓' },
            ];
            const lvl = levels[Math.min(score, 4)];
            fill.style.width = lvl.pct;
            fill.style.background = lvl.color;
            label.style.color = lvl.color;
            label.textContent = lvl.text;
        }

        document.getElementById('pw-confirm').addEventListener('input', function () {
            const pw1 = document.getElementById('pw-reg').value;
            const lbl = document.getElementById('match-label');
            if (!this.value) { lbl.textContent = ' '; return; }
            if (this.value === pw1) {
                lbl.style.color = '#4ade80';
                lbl.textContent = '✓ পাসওয়ার্ড মিলেছে';
            } else {
                lbl.style.color = '#f87171';
                lbl.textContent = '✗ পাসওয়ার্ড মিলছে না';
            }
        });
    </script>
</body>

</html>