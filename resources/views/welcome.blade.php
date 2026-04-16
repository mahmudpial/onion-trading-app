<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Onion Trade Pro - পেঁয়াজ বাজার ব্যবস্থাপনা</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('brand/oniontrade-icon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('brand/oniontrade-icon-180.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Hind Siliguri', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-green-50 to-blue-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('brand/oniontrade-icon.svg') }}" alt="OnionTrade Icon" class="w-8 h-8">
                    <span class="font-bold text-xl text-gray-800">Onion Trade Pro</span>
                </div>
                <a href="{{ route('login') }}"
                    class="px-6 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                    লগইন
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                পেঁয়াজ বাজার ব্যবস্থাপনা সিস্টেম
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                বাংলাদেশের সব বাজারের পেঁয়াজের দাম ট্র্যাক করুন, তুলনা করুন এবং সেরা ক্রয়-বিক্রয়ের সিদ্ধান্ত নিন
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-3 sm:gap-4">
                <a href="{{ route('login') }}"
                    class="px-8 py-4 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors text-lg">
                    শুরু করুন
                </a>
                <a href="#features"
                    class="px-8 py-4 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors text-lg">
                    জানুন
                </a>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">মূল বৈশিষ্ট্য</h2>
            <p class="text-lg text-gray-600">আমাদের সিস্টেমের বিশেষ সুবিধাসমূহ</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">দাম তুলনা</h3>
                <p class="text-gray-600">সব বাজারের দাম এক নজরে দেখুন এবং তুলনা করুন</p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">প্রবণতা বিশ্লেষণ</h3>
                <p class="text-gray-600">দামের পরিবর্তনের গ্রাফ এবং বিশ্লেষণ দেখুন</p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">দ্রুত যোগাযোগ</h3>
                <p class="text-gray-600">এক ক্লিকেই বাজারের সদস্যের সাথে যোগাযোগ</p>
            </div>

            <!-- Feature 4 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">সহজ ব্যবহার</h3>
                <p class="text-gray-600">সহজ এবং ব্যবহারবান্ধব ইন্টারফেস</p>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-white border-y border-gray-200 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold text-green-600 mb-2">৮+</div>
                    <div class="text-lg text-gray-600">বাজার</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-blue-600 mb-2">সারাদেশ</div>
                    <div class="text-lg text-gray-600">কভারেজ</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-purple-600 mb-2">২৪/৭</div>
                    <div class="text-lg text-gray-600">সেবা</div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">প্রস্তুত শুরু করতে?</h2>
        <p class="text-lg text-gray-600 mb-8">এখনই লগইন করুন এবং আপনার ব্যবসা পরিচালনা করুন স্মার্টলি</p>
        <a href="{{ route('login') }}"
            class="inline-flex items-center px-8 py-4 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors text-lg">
            লগইন করুন
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </a>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-gray-400">&copy; 2024 Onion Trade Pro. সর্বস্বত্ব সংরক্ষিত।</p>
        </div>
    </footer>
</body>

</html>
