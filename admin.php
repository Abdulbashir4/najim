<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="refresh" content="4000">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Demo</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

  <style>
    html, body {
      height: 100%;
      margin: 0;
    }
    .layout-wrapper {
      height: 100vh;
      display: flex;
      flex-direction: column;
    }
    .content-section {
      flex: 1;
      display: flex;
      overflow: hidden;
    }
    .content-iframe {
      width: 100%;
      height: 100%;
      border: 0;
    }
  </style>
</head>

<body class="bg-gray-100">

<div class="layout-wrapper">

  <!-- HEADER -->
  <header class="bg-blue-500 lg:h-16 h-14 w-full shadow-md">
    <div class="max-w-full h-full px-4 sm:px-6 flex items-center justify-between">

      <!-- Left: Logo + Title -->
      <div class="flex items-center gap-3 min-w-0">
        <img
          src="image/logo.jpg"
          alt="Logo"
          class="h-10 w-10 sm:h-12 sm:w-12
                 rounded-full object-cover border-2 border-white"
        >
        <span class="text-black text-lg sm:text-xl font-bold
                     hidden xs:block truncate">
          Dashboard
        </span>
      </div>

      <!-- Right: Mobile Menu -->
      <button
        onclick="toggleSidebar()"
        class="sm:hidden text-white text-2xl
               focus:outline-none focus:ring-2
               focus:ring-white rounded"
        aria-label="Toggle Menu"
      >
        ☰
      </button>

    </div>
  </header>

  <!-- CONTENT -->
  <div class="content-section">

    <!-- SIDEBAR -->
    <aside id="sidebar" class="fixed sm:static
             top-14 right-0
             translate-x-full sm:translate-x-0
             transition-transform duration-300
             w-64 h-full
             overflow-auto
             bg-gray-200 text-gray-900
             font-semibold text-lg
             flex z-40">

      <ul class="space-y-3 p-4">



        <li class="w-full">
          <a href="default_dashbord.php" target="content_frame"
            class="flex gap-3 border border-black px-4 py-1 rounded hover:bg-blue-200 hover:text-black">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
            d="M12 6.042A8.967 8.967 0 0 0 6 3.75
            c-1.052 0-2.062.18-3 .512v14.25
            A8.987 8.987 0 0 1 6 18
            c2.305 0 4.408.867 6 2.292
            m0-14.25a8.966 8.966 0 0 1 6-2.292
            c1.052 0 2.062.18 3 .512v14.25
            A8.987 8.987 0 0 0 18 18
            a8.967 8.967 0 0 0-6 2.292
            m0-14.25v14.25" />
            </svg>
            Dashboard
          </a>
        </li>
        <li>
    <button data-sub="customer" class="w-full">
        <div class="flex items-center gap-3 px-4 py-1 rounded text-gray-900 font-semibold hover:bg-blue-200 transition border border-gray-600">
                <!-- Left icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                 <span>Customers</span>
                <!-- Right arrow (LAST) -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor"
                    class="size-6 ml-auto">
                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>
                <div id="customer" class="submenu  mt-1 space-y-1 border-l-2 border-blue-400 hidden">
                <a href="desbord.php" target="content_frame" onclick="handleMenuClick()"
                    class="flex justify-normal px-4 py-2 rounded-md text-sm font-medium text-gray-700 bg-gray-200 hover:bg-blue-500 hover:text-white hover:translate-x-1 transition-all duration-200">
                    Coustomer List
                </a>
                

        </div>
    </button>
</li>
<li>
    <button data-sub="employee" class="w-full">
        <div class="flex items-center gap-3 px-4 py-1 rounded text-gray-900 font-semibold hover:bg-blue-200 transition border border-gray-600">
                <!-- Left icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>

                 <span>Employees</span>
                <!-- Right arrow (LAST) -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor"
                    class="size-6 ml-auto">
                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>
                <div id="employee" class="submenu mt-1 space-y-1 border-l-2 border-blue-400 hidden">
                <a href="view_employee.php" target="content_frame" onclick="handleMenuClick()"
                    class="flex justify-normal px-4 py-2 rounded-md text-sm font-medium text-gray-700 bg-gray-200 hover:bg-blue-500 hover:text-white hover:translate-x-1 transition-all duration-200">
                    Employee List
                </a>
              

        </div>
    </button>
</li>
<li>
    <button data-sub="account&payment" class="w-full">
        <div class="flex items-center gap-3 px-4 py-1 rounded text-gray-900 font-semibold hover:bg-blue-200 transition border border-gray-600">
                <!-- Left icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                </svg>


                 <span>Account</span>
                <!-- Right arrow (LAST) -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor"
                    class="size-6 ml-auto">
                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>
                <div id="account&payment" class="submenu mt-1 space-y-1 border-l-2 border-blue-400 hidden">
                <a href="account_module.php" target="content_frame" onclick="handleMenuClick()"
                    class="flex justify-normal px-4 py-2 rounded-md text-sm font-medium text-gray-700 bg-gray-200 hover:bg-blue-500 hover:text-white hover:translate-x-1 transition-all duration-200">
                    Account Module
                </a>
                <a href="sell_record.php" target="content_frame" onclick="handleMenuClick()"
                    class="flex justify-normal px-4 py-2 rounded-md text-sm font-medium text-gray-700 bg-gray-200 hover:bg-blue-500 hover:text-white hover:translate-x-1 transition-all duration-200">
                    Sell Record
                </a>
                <a href="account_module.php" target="content_frame" onclick="handleMenuClick()"
                    class="flex justify-normal px-4 py-2 rounded-md text-sm font-medium text-gray-700 bg-gray-200 hover:bg-blue-500 hover:text-white hover:translate-x-1 transition-all duration-200">
                    Payment Statement
                </a>
                

        </div>
    </button>
</li>
<li>
    <button data-sub="product" class="w-full">
        <div class="flex items-center gap-3 px-4 py-1 rounded text-gray-900 font-semibold hover:bg-blue-200 transition border border-gray-600">
                <!-- Left icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>


                 <span>Products</span>
                <!-- Right arrow (LAST) -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor"
                    class="size-6 ml-auto">
                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>
                <div id="product" class="submenu  mt-1 space-y-1 border-l-2 border-blue-400 hidden">
                <a href="product_sale.php" target="content_frame" onclick="handleMenuClick()"
                    class="flex justify-normal px-4 py-2 rounded-md text-sm font-medium text-gray-700 bg-gray-200 hover:bg-blue-500 hover:text-white hover:translate-x-1 transition-all duration-200">
                    Product Sale
                </a>
                <a href="product_bye.php" target="content_frame" onclick="handleMenuClick()"
                    class="flex justify-normal px-4 py-2 rounded-md text-sm font-medium text-gray-700 bg-gray-200 hover:bg-blue-500 hover:text-white hover:translate-x-1 transition-all duration-200">
                    Product bye
                </a>
                <a href="view_shop.php" target="content_frame" onclick="handleMenuClick()"
                    class="flex justify-normal px-4 py-2 rounded-md text-sm font-medium text-gray-700 bg-gray-200 hover:bg-blue-500 hover:text-white hover:translate-x-1 transition-all duration-200">
                    Store Manager
                </a>
                <a href="add_payment.php" target="content_frame" onclick="handleMenuClick()"
                    class="flex justify-normal px-4 py-2 rounded-md text-sm font-medium text-gray-700 bg-gray-200 hover:bg-blue-500 hover:text-white hover:translate-x-1 transition-all duration-200">
                    Payment
                </a>

        </div>
    </button>
</li>

<li>
    <button data-sub="setting" class="w-full">
        <div class="flex items-center gap-3 px-4 py-1 rounded text-gray-900 font-semibold hover:bg-blue-200 transition border border-gray-600">
                <!-- Left icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>


                <!-- Text -->
                 <span>Setting</span>

                <!-- Right arrow (LAST) -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor"
                    class="size-6 ml-auto">
                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>
                <div id="setting" class="submenu mt-1 space-y-1 border-l-2 border-blue-400 hidden">
                <a href="add_product.php" target="content_frame" onclick="handleMenuClick()"
                    class="flex justify-normal px-4 py-2 rounded-md text-sm font-medium text-gray-700 bg-gray-200 hover:bg-blue-500 hover:text-white hover:translate-x-1 transition-all duration-200">
                    Product In List
                </a>

                <a href="add_brance.php" target="content_frame" onclick="handleMenuClick()"
                    class="flex justify-normal px-4 py-2 rounded-md text-sm font-medium text-gray-700 bg-gray-200 hover:bg-blue-500 hover:text-white hover:translate-x-1 transition-all duration-200">
                    Branch In Listed
                </a>

                <a href="add_customer.php" target="content_frame" onclick="handleMenuClick()"
                    class="flex justify-normal px-4 py-2 rounded-md text-sm font-medium text-gray-700 bg-gray-200 hover:bg-blue-500 hover:text-white hover:translate-x-1 transition-all duration-200">
                    Customer In Listed
                </a>
                <a href="add_employee.php" target="content_frame" onclick="handleMenuClick()"
                    class="flex justify-normal px-4 py-2 rounded-md text-sm font-medium text-gray-700 bg-gray-200 hover:bg-blue-500 hover:text-white hover:translate-x-1 transition-all duration-200">
                    Employee In Listed
                </a>
                <a href="add_shop.php" target="content_frame" onclick="handleMenuClick()"
                    class="flex justify-normal px-4 py-2 rounded-md text-sm font-medium text-gray-700 bg-gray-200 hover:bg-blue-500 hover:text-white hover:translate-x-1 transition-all duration-200">
                    Supplyer In Listed
                </a>
        </div>
    </button>
</li>



</ul>
</aside>

    <!-- MAIN -->
    <main class="flex-1 bg-blue-300">
      <iframe
        name="content_frame"
        src="account_module.php"
        class="content-iframe bg-gray-100">
      </iframe>
    </main>
    <!-- <main class="flex-1 bg-blue-300">
      <iframe
        name="content_frame"
        src="default_dashbord.php"
        class="content-iframe bg-gray-100">
      </iframe>
    </main> -->

  </div>
</div>

<script>
function toggleSidebar() {
  document
    .getElementById('sidebar')
    .classList.toggle('translate-x-full');
}

function handleMenuClick() {
  if (window.innerWidth < 640) {
    document
      .getElementById('sidebar')
      .classList.add('translate-x-full');
  }
}

document.querySelectorAll('[data-sub]').forEach(btn=>{
    btn.addEventListener('click', ()=>{
      const id = btn.dataset.sub;
      const el = document.getElementById(id);
      if(!el) return;
      const hidden = el.classList.toggle('hidden');
      btn.setAttribute('aria-expanded', String(!hidden));
      el.setAttribute('aria-hidden', String(hidden));
    });
  });
</script>

</body>
</html>
