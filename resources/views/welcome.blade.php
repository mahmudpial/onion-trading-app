<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Onion Trade Pro - পেঁয়াজ বাজার ব্যবস্থাপনা</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Syne:wght@700;800&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Hind Siliguri', sans-serif;
        }

        .font-syne {
            font-family: 'Syne', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-green-50 to-blue-50 min-h-screen flex flex-col">
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                        style="background:linear-gradient(135deg,#4ade80,#16a34a);box-shadow:0 4px 12px rgba(22,163,74,0.2)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M12 2L4.5 20.29L5.21 21L12 18L18.79 21L19.5 20.29L12 2Z" />
                        </svg>
                    </div>
                    <span class="font-syne font-extrabold text-xl text-gray-900 tracking-tight">Onion Trade Pro</span>
                </div>
                <a href="{{ route('login') }}"
                    class="px-6 py-2.5 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition-all shadow-lg shadow-green-600/20 active:scale-95">
                    লগইন
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 flex-1">
        <div class="text-center">
            <div
                class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold uppercase tracking-wider mb-6">
                <span class="relative flex h-2 w-2">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                </span>
                সরাসরি আপডেট
            </div>
            <h1 class="text-5xl md:text-7xl font-bold text-gray-900 mb-6 tracking-tight">
                পেঁয়াজ বাজার <br class="hidden md:block"> <span class="text-green-600">ব্যবস্থাপনা সিস্টেম</span>
            </h1>
            <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto leading-relaxed">
                বাংলাদেশের সব বাজারের পেঁয়াজের দাম রিয়েল-টাইমে ট্র্যাক করুন। তথ্যভিত্তিক সিদ্ধান্তের মাধ্যমে আপনার
                ব্যবসার মুনাফা বৃদ্ধি করুন।
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('login') }}"
                    class="px-10 py-4 bg-gray-900 text-white font-bold rounded-2xl hover:bg-black transition-all text-lg shadow-xl active:scale-95">
                    শুরু করুন
                </a>
                <a href="#features"
                    class="px-10 py-4 bg-white border border-gray-200 text-gray-700 font-bold rounded-2xl hover:bg-gray-50 transition-all text-lg active:scale-95">
                    ফিচারসমূহ
                </a>
            </div>
        </div>
    </div>

    <div id="features" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 border-t border-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="p-8 bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-shadow">
                <div class="text-3xl mb-4">📊</div>
                <h3 class="text-xl font-bold mb-2">দাম তুলনা</h3>
                <p class="text-gray-500 text-sm">দেশের বিভিন্ন প্রান্তের বড় বড় পাইকারি বাজারের দাম এখন এক অ্যাপেই।</p>
            </div>
            <div class="p-8 bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-shadow">
                <div class="text-3xl mb-4">📈</div>
                <h3 class="text-xl font-bold mb-2">প্রবণতা বিশ্লেষণ</h3>
                <p class="text-gray-500 text-sm">দামের ওঠানামা গ্রাফের মাধ্যমে বিশ্লেষণ করে ভবিষ্যতের বাজার বুঝতে পারেন।
                </p>
            </div>
            <div class="p-8 bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-shadow">
                <div class="text-3xl mb-4">⚡</div>
                <h3 class="text-xl font-bold mb-2">সরাসরি যোগাযোগ</h3>
                <p class="text-gray-500 text-sm">যেকোনো বাজারের সদস্যদের সাথে সরাসরি যোগাযোগ করার বিশেষ ব্যবস্থা।</p>
            </div>
        </div>
    </div>

    <footer class="bg-white border-t border-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-3 opacity-80">
                    <p class="text-sm font-bold text-gray-500 tracking-tight">
                        &copy; {{ date('Y') }} Onion Trade Pro. <span class="font-normal text-gray-400 ml-2">Smart
                            Management Terminal</span>
                    </p>
                </div>
                <div class="flex items-center gap-4 text-xs font-bold uppercase tracking-widest text-gray-400">
                    <span class="text-green-500">System Live</span>
                    <span>|</span>
                    <span>Secure Access</span>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>