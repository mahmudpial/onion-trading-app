<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>পাসওয়ার্ড ভুলে গেছেন — OnionTrade Pro</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('brand/oniontrade-icon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('brand/oniontrade-icon-180.png') }}">
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

        .ok {
            background: rgba(74, 222, 128, .1);
            border: 1px solid rgba(74, 222, 128, .2);
            color: #4ade80;
            border-radius: 10px;
            padding: 14px 16px;
            font-size: 13px;
            margin-bottom: 16px;
            text-align: center;
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

        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl text-3xl mb-4"
                style="background:linear-gradient(135deg,#4ade80,#16a34a);box-shadow:0 8px 30px rgba(74,222,128,.3)">
                <img src="{{ asset('brand/oniontrade-icon.svg') }}" alt="OnionTrade Icon" class="w-10 h-10">
            </div>
            <h1 style="font-family:Syne,sans-serif;font-weight:800;font-size:22px;color:#f0fdf4">OnionTrade Pro</h1>
            <p class="text-sm mt-1" style="color:#5a7560">পেঁয়াজ বাজার ব্যবস্থাপনা</p>
        </div>

        <div class="glass p-8">

            {{-- Icon --}}
            <div style="text-align:center;margin-bottom:20px">
                <div style="font-size:40px;margin-bottom:8px">🔑</div>
                <h2 style="font-family:Syne,sans-serif;font-weight:700;font-size:18px;color:#f0fdf4">পাসওয়ার্ড ভুলে
                    গেছেন?</h2>
                <p style="font-size:13px;color:#5a7560;margin-top:6px;line-height:1.5">
                    কোনো সমস্যা নেই। আপনার ইমেইল দিন,<br>আমরা রিসেট লিঙ্ক পাঠাবো।
                </p>
            </div>

            @if(session('status'))
                <div class="ok">
                    ✉️ {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div class="err">❌ {{ $errors->first() }}</div>
            @endif

            @unless(session('status'))
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div style="margin-bottom:20px">
                        <label class="lbl">ইমেইল</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="field"
                            placeholder="আপনার নিবন্ধিত ইমেইল" required autofocus>
                    </div>

                    <button type="submit" class="btn-green">পাসওয়ার্ড রিসেট লিঙ্ক পাঠান →</button>
                </form>
            @endunless

            {{-- Back to login --}}
            <div style="text-align:center;margin-top:20px">
                <a href="{{ route('login') }}"
                    style="font-size:13px;color:#5a7560;text-decoration:none;display:inline-flex;align-items:center;gap:6px"
                    onmouseover="this.style.color='#4ade80'" onmouseout="this.style.color='#5a7560'">
                    ← লগইন পেজে ফিরুন
                </a>
            </div>
        </div>

        <p style="text-align:center;font-size:11px;color:#5a7560;margin-top:20px">
            © {{ date('Y') }} OnionTrade Pro — সর্বস্বত্ব সংরক্ষিত
        </p>
    </div>
</body>

</html>
