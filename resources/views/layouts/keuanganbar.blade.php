<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>BNC CLOUD MANAGER</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    .menu-item {
      transition: all 0.3s ease;
    }
    .menu-item:hover {
      transform: translateX(5px);
    }
    .shadow-blue {
      box-shadow: 0 4px 20px rgba(59, 130, 246, 0.4),
                  0 0 25px rgba(59, 130, 246, 0.4);
    }
    .active {
      background: rgba(59, 130, 246, 0.1) !important;
      color: #3F8EFC !important;
      font-weight: 600;
    }
    .fa-chevron-down {
      transition: transform 0.3s ease;
    }
    .rotate-180 {
      transform: rotate(180deg);
    }
  </style>
</head>
<body class="bg-gray-100 flex min-h-screen">

  <!-- ✅ Mobile Header -->
  <div class="flex items-center justify-between p-4 md:hidden fixed top-0 left-0 right-0 z-40 bg-white shadow">
    <!-- Burger -->
    <button id="burgerButton" class="text-[#3F8EFC] focus:outline-none">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
    </button>

    <div class="flex-1 text-right">
      <h1 class="text-base font-bold text-[#3F8EFC]">BNC CLOUD MANAGER</h1>
    </div>
  </div>

  <!-- Overlay -->
  <div id="overlay" class="fixed inset-0 bg-black bg-opacity-40 z-40 hidden md:hidden"></div>

  <!-- Sidebar -->
  <aside id="sidebar"
  class="w-64 bg-white h-screen shadow-blue rounded-2xl fixed left-0 md:left-2 top-0 md:top-3 bottom-0 md:bottom-3 z-50 flex flex-col justify-between transform -translate-x-full transition-transform duration-300 md:translate-x-0">

    <div>
      <!-- Logo -->
      <div class="p-6 border-b border-blue-500">
        <h1 class="text-xl font-bold text-[#3F8EFC] flex items-center">
          <i class="fas fa-cloud text-2xl mr-3"></i> BNC CLOUD FINANCE
        </h1>
      </div>

      <!-- Menu -->
      <nav class="p-4">
        <ul class="space-y-2">
          <!-- Dashboard -->
          <li>
            <a href="/dashboard"
              class="menu-item flex items-center space-x-3 p-3 rounded-lg text-gray-600 hover:text-[#3F8EFC]">
              <i class="fas fa-home w-5"></i><span>Dashboard</span>
            </a>
          </li>

          <!-- Voucher -->
          <li>
            <button
              class="menu-item flex items-center justify-between w-full p-3 rounded-lg text-gray-600 hover:text-[#3F8EFC]"
              onclick="toggleSubmenu('voucherMenu', this)">
              <span class="flex items-center space-x-3">
                <i class="fas fa-ticket-alt w-5"></i><span>Voucher</span>
              </span>
              <i class="fas fa-chevron-down"></i>
            </button>
            <ul id="voucherMenu" class="ml-8 mt-1 hidden space-y-1">
              <li>
                <a href="/voucher"
                   class="menu-item block p-2 rounded-lg text-gray-600 hover:text-[#3F8EFC]">
                  Profile Voucher
                </a>
              </li>
              <li>
                <a href="/stokvoucher"
                   class="menu-item block p-2 rounded-lg text-gray-600 hover:text-[#3F8EFC]">
                  Stok Voucher
                </a>
              </li>
            </ul>
          </li>

          <!-- Logout -->
          <li class="pt-4 border-t-2 border-blue-500 mt-4">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="menu-item flex items-center space-x-3 p-3 rounded-lg text-gray-600 hover:text-red-500 w-full text-left">
                <i class="fas fa-sign-out-alt w-5"></i><span>Logout</span>
              </button>
            </form>
          </li>
        </ul>
      </nav>
    </div>

    <!-- Footer Sidebar -->
    <div class="text-gray-500 text-xs px-6 py-4 border-t border-gray-200 rounded-b-2xl">
      <div class="mb-2 font-semibold text-[#3F8EFC]">PT BORNEO NETWORK CENTER</div>
      <p class="mb-1">Jl. Palm Raya, Ruko No. 6,<br>RT 50 RW 07, Guntung Manggis, Banjarbaru</p>
      <div class="flex space-x-3 mt-3">
        <a href="https://www.facebook.com/groups/rlradius" target="_blank" class="hover:text-[#3F8EFC]">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a href="#" class="hover:text-[#3F8EFC]">
          <i class="fab fa-instagram"></i>
        </a>
        <a href="https://www.youtube.com/watch?v=jnuILVPfKPg" target="_blank" class="hover:text-[#3F8EFC]">
          <i class="fab fa-youtube"></i>
        </a>
      </div>
    </div>
  </aside>

  <!-- Script Toggle -->
  <script>
  document.addEventListener('DOMContentLoaded', () => {
    const burger = document.getElementById('burgerButton');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    burger.addEventListener('click', () => {
      sidebar.classList.toggle('-translate-x-full');
      overlay.classList.toggle('hidden');
    });

    overlay.addEventListener('click', () => {
      sidebar.classList.add('-translate-x-full');
      overlay.classList.add('hidden');
    });

    // ✅ Highlight menu aktif
    const currentUrl = window.location.pathname;
    const links = document.querySelectorAll("aside nav a");

    links.forEach(link => {
      if (currentUrl === link.getAttribute("href")) {
        link.classList.add("active");
      }
    });

    // ✅ Auto buka submenu voucher jika aktif
    if (currentUrl.includes("voucher")) {
      const submenu = document.getElementById("voucherMenu");
      submenu.classList.remove("hidden");

      const btn = submenu.previousElementSibling;
      const icon = btn.querySelector("i.fas.fa-chevron-down");
      if (icon) icon.classList.add("rotate-180");

      links.forEach(link => {
        if (currentUrl === link.getAttribute("href")) {
          link.classList.add("active");
        }
      });
    }
  });

  function toggleSubmenu(id, btn) {
    const submenu = document.getElementById(id);
    submenu.classList.toggle('hidden');

    const icon = btn.querySelector('i.fas.fa-chevron-down');
    if (icon) {
      icon.classList.toggle('rotate-180');
    }
  }
  </script>

</body>
</html>
