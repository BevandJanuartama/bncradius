<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>BNC - Borneo Network Center</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <!-- Lottie Script -->

  <!-- ===========================================================
                    MADE BY @jnrtma
     DM ME IF YOU ARE INTERESTED IN COLLABORATION!!!
     =========================================================== -->

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
    
    body {
      font-family: 'Inter', sans-serif;
      scroll-behavior: smooth;
    }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar {
      width: 6px;
    }
    ::-webkit-scrollbar-track {
      background: #f1f5f9;
    }
    ::-webkit-scrollbar-thumb {
      background: linear-gradient(135deg, #3F8EFC 0%, #6B46C1 100%);
      border-radius: 3px;
    }
    
    /* Enhanced animations */
    .fade-element {
      opacity: 0;
      transform: translateY(30px);
      transition: all 0.8s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    .fade-element.visible {
      opacity: 1;
      transform: translateY(0);
    }
    
    /* Modern gradients */
    .gradient-bg {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .gradient-text {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    
    /* Glass morphism effect */
    .glass {
      background: rgba(255, 255, 255, 0.25);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.18);
    }
    
    /* Enhanced hover effects */
    .card-hover {
      transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .card-hover:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    
    /* Modern button styles */
    .btn-primary {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border: none;
      color: white;
      padding: 12px 24px;
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px 0 rgba(102, 126, 234, 0.3);
    }
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px 0 rgba(102, 126, 234, 0.4);
    }
    
    .btn-secondary {
      background: rgba(255, 255, 255, 0.1);
      border: 2px solid rgba(255, 255, 255, 0.2);
      color: white;
      padding: 10px 22px;
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.3s ease;
      backdrop-filter: blur(10px);
    }
    .btn-secondary:hover {
      background: rgba(255, 255, 255, 0.2);
      transform: translateY(-2px);
    }
    
    /* Floating animation */
    @keyframes float {
      0%, 100% { transform: translateY(0px) rotate(0deg); }
      25% { transform: translateY(-10px) rotate(1deg); }
      50% { transform: translateY(-20px) rotate(0deg); }
      75% { transform: translateY(-10px) rotate(-1deg); }
    }
    .floating {
      animation: float 6s ease-in-out infinite;
    }
    
    /* Pulse animation */
    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.8; }
    }
    .pulse-slow {
      animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    /* Modern accordion */
    .accordion-item {
      background: white;
      border-radius: 16px;
      overflow: hidden;
      margin-bottom: 16px;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
      border: 1px solid rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
    }
    .accordion-item:hover {
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.15);
    }
    
    .accordion-button {
      background: transparent;
      color: #1f2937;
      font-weight: 600;
      padding: 20px 24px;
      width: 100%;
      text-align: left;
      border: none;
      outline: none;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .accordion-button:hover {
      background: rgba(102, 126, 234, 0.05);
    }
    
    .accordion-icon {
      transition: transform 0.3s ease;
      color: #667eea;
    }
    .accordion-button.collapsed .accordion-icon {
      transform: rotate(180deg);
    }
    
    .accordion-body {
      padding: 0 24px;
      max-height: 0;
      overflow: hidden;
      transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
      color: #6b7280;
      line-height: 1.6;
    }
    .accordion-body.show {
      padding: 0 24px 24px 24px;
      max-height: 200px;
    }
    
    /* Enhanced pricing cards */
    .pricing-card {
      transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
      border: 2px solid rgba(0, 0, 0, 0.08);
      position: relative;
      overflow: hidden;
    }
    .pricing-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 4px;
      background: linear-gradient(90deg, #667eea, #764ba2);
      transition: left 0.5s ease;
    }
    .pricing-card:hover::before {
      left: 0;
    }
    .pricing-card:hover {
      transform: translateY(-12px);
      box-shadow: 0 20px 40px -12px rgba(102, 126, 234, 0.3);
      border-color: rgba(102, 126, 234, 0.3);
    }
    
    /* Modern navigation */
    .nav-link {
      position: relative;
      padding: 8px 0;
      transition: all 0.3s ease;
    }
    .nav-link::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      width: 0;
      height: 2px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      transition: all 0.3s ease;
      transform: translateX(-50%);
    }
    .nav-link:hover::after {
      width: 100%;
    }
    
    /* Feature icons enhancement */
    .feature-icon {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
      transition: all 0.3s ease;
    }
    .feature-icon:hover {
      transform: scale(1.1);
      box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
    }
    
    /* Mobile optimizations */
    @media (max-width: 768px) {
      .card-hover:hover {
        transform: translateY(-4px) scale(1.01);
      }
      .pricing-card:hover {
        transform: translateY(-6px);
      }
    }
  </style>
</head>
<body class="bg-slate-50 text-gray-800 antialiased">

  <!-- HEADER -->
  <header id="mainHeader" class="fixed top-0 left-0 w-full z-50 bg-white/80 backdrop-blur-md shadow-sm transition-all duration-500 border-b border-white/20">
    <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
      
      <!-- Logo + Title -->
      <div class="flex items-center gap-3">
        <img src="assets/img/logo-bnc.png" class="w-12 h-12 object-contain" alt="Logo BNC">
        <div class="leading-tight">
          <h1 class="text-lg font-bold gradient-text">BORNEO</h1>
          <p class="text-sm font-semibold gradient-text">Network Center</p>
        </div>
      </div>

      <!-- Burger Button (Mobile) -->
      <button id="burgerBtn" class="md:hidden text-2xl text-gray-700 hover:text-purple-600 transition-colors">
        <i class="ri-menu-line"></i>
      </button>

      <!-- Navigation (Desktop) -->
      <nav class="hidden md:flex items-center gap-8">
        <a href="#beranda" class="nav-link text-gray-700 hover:text-purple-600 font-medium">Beranda</a>
        <a href="#tentang" class="nav-link text-gray-700 hover:text-purple-600 font-medium">Tentang</a>
        <a href="#fitur" class="nav-link text-gray-700 hover:text-purple-600 font-medium">Fitur</a>
        <a href="#harga" class="nav-link text-gray-700 hover:text-purple-600 font-medium">Harga</a>
        <a href="#footer" class="nav-link text-gray-700 hover:text-purple-600 font-medium">Kontak</a>
        <div class="flex items-center gap-3 ml-4">
          <a href="{{ route('login') }}" class="btn-primary text-sm">Login</a>
          <a href="{{ route('register') }}" class="px-4 py-2 border-2 border-purple-200 text-purple-600 rounded-xl hover:bg-purple-50 transition-all font-semibold text-sm">Register</a>
        </div>
      </nav>
    </div>
  </header>


  <!-- OVERLAY & SIDEBAR -->
  <div id="overlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 hidden transition-all duration-300"></div>
  <div id="sidebar" class="fixed top-0 right-0 w-80 h-full bg-white/95 backdrop-blur-xl shadow-2xl z-50 transform translate-x-full transition-transform duration-500">
    <div class="p-8 space-y-6 mt-20">
      <div class="space-y-4">
        <a href="#beranda" class="block text-lg font-medium text-gray-700 hover:text-purple-600 transition-colors py-2">Beranda</a>
        <a href="#tentang" class="block text-lg font-medium text-gray-700 hover:text-purple-600 transition-colors py-2">Tentang</a>
        <a href="#fitur" class="block text-lg font-medium text-gray-700 hover:text-purple-600 transition-colors py-2">Fitur</a>
        <a href="#harga" class="block text-lg font-medium text-gray-700 hover:text-purple-600 transition-colors py-2">Harga</a>
        <a href="#footer" class="block text-lg font-medium text-gray-700 hover:text-purple-600 transition-colors py-2">Kontak</a>
      </div>
      <div class="pt-6 border-t border-gray-200 space-y-3">
        <a href="{{ route('login') }}" class="btn-primary w-full text-center block">Login</a>
        <a href="{{ route('register') }}" class="block w-full text-center px-4 py-3 border-2 border-purple-200 text-purple-600 rounded-xl hover:bg-purple-50 transition-all font-semibold">Register</a>
      </div>
    </div>
  </div>

  <!-- HERO SECTION -->
<section id="beranda" class="pt-28 pb-20 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 relative overflow-hidden">
  <!-- Background decorations -->
  <div class="absolute inset-0 opacity-10">
    <div class="absolute top-20 left-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl animate-pulse"></div>
    <div class="absolute top-40 right-10 w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl animate-pulse animation-delay-2000"></div>
    <div class="absolute -bottom-20 left-20 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl animate-pulse animation-delay-4000"></div>
  </div>

  <div class="container mx-auto px-6 relative z-10">
    <div class="lg:flex lg:items-center lg:gap-16">
      <!-- TEXT -->
      <div class="lg:w-3/5 mb-12 lg:mb-0 fade-element text-center lg:text-left">
        <h1 class="text-4xl md:text-6xl font-bold mb-6 text-gray-800 leading-tight">
          BILLING MIKROTIK 
          <span class="gradient-text block">PPPOE & HOTSPOT</span>
        </h1>
        
        <p class="text-xl md:text-2xl text-gray-600 mb-8 leading-relaxed">
          Aplikasi billing dan server radius yang <span class="font-semibold text-purple-600">powerful</span> 
          untuk mengelola jaringan ISP Anda dengan mudah dan efisien
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start text-center sm:text-left">
          <a href="#harga" class="btn-primary text-lg px-8 py-4 inline-flex items-center gap-2 justify-center">
            <i class="ri-rocket-line"></i>
            Mulai Berlangganan
          </a>
          <a href="#fitur" class="btn-secondary text-lg px-8 py-4 inline-flex items-center gap-2 justify-center bg-white/70 text-gray-700 border-gray-200 hover:bg-white/90">
            <i class="ri-play-circle-line"></i>
            Lihat Demo
          </a>
        </div>
      </div>
      
      <!-- IMAGE -->
      <div class="lg:w-2/5 fade-element">
        <div class="relative">
          <!-- Background Glow -->
          <div class="absolute inset-0 bg-gradient-to-r from-purple-400 to-pink-400 rounded-3xl blur-2xl opacity-30 floating"></div>
          
          <!-- Flaticon Image -->
          <img src="https://cdn-icons-png.flaticon.com/512/3598/3598180.png" 
               class="relative w-full max-w-lg mx-auto floating drop-shadow-2xl" 
               alt="BNC Radius Logo">
        </div>
      </div>
    </div>
  </div>
</section>


  <!-- VALUES SECTION -->
  <section id="tentang" class="py-20 bg-white relative">
    <div class="container mx-auto px-6">
      <header class="text-center mb-16 fade-element">
        <div class="inline-block px-4 py-2 bg-purple-100 rounded-full text-md font-semibold text-purple-600 mb-4">
          Mengapa Memilih Kami?
        </div>
        {{-- <h2 class="text-4xl md:text-2xl font-bold text-gray-800 mb-6">Keunggulan BNC Radius</h2> --}}
        <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
          Solusi lengkap untuk manajemen jaringan ISP dengan teknologi terdepan dan dukungan terbaik. 
          Didesain untuk meningkatkan efisiensi, memaksimalkan performa, dan memastikan pengalaman pelanggan yang lebih andal.
        </p>
      </header>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="group bg-gradient-to-br from-blue-50 to-indigo-100 p-8 rounded-2xl shadow-lg card-hover fade-element text-center">
          <div class="feature-icon w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
            <i class="ri-cloud-fill text-3xl text-white"></i>
          </div>
          <h3 class="text-xl font-bold mb-4 text-gray-800">Mudah Digunakan</h3>
          <p class="text-gray-600 leading-relaxed">
            Interface intuitif dengan desain modern yang dapat diakses dari mana saja. Dukungan multi-platform untuk kemudahan maksimal.
          </p>
        </div>

        <div class="group bg-gradient-to-br from-green-50 to-emerald-100 p-8 rounded-2xl shadow-lg card-hover fade-element text-center">
          <div class="feature-icon w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
            <i class="ri-cpu-fill text-3xl text-white"></i>
          </div>
          <h3 class="text-xl font-bold mb-4 text-gray-800">Sistem Otomatis</h3>
          <p class="text-gray-600 leading-relaxed">
            Otomatisasi lengkap untuk tagihan, notifikasi, isolir hingga pelunasan dengan berbagai metode pembayaran modern.
          </p>
        </div>

        <div class="group bg-gradient-to-br from-purple-50 to-pink-100 p-8 rounded-2xl shadow-lg card-hover fade-element text-center">
          <div class="feature-icon w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
            <i class="ri-database-2-fill text-3xl text-white"></i>
          </div>
          <h3 class="text-xl font-bold mb-4 text-gray-800">Data Terpusat</h3>
          <p class="text-gray-600 leading-relaxed">
            Satu aplikasi untuk mengelola multiple MikroTik. Klien dapat terhubung dari mana saja dengan satu akun universal.
          </p>
        </div>
      </div>

  </section>

  <!-- SUPPORT SECTION -->
  <section class="py-20 bg-gradient-to-r from-purple-600 to-blue-600 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>
    
    <div class="container mx-auto px-6 text-center relative z-10 fade-element">
      <div class="max-w-4xl mx-auto">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl mb-8">
          <i class="ri-customer-service-fill text-4xl text-white"></i>
        </div>
        
        <h3 class="text-3xl md:text-4xl font-bold text-white mb-6">
          Support Gratis 100%
        </h3>
        
        <p class="text-xl text-white/90 leading-relaxed mb-8">
          Tim teknisi berpengalaman siap membantu Anda 24/7. Dukungan penuh untuk semua permasalahan yang berkaitan dengan aplikasi BNC Radius.
        </p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
          <div class="glass p-6 rounded-2xl">
            <i class="ri-phone-fill text-3xl text-white mb-4 block"></i>
            <h4 class="font-semibold text-white mb-2">Phone Support</h4>
            <p class="text-white/80 text-sm">Hubungi langsung tim kami</p>
          </div>
          <div class="glass p-6 rounded-2xl">
            <i class="ri-chat-3-fill text-3xl text-white mb-4 block"></i>
            <h4 class="font-semibold text-white mb-2">Live Chat</h4>
            <p class="text-white/80 text-sm">Response cepat via chat</p>
          </div>
          <div class="glass p-6 rounded-2xl">
            <i class="ri-mail-fill text-3xl text-white mb-4 block"></i>
            <h4 class="font-semibold text-white mb-2">Email Support</h4>
            <p class="text-white/80 text-sm">Dokumentasi lengkap</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FEATURES SECTION -->
  <section id="fitur" class="py-20 bg-gray-50">
    <div class="container mx-auto px-6">
      <header class="text-center mb-16 fade-element">
        <div class="inline-block px-4 py-2 bg-purple-100 rounded-full text-md font-semibold text-purple-600 mb-4">
          Fitur Unggulan
        </div>
        {{-- <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">Yang Membuat Kami Berbeda</h2> --}}
        <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
          Teknologi canggih yang dirancang khusus untuk memudahkan pengelolaan jaringan ISP Anda
        </p>
      </header>

      <div class="flex flex-wrap items-center">
        <div class="w-full xl:w-1/3 text-center xl:text-left -mt16 fade-element">
          <img src="assets/img/svg/fitur.svg" class="mx-auto xl:mx-0 w-full max-w-[600px] p-2 floating" alt="fitur billing mikrotik bnc radius">
        </div>

        <div class="w-full xl:w-3/5 xl:pl-12 fade-element">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Card 1 -->
            <div class="group bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-blue-500">
              <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mr-4 
                            group-hover:scale-110 transition-transform flex-shrink-0">
                  <i class="ri-award-fill text-xl text-white"></i>
                </div>
                <div>
                  <h4 class="font-bold text-gray-800 mb-2">Terpercaya & Teruji</h4>
                  <p class="text-gray-600 text-sm leading-relaxed">
                    Digunakan ribuan ISP di seluruh Indonesia dengan track record excellent.
                  </p>
                </div>
              </div>
            </div>

            <!-- Card 2 -->
            <div class="group bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-green-500">
              <div class="flex items-center">
                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mr-4 
                            group-hover:scale-110 transition-transform flex-shrink-0">
                  <i class="ri-cpu-line text-xl text-white"></i>
                </div>
                <div>
                  <h4 class="font-bold text-gray-800 mb-2">Resource Ringan</h4>
                  <p class="text-gray-600 text-sm leading-relaxed">
                    Cloud-based storage mengurangi beban pada perangkat MikroTik Anda.
                  </p>
                </div>
              </div>
            </div>

            <!-- Card 3 -->
            <div class="group bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-purple-500">
              <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mr-4 
                            group-hover:scale-110 transition-transform flex-shrink-0">
                  <i class="ri-shield-check-line text-xl text-white"></i>
                </div>
                <div>
                  <h4 class="font-bold text-gray-800 mb-2">Data Aman</h4>
                  <p class="text-gray-600 text-sm leading-relaxed">
                    Backup otomatis dan keamanan enterprise-grade untuk melindungi data.
                  </p>
                </div>
              </div>
            </div>

            <!-- Card 4 -->
            <div class="group bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-orange-500">
              <div class="flex items-center">
                <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center mr-4 
                            group-hover:scale-110 transition-transform flex-shrink-0">
                  <i class="ri-team-line text-xl text-white"></i>
                </div>
                <div>
                  <h4 class="font-bold text-gray-800 mb-2">Sistem Mitra</h4>
                  <p class="text-gray-600 text-sm leading-relaxed">
                    Program kemitraan dengan sistem komisi dan manajemen independen.
                  </p>
                </div>
              </div>
            </div>

            <!-- Card 5 -->
            <div class="group bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-indigo-500">
              <div class="flex items-center">
                <div class="w-12 h-12 bg-indigo-500 rounded-lg flex items-center justify-center mr-4 
                            group-hover:scale-110 transition-transform flex-shrink-0">
                  <i class="ri-file-chart-line text-xl text-white"></i>
                </div>
                <div>
                  <h4 class="font-bold text-gray-800 mb-2">Laporan Detail</h4>
                  <p class="text-gray-600 text-sm leading-relaxed">
                    Analytics lengkap dengan export data ke berbagai format file.
                  </p>
                </div>
              </div>
            </div>

            <!-- Card 6 -->
            <div class="group bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-pink-500">
              <div class="flex items-center">
                <div class="w-12 h-12 bg-pink-500 rounded-lg flex items-center justify-center mr-4 
                            group-hover:scale-110 transition-transform flex-shrink-0">
                  <i class="ri-file-excel-2-line text-xl text-white"></i>
                </div>
                <div>
                  <h4 class="font-bold text-gray-800 mb-2">Export & Import</h4>
                  <p class="text-gray-600 text-sm leading-relaxed">
                    Dukungan penuh untuk Excel dan integrasi dengan sistem lain.
                  </p>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- SERVICES SECTION -->
  <section class="py-20 bg-white">
    <div class="container mx-auto px-6">
      <header class="text-center mb-16 fade-element">
        <div class="inline-block px-4 py-2 bg-purple-100 rounded-full text-md font-semibold text-purple-600 mb-4">
          Infrastruktur Pendukung
        </div>
        {{-- <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">Fasilitas Enterprise</h2> --}}
        <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
          Infrastruktur cloud terdepan untuk memastikan performa optimal dan keandalan maksimal
        </p>
      </header>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
  <!-- Card 1 -->
  <div class="group relative bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 p-8 rounded-2xl shadow-lg card-hover fade-element overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 text-center">
    <!-- Glow effect -->
    <div class="absolute inset-0 bg-gradient-to-tr from-indigo-400 via-purple-400 to-transparent opacity-0 group-hover:opacity-20 blur-2xl transition duration-500"></div>
    
    <div class="relative mb-6">
      <div class="w-16 h-16 bg-gradient-to-tr from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto shadow-lg group-hover:scale-110 transition-transform duration-500">
        <i class="ri-server-fill text-3xl text-white"></i>
      </div>
    </div>
    <h3 class="font-bold text-xl mb-4 text-gray-800 group-hover:text-indigo-700 transition">VPN Server Global</h3>
    <p class="text-gray-600 leading-relaxed mb-6">
      Jaringan server VPN tersebar di berbagai lokasi dengan latency rendah dan koneksi stabil untuk akses remote yang optimal.
    </p>
    <div class="flex items-center justify-center text-sm text-purple-600 font-semibold">
      <i class="ri-global-line mr-2"></i>
      Multi-Location Servers
    </div>
  </div>

  <!-- Card 2 -->
  <div class="group relative bg-gradient-to-br from-orange-50 via-red-50 to-pink-50 p-8 rounded-2xl shadow-lg card-hover fade-element overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 text-center">
    <div class="absolute inset-0 bg-gradient-to-tr from-red-300 via-orange-300 to-transparent opacity-0 group-hover:opacity-20 blur-2xl transition duration-500"></div>

    <div class="relative mb-6">
      <div class="w-16 h-16 bg-gradient-to-tr from-red-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto shadow-lg group-hover:scale-110 transition-transform duration-500">
        <i class="ri-database-fill text-3xl text-white"></i>
      </div>
    </div>
    <h3 class="font-bold text-xl mb-4 text-gray-800 group-hover:text-red-600 transition">Server Enterprise</h3>
    <p class="text-gray-600 leading-relaxed mb-6">
      Infrastruktur data center Indonesia dengan spesifikasi enterprise, sistem keamanan berlapis, dan monitoring 24/7.
    </p>
    <div class="flex items-center justify-center text-sm text-red-600 font-semibold">
      <i class="ri-shield-star-line mr-2"></i>
      99.9% Uptime Guarantee
    </div>
  </div>

  <!-- Card 3 -->
  <div class="group relative bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 p-8 rounded-2xl shadow-lg card-hover fade-element overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 text-center">
    <div class="absolute inset-0 bg-gradient-to-tr from-emerald-300 via-green-300 to-transparent opacity-0 group-hover:opacity-20 blur-2xl transition duration-500"></div>

    <div class="relative mb-6">
      <div class="w-16 h-16 bg-gradient-to-tr from-green-500 to-teal-600 rounded-2xl flex items-center justify-center mx-auto shadow-lg group-hover:scale-110 transition-transform duration-500">
        <i class="ri-refresh-line text-3xl text-white"></i>
      </div>
    </div>
    <h3 class="font-bold text-xl mb-4 text-gray-800 group-hover:text-emerald-600 transition">Backup Otomatis</h3>
    <p class="text-gray-600 leading-relaxed mb-6">
      Sistem backup multi-layer dengan RAID storage, snapshot otomatis, dan disaster recovery untuk keamanan data maksimal.
    </p>
    <div class="flex items-center justify-center text-sm text-emerald-600 font-semibold">
      <i class="ri-archive-line mr-2"></i>
      Auto Recovery System
    </div>
  </div>
</div>

    </div>
  </section>

  <!-- PRICING SECTION -->
<section id="harga" class="py-16 bg-gray-50">
  <div class="container mx-auto px-6">
    <header class="text-center mb-12 fade-element">
      <div class="inline-block px-4 py-2 bg-purple-100 rounded-full text-md font-semibold text-purple-600 mb-4">
          Harga Berlanggganan
        </div>
      <p class="text-lg text-gray-600 max-w-2xl mx-auto">Pilih paket yang sesuai dengan kebutuhan bisnis Anda</p>
    </header>

    <!-- Alert Informasi -->
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-8 rounded-r fade-element">
      <div class="flex items-start">
        <div class="flex-shrink-0">
          <i class="ri-alert-fill text-red-500 text-xl"></i>
        </div>
        <div class="ml-3">
          <ol class="text-sm text-red-700 space-y-1">
            <li>1. User Online lebih dari 10.000 tersedia paket Platinum.</li>
            <li>2. Langganan = PPPoE, DHCP & Hotspot berlangganan.</li>
            <li>3. User Online = jumlah client aktif di Mikrotik (R).</li>
            <li>4. Harga dapat berubah sewaktu-waktu tanpa pemberitahuan.</li>
          </ol>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach ($pakets as $paket)
        <div class="bg-white rounded-2xl shadow-md pricing-card p-8 flex flex-col justify-between border-2 border-indigo-600">
          <div>
            <h3 class="text-xl font-bold text-indigo-600 mb-2 text-center">BNC CLOUD {{ strtoupper($paket->nama) }}</h3>
            <div class="text-center text-3xl font-extrabold text-indigo-600 mb-4">
              <sup class="text-base font-medium">Rp</sup>{{ number_format($paket->harga_bulanan, 0, ',', '.') }}<span class="text-base font-normal"> / bln</span>
            </div>
            <img src="https://cdn-icons-png.flaticon.com/512/2082/2082812.png" class="w-20 mx-auto mb-6" alt="Cloud Icon">
            <ul class="text-gray-700 space-y-3 mb-6 text-sm">
              <li class="flex items-center justify-center"><i class="ri-check-line text-green-500 mt-1 mr-2"></i> {{ $paket->mikrotik }} Router MikroTik</li>
              <li class="flex items-center justify-center"><i class="ri-check-line text-green-500 mt-1 mr-2"></i> {{ number_format($paket->langganan, 0, ',', '.') }} Langganan</li>
              <li class="flex items-center justify-center"><i class="ri-check-line text-green-500 mt-1 mr-2"></i> {{ number_format($paket->voucher, 0, ',', '.') }} Voucher</li>
              <li class="flex items-center justify-center"><i class="ri-check-line text-green-500 mt-1 mr-2"></i> <span class="font-semibold text-indigo-600">{{ number_format($paket->user_online, 0, ',', '.') }} User Online</span></li>

              @php
                $fiturTambahan = [
                  'vpn_tunnel' => 'Free VPN Radius',
                  'vpn_remote' => 'Free VPN Remote',
                  'whatsapp_gateway' => 'WhatsApp notifikasi',
                  'payment_gateway' => 'Payment Gateway',
                  'client_area' => 'Aplikasi client area',
                  'custom_domain' => 'Custom Domain',
                ];
              @endphp

              @foreach ($fiturTambahan as $key => $label)
              <li class="flex items-center justify-center">
                <i class="{{ $paket->$key ? 'ri-check-line text-green-500' : 'ri-close-line text-gray-400' }} mt-1 mr-2"></i>
                <span class="{{ $paket->$key ? '' : 'text-gray-400 line-through' }}">{{ $label }}</span>
              </li>
              @endforeach
            </ul>
          </div>
          <div class="text-center text-sm mb-4">
            <p class="text-gray-400 line-through">Rp{{ number_format((int)$paket->harga_bulanan * 12, 0, ',', '.') }} / 12 Bln</p>
            <p class="text-green-600 font-bold">Rp{{ number_format($paket->harga_tahunan, 0, ',', '.') }} / 12 Bln</p>
          </div>
          <a href="{{ route('login') }}" class="block w-full text-center px-4 py-3 border border-{{ $loop->index == 2 ? 'purple-600' : '[#3F8EFC]' }} text-{{ $loop->index == 2 ? 'purple-600' : '[#3F8EFC]' }} font-medium rounded-lg hover:bg-{{ $loop->index == 2 ? 'purple-50' : 'blue-50' }} transition">Berlangganan</a>
        </div>
        @endforeach
      </div>
  </div>
</section>

  <!-- FAQ SECTION -->
  <section id="faq" class="py-20 bg-white">
    <div class="container mx-auto px-6 max-w-6xl">
      <header class="text-center mb-16 fade-element">
        <div class="inline-block px-4 py-2 bg-purple-100 rounded-full text-md font-semibold text-purple-600 mb-4">
          FAQ
        </div>
        {{-- <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6"></h2> --}}
        <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
          Temukan jawaban untuk pertanyaan yang paling sering diajukan tentang BNC Radius
        </p>
      </header>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="accordion-item fade-element">
          <button class="accordion-button collapsed" type="button">
            <span>Apa yang dimaksud dengan BNC Radius?</span>
            <i class="ri-arrow-up-s-line accordion-icon text-2xl"></i>
          </button>
          <div class="accordion-body">
            <p>BNC Radius adalah aplikasi billing untuk MikroTik (PPPoE, DHCP, dan Hotspot) yang dikembangkan menggunakan teknologi cloud dan sistem Radius untuk memberikan solusi manajemen jaringan ISP yang komprehensif.</p>
          </div>
        </div>

        <div class="accordion-item fade-element">
          <button class="accordion-button collapsed" type="button">
            <span>Bisakah digabung dengan aplikasi lain?</span>
            <i class="ri-arrow-up-s-line accordion-icon text-2xl"></i>
          </button>
          <div class="accordion-body">
            <p>Ya, BNC Radius dapat diintegrasikan dengan aplikasi lain yang bukan berbasis radius, seperti Mikhmon atau Mikrostator, memberikan fleksibilitas dalam pengelolaan sistem existing Anda.</p>
          </div>
        </div>

        <div class="accordion-item fade-element">
          <button class="accordion-button collapsed" type="button">
            <span>Apakah perlu reset MikroTik yang sudah ada?</span>
            <i class="ri-arrow-up-s-line accordion-icon text-2xl"></i>
          </button>
          <div class="accordion-body">
            <p>Tidak perlu reset sama sekali. Anda hanya perlu menambahkan konfigurasi tambahan untuk menghubungkan MikroTik existing ke server BNC Radius tanpa mengganggu setting yang sudah berjalan.</p>
          </div>
        </div>

        <div class="accordion-item fade-element">
          <button class="accordion-button collapsed" type="button">
            <span>Apakah VPN bisa untuk remote perangkat?</span>
            <i class="ri-arrow-up-s-line accordion-icon text-2xl"></i>
          </button>
          <div class="accordion-body">
            <p>Ya, layanan VPN dapat digunakan untuk keperluan remote access perangkat dengan aman. Fitur ini tersedia mulai dari paket Cloud Premium dengan koneksi yang stabil dan aman.</p>
          </div>
        </div>

        <div class="accordion-item fade-element">
          <button class="accordion-button collapsed" type="button">
            <span>Apakah mendapat source code aplikasi?</span>
            <i class="ri-arrow-up-s-line accordion-icon text-2xl"></i>
          </button>
          <div class="accordion-body">
            <p>Tidak. Layanan BNC Radius bersifat SaaS (Software as a Service) - sewa penggunaan aplikasi cloud. Anda mendapatkan akses penuh ke fitur tanpa perlu mengelola infrastruktur atau source code.</p>
          </div>
        </div>

        <div class="accordion-item fade-element">
          <button class="accordion-button collapsed" type="button">
            <span>Bagaimana kebijakan refund?</span>
            <i class="ri-arrow-up-s-line accordion-icon text-2xl"></i>
          </button>
          <div class="accordion-body">
            <p>Semua transaksi bersifat final dan tidak dapat dikembalikan. Namun kami menyediakan trial period dan konsultasi gratis untuk memastikan paket yang Anda pilih sesuai kebutuhan.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA SECTION -->
  <section class="py-20 bg-gradient-to-r from-purple-600 via-blue-600 to-indigo-700 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>
    
    <div class="container mx-auto px-6 text-center fade-element relative z-10">
      <div class="max-w-4xl mx-auto">
        <h2 class="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight">
          Siap Transform Bisnis ISP Anda?
        </h2>
        <p class="text-xl text-white/90 max-w-2xl mx-auto mb-10 leading-relaxed">
          Bergabunglah dengan ribuan ISP yang telah merasakan kemudahan dan keandalan sistem BNC Radius
        </p>
        
        <div class="flex flex-col sm:flex-row justify-center gap-4 mb-12">
          <a href="{{ route('register') }}" class="btn-secondary bg-white text-purple-600 hover:bg-gray-100 px-8 py-4 text-lg inline-flex items-center gap-2">
            <i class="ri-user-add-line text-xl"></i>
            Daftar Sekarang
          </a>
          <a href="#footer" class="btn-secondary px-8 py-4 text-lg inline-flex items-center gap-2">
            <i class="ri-phone-line text-xl"></i>
            Konsultasi Gratis
          </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-white/80">
          <div class="flex items-center justify-center gap-3">
            <i class="ri-shield-check-line text-2xl text-green-400"></i>
            <span>Keamanan Enterprise</span>
          </div>
          <div class="flex items-center justify-center gap-3">
            <i class="ri-customer-service-line text-2xl text-blue-400"></i>
            <span>Support 24/7</span>
          </div>
          <div class="flex items-center justify-center gap-3">
            <i class="ri-rocket-line text-2xl text-yellow-400"></i>
            <span>Setup Cepat</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer id="footer" class="bg-gray-900 text-gray-300 pt-20 pb-8 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.02"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
    
    <div class="container mx-auto px-6 relative z-10">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
        
        <!-- Company Info -->
        <div class="lg:col-span-2">
          <div class="flex items-center mb-6">
            <div class="w-12 h-12 gradient-bg rounded-xl flex items-center justify-center mr-4 shadow-lg">
              <i class="ri-global-line text-xl text-white"></i>
            </div>
            <div>
              <h2 class="text-xl font-bold text-white">BORNEO</h2>
              <p class="text-sm text-gray-400 -mt-1">Network Center</p>
            </div>
          </div>
          
          <p class="text-gray-400 leading-relaxed mb-6 max-w-md">
            PT Borneo Network Center adalah perusahaan teknologi yang berfokus pada solusi manajemen jaringan ISP dengan teknologi cloud terdepan.
          </p>
          
          <div class="text-sm text-gray-400 space-y-2 mb-6">
            <div class="flex items-center">
              <i class="ri-map-pin-line mr-3 text-purple-400"></i>
              <span>Jl. Palm Raya, Ruko No. 6, RT 50 RW 07</span>
            </div>
            <div class="flex items-center">
              <i class="ri-building-line mr-3 text-purple-400"></i>
              <span>Kel. Guntung Manggis, Landasan Ulin</span>
            </div>
            <div class="flex items-center">
              <i class="ri-home-line mr-3 text-purple-400"></i>
              <span>Banjarbaru, Kalimantan Selatan, Indonesia</span>
            </div>
          </div>
          
          <div class="flex space-x-4">
            <a href="#" class="w-12 h-12 bg-gray-800 rounded-xl flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all duration-300 group">
              <i class="ri-phone-fill text-lg group-hover:scale-110 transition-transform"></i>
            </a>
            <a href="#" class="w-12 h-12 bg-gray-800 rounded-xl flex items-center justify-center hover:bg-red-500 hover:text-white transition-all duration-300 group">
              <i class="ri-mail-fill text-lg group-hover:scale-110 transition-transform"></i>
            </a>
            <a href="https://wa.me/6281528297789" class="w-12 h-12 bg-gray-800 rounded-xl flex items-center justify-center hover:bg-green-500 hover:text-white transition-all duration-300 group">
              <i class="ri-whatsapp-line text-lg group-hover:scale-110 transition-transform"></i>
            </a>
          </div>
        </div>

        <!-- Quick Links -->
        <div>
          <h3 class="text-lg font-semibold text-white mb-6 flex items-center">
            <i class="ri-links-line mr-2 text-purple-400"></i>
            Quick Links
          </h3>
          <ul class="space-y-4">
            <li><a href="#tentang" class="text-gray-400 hover:text-white hover:translate-x-2 transition-all duration-300 inline-block">Tentang Kami</a></li>
            <li><a href="#fitur" class="text-gray-400 hover:text-white hover:translate-x-2 transition-all duration-300 inline-block">Fitur Lengkap</a></li>
            <li><a href="#harga" class="text-gray-400 hover:text-white hover:translate-x-2 transition-all duration-300 inline-block">Paket & Harga</a></li>
            <li><a href="#faq" class="text-gray-400 hover:text-white hover:translate-x-2 transition-all duration-300 inline-block">FAQ</a></li>
          </ul>
        </div>

        <!-- Social Media & Support -->
        <div>
          <h3 class="text-lg font-semibold text-white mb-6 flex items-center">
            <i class="ri-customer-service-line mr-2 text-purple-400"></i>
            Hubungi Kami
          </h3>
          
          <div class="space-y-4 mb-6">
            <div class="flex items-center text-gray-400">
              <i class="ri-time-line mr-3 text-purple-400"></i>
              <div>
                <p class="text-sm font-medium text-white">24/7 Support</p>
                <p class="text-xs">Senin - Minggu</p>
              </div>
            </div>
            <div class="flex items-center text-gray-400">
              <i class="ri-chat-3-line mr-3 text-purple-400"></i>
              <div>
                <p class="text-sm font-medium text-white">Live Chat</p>
                <p class="text-xs">Response < 5 menit</p>
              </div>
            </div>
          </div>
          
          <div class="space-y-3">
            <p class="text-sm font-medium text-white mb-3">Follow Us</p>
            <div class="flex space-x-3">
              <a href="#" class="w-10 h-10 bg-gray-800 rounded-xl flex items-center justify-center hover:bg-blue-500 hover:text-white transition-all duration-300 hover:scale-110">
                <i class="ri-twitter-fill"></i>
              </a>
              <a href="https://www.facebook.com/groups/rlradius" target="_blank" class="w-10 h-10 bg-gray-800 rounded-xl flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all duration-300 hover:scale-110">
                <i class="ri-facebook-fill"></i>
              </a>
              <a href="#" class="w-10 h-10 bg-gray-800 rounded-xl flex items-center justify-center hover:bg-pink-500 hover:text-white transition-all duration-300 hover:scale-110">
                <i class="ri-instagram-line"></i>
              </a>
              <a href="https://www.youtube.com/watch?v=jnuILVPfKPg&list=PLVA91M9nFgixqwiNllm6CT9IPb8iFyFFl" target="_blank" class="w-10 h-10 bg-gray-800 rounded-xl flex items-center justify-center hover:bg-red-600 hover:text-white transition-all duration-300 hover:scale-110">
                <i class="ri-youtube-fill"></i>
              </a>
            </div>
          </div>
        </div>

      </div>

      <!-- Footer Bottom -->
      <div class="border-t border-gray-800 pt-8">
        <div class="flex flex-col md:flex-row justify-between items-center">
          <div class="text-center md:text-left mb-4 md:mb-0">
            <p class="text-gray-400">
              &copy; 2025 <strong class="text-white font-semibold">PT BORNEO NETWORK CENTER</strong>. All Rights Reserved.
            </p>
            <p class="text-xs text-gray-500 mt-1">
              {{-- Built with ❤ for Indonesian ISP Community --}}Dibuat Oleh Bepan Ganteng
            </p>
          </div>
          <div class="flex space-x-6 text-sm">
            <button onclick="openModal('terms')" class="text-gray-400 hover:text-white transition-colors">Terms of Service</button>
            <button onclick="openModal('privacy')" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</button>
            <button onclick="openModal('cookies')" class="text-gray-400 hover:text-white transition-colors">Cookie Policy</button>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- MODAL -->
  <div id="modalOverlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden justify-center items-center p-6">
    <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl relative transform scale-95 transition-all duration-300" onclick="event.stopPropagation()">
      
      <!-- Modal Header -->
      <div class="flex items-center justify-between p-6 border-b border-gray-100">
        <h3 class="text-lg font-semibold text-gray-800" id="modalTitle">Modal Title</h3>
        <button onclick="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors">
          <i class="ri-close-line text-xl text-gray-500"></i>
        </button>
      </div>

      <!-- Modal Content -->
      <div id="modalContent" class="p-6 text-gray-600 space-y-4 text-sm leading-relaxed max-h-96 overflow-y-auto">
        <!-- Content will be injected here -->
      </div>

      <!-- Modal Footer -->
      <div class="flex justify-end gap-3 p-6 border-t border-gray-100">
        <button onclick="closeModal()" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
          Tutup
        </button>
      </div>
    </div>
  </div>

  <!-- Back to Top Button -->
  <a href="#beranda" id="backToTop" 
    class="fixed bottom-8 right-8 w-14 h-14 gradient-bg text-white rounded-full flex items-center justify-center shadow-xl opacity-0 invisible transition-all duration-300 hover:shadow-2xl hover:scale-110 group z-50">
    <i class="ri-arrow-up-line text-xl group-hover:-translate-y-1 transition-transform"></i>
  </a>

  <!-- JAVASCRIPT -->
  <script>
    // Enhanced Header Scroll Effect
    let lastScrollTop = 0;
    const header = document.getElementById('mainHeader');
    
    window.addEventListener("scroll", () => {
      const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
      
      // Header visibility
      if (scrollTop > lastScrollTop && scrollTop > 100) {
        header.style.transform = "translateY(-100%)";
      } else {
        header.style.transform = "translateY(0)";
      }
      lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
      
      // Back to top button
      const backToTop = document.getElementById('backToTop');
      if (scrollTop > 500) {
        backToTop.classList.remove('opacity-0', 'invisible');
        backToTop.classList.add('opacity-100', 'visible');
      } else {
        backToTop.classList.remove('opacity-100', 'visible');
        backToTop.classList.add('opacity-0', 'invisible');
      }
      
      // Header background opacity
      if (scrollTop > 50) {
        header.classList.add('bg-white/95');
        header.classList.remove('bg-white/80');
      } else {
        header.classList.add('bg-white/80');
        header.classList.remove('bg-white/95');
      }
    });

    // Enhanced Burger Menu
    const burgerBtn = document.getElementById('burgerBtn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    let isMenuOpen = false;

    function toggleMenu() {
      isMenuOpen = !isMenuOpen;
      
      if (isMenuOpen) {
        sidebar.classList.remove('translate-x-full');
        overlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        burgerBtn.innerHTML = '<i class="ri-close-line"></i>';
      } else {
        sidebar.classList.add('translate-x-full');
        overlay.classList.add('hidden');
        document.body.style.overflow = '';
        burgerBtn.innerHTML = '<i class="ri-menu-line"></i>';
      }
    }

    burgerBtn.addEventListener('click', toggleMenu);
    overlay.addEventListener('click', toggleMenu);

    // Close sidebar when clicking on links
    const sidebarLinks = document.querySelectorAll('#sidebar a');
    sidebarLinks.forEach(link => {
      link.addEventListener('click', () => {
        if (isMenuOpen) toggleMenu();
      });
    });

    // Enhanced Fade-in Animation
    const fadeElements = document.querySelectorAll('.fade-element');
    
    const fadeInOnScroll = () => {
      fadeElements.forEach((element, index) => {
        const elementTop = element.getBoundingClientRect().top;
        const windowHeight = window.innerHeight;
        
        if (elementTop < windowHeight - 50) {
          setTimeout(() => {
            element.classList.add('visible');
          }, index * 100); // Staggered animation
        }
      });
    };
    
    // Intersection Observer for better performance
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    });

    fadeElements.forEach(element => {
      observer.observe(element);
    });

    // Smooth Scrolling Enhancement
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;
        
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
          const headerHeight = document.getElementById('mainHeader').offsetHeight;
          const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight - 20;
          
          window.scrollTo({
            top: targetPosition,
            behavior: 'smooth'
          });
        }
      });
    });

    // Enhanced FAQ Accordion
    const accordionButtons = document.querySelectorAll('.accordion-button');
    
    accordionButtons.forEach(button => {
      button.addEventListener('click', () => {
        const accordionBody = button.nextElementSibling;
        const isCollapsed = button.classList.contains('collapsed');
        
        // Close all other accordions
        accordionButtons.forEach(otherButton => {
          if (otherButton !== button) {
            otherButton.classList.add('collapsed');
            otherButton.nextElementSibling.classList.remove('show');
            otherButton.nextElementSibling.style.maxHeight = '0';
          }
        });
        
        // Toggle current accordion
        if (isCollapsed) {
          button.classList.remove('collapsed');
          accordionBody.classList.add('show');
          accordionBody.style.maxHeight = accordionBody.scrollHeight + 'px';
        } else {
          button.classList.add('collapsed');
          accordionBody.classList.remove('show');
          accordionBody.style.maxHeight = '0';
        }
      });
    });

    // Enhanced Modal System
    const modalOverlay = document.getElementById('modalOverlay');
    const modalContent = document.getElementById('modalContent');
    const modalTitle = document.getElementById('modalTitle');

    const modalData = {
      terms: {
        title: 'Syarat & Ketentuan Layanan',
        content: `
          <div class="space-y-4">
            <div>
              <h4 class="font-semibold text-gray-800 mb-2">1. Penerimaan Syarat</h4>
              <p>Dengan menggunakan layanan BNC Radius, Anda setuju untuk mematuhi dan terikat oleh syarat dan ketentuan yang berlaku.</p>
            </div>
            <div>
              <h4 class="font-semibold text-gray-800 mb-2">2. Penggunaan Layanan</h4>
              <p>Layanan ini disediakan untuk keperluan bisnis ISP yang legitimate. Penggunaan untuk aktivitas ilegal dilarang keras.</p>
            </div>
            <div>
              <h4 class="font-semibold text-gray-800 mb-2">3. Pembayaran</h4>
              <p>Semua pembayaran bersifat final dan tidak dapat dikembalikan. Keterlambatan pembayaran dapat mengakibatkan penangguhan layanan.</p>
            </div>
            <div>
              <h4 class="font-semibold text-gray-800 mb-2">4. Batasan Tanggung Jawab</h4>
              <p>PT Borneo Network Center tidak bertanggung jawab atas kerugian yang timbul akibat penggunaan layanan di luar batas wajar.</p>
            </div>
          </div>
        `
      },
      privacy: {
        title: 'Kebijakan Privasi',
        content: `
          <div class="space-y-4">
            <div>
              <h4 class="font-semibold text-gray-800 mb-2">Pengumpulan Data</h4>
              <p>Kami mengumpulkan data yang diperlukan untuk menyediakan layanan, termasuk informasi akun, data penggunaan, dan log sistem.</p>
            </div>
            <div>
              <h4 class="font-semibold text-gray-800 mb-2">Penggunaan Data</h4>
              <p>Data digunakan untuk operasional layanan, peningkatan kualitas, dan komunikasi terkait akun Anda.</p>
            </div>
            <div>
              <h4 class="font-semibold text-gray-800 mb-2">Keamanan Data</h4>
              <p>Kami menerapkan standar keamanan enterprise untuk melindungi data Anda dengan enkripsi dan sistem backup yang redundan.</p>
            </div>
            <div>
              <h4 class="font-semibold text-gray-800 mb-2">Hak Anda</h4>
              <p>Anda memiliki hak untuk mengakses, memperbarui, atau menghapus data pribadi sesuai dengan regulasi yang berlaku.</p>
            </div>
          </div>
        `
      },
      cookies: {
        title: 'Kebijakan Cookie',
        content: `
          <div class="space-y-4">
            <div>
              <h4 class="font-semibold text-gray-800 mb-2">Apa itu Cookie?</h4>
              <p>Cookie adalah file kecil yang disimpan di perangkat Anda untuk meningkatkan pengalaman browsing dan fungsionalitas website.</p>
            </div>
            <div>
              <h4 class="font-semibold text-gray-800 mb-2">Jenis Cookie yang Kami Gunakan</h4>
              <ul class="list-disc list-inside space-y-1 text-gray-600">
                <li>Cookie fungsional untuk menyimpan preferensi</li>
                <li>Cookie analitik untuk memahami penggunaan website</li>
                <li>Cookie keamanan untuk proteksi akun</li>
              </ul>
            </div>
            <div>
              <h4 class="font-semibold text-gray-800 mb-2">Mengelola Cookie</h4>
              <p>Anda dapat mengatur preferensi cookie melalui pengaturan browser. Menonaktifkan cookie mungkin mempengaruhi fungsionalitas website.</p>
            </div>
          </div>
        `
      }
    };

    function openModal(type) {
      const data = modalData[type];
      if (data) {
        modalTitle.textContent = data.title;
        modalContent.innerHTML = data.content;
        modalOverlay.classList.remove('hidden');
        modalOverlay.classList.add('flex');
        document.body.style.overflow = 'hidden';
        
        // Animation
        setTimeout(() => {
          modalOverlay.querySelector('.bg-white').style.transform = 'scale(1)';
        }, 10);
      }
    }

    function closeModal() {
      modalOverlay.querySelector('.bg-white').style.transform = 'scale(0.95)';
      setTimeout(() => {
        modalOverlay.classList.add('hidden');
        modalOverlay.classList.remove('flex');
        document.body.style.overflow = '';
      }, 200);
    }

    // Close modal on outside click
    modalOverlay.addEventListener('click', function(e) {
      if (e.target === modalOverlay) closeModal();
    });

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && !modalOverlay.classList.contains('hidden')) {
        closeModal();
      }
    });

    // Enhanced scroll animations for pricing cards
    const pricingCards = document.querySelectorAll('.pricing-card');
    
    const pricingObserver = new IntersectionObserver((entries) => {
      entries.forEach((entry, index) => {
        if (entry.isIntersecting) {
          setTimeout(() => {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
          }, index * 150);
        }
      });
    }, {
      threshold: 0.1
    });

    pricingCards.forEach(card => {
      card.style.opacity = '0';
      card.style.transform = 'translateY(30px)';
      card.style.transition = 'all 0.6s cubic-bezier(0.25, 0.8, 0.25, 1)';
      pricingObserver.observe(card);
    });

    // Add loading animation
    window.addEventListener('load', () => {
      document.body.classList.add('loaded');
      
      // Trigger initial fade-in for elements already in view
      fadeInOnScroll();
    });

    // Performance optimization: debounce scroll events
    function debounce(func, wait) {
      let timeout;
      return function executedFunction(...args) {
        const later = () => {
          clearTimeout(timeout);
          func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
      };
    }

    // Apply debounce to scroll handler
    window.addEventListener('scroll', debounce(() => {
      // Additional scroll-based animations can be added here
    }, 10));
  </script>
  
</body>
</html>