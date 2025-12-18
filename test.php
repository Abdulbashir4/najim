<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>

<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

<style>
  :root { --header-h:56px; }
    .content-iframe { width:100%; height:calc(100vh - var(--header-h)); border:0; }

</style>
</head>

<body class="bg-gray-100">

<!-- HEADER -->
<header class="bg-blue-500 h-16 w-full sticky top-0 z-50 shadow-md">

  <div class="h-full px-6 flex items-center justify-between">

    <!-- Left: Logo -->
    <div class="flex items-center gap-3">
      <img
        src="image/logo.jpg"
        alt="Logo"
        class="h-12 w-12 rounded-full object-cover border-2 border-white"
      >
      <span class="text-black text-xl font-bold hidden sm:block">
        Dashboard
      </span>
    </div>

    <!-- Right: Mobile Menu Icon -->
    <button
      onclick="toggleSidebar()"
      class="sm:hidden text-white text-2xl"
    >
      ☰
    </button>

  </div>
</header>

<div class="min-h-screen flex">

  <!-- SIDEBAR -->
  <aside
  id="sidebar"
  class="bg-blue-300 w-64
         min-h-[calc(100vh-4rem)]
         fixed sm:static
         top-16 right-0
         transform translate-x-full sm:translate-x-0
         transition-transform duration-300">

  <!-- <nav class="lg:hidden text-center items-center flex flex-col p-2">
    <img class="rounded-full h-10 w-10" src="image/logo.jpg" alt="">
    <h1 class="bolder">Ms Corporation</h1>
    <hr class="bg-gray-900 border border-black my-2 w-full">
  </nav> -->
    <nav class="p-4 mt-0 space-y-2">

      <a
        href="index.php"
        target="content_frame"
        onclick="handleMenuClick()"
        class="flex items-center gap-3 px-4 py-3 rounded-lg
             text-gray-900 font-semibold
               hover:bg-blue-400 transition border border-gray-600">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
</svg>Dashboard </a>


      <a
        href="customer_page.php"
        target="content_frame"
        onclick="handleMenuClick()"
        class="flex items-center gap-3 px-4 py-3 rounded-lg
               text-gray-900 font-semibold
               hover:bg-blue-400 transition border border-gray-600">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
</svg>Customers</a>


      <a
        href="customer_page.php"
        target="content_frame"
        onclick="handleMenuClick()"
        class="flex items-center gap-3 px-4 py-3 rounded-lg
               text-gray-900 font-semibold
               hover:bg-blue-400 transition border border-gray-600">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
</svg>Employee</a>


      
<div>
<button data-sub="prod" class="w-full">
  <div
    class="flex items-center gap-3 px-4 py-3 rounded-lg
           text-gray-900 font-semibold
           hover:bg-blue-400 transition border border-gray-600"
  >
    <!-- Left icon -->
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
         stroke-width="1.5" stroke="currentColor" class="size-6">
      <path stroke-linecap="round" stroke-linejoin="round"
            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
    </svg>

    <!-- Text -->
    <span>Products</span>

    <!-- Right arrow (LAST) -->
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
         stroke-width="1.5" stroke="currentColor"
         class="size-6 ml-auto">
      <path stroke-linecap="round" stroke-linejoin="round"
            d="m19.5 8.25-7.5 7.5-7.5-7.5" />
    </svg>
  </div>
</button>

<div
  id="prod"
  class="submenu ml-12 pl-4 mt-1 space-y-1
         border-l-2 border-blue-400
         hidden"
>
  <a
    href="customer_page.php"
    target="content_frame"
    onclick="handleMenuClick()"
    class="block px-4 py-2 rounded-md
           text-sm font-medium text-gray-700
           bg-gray-200
           hover:bg-blue-500 hover:text-white
           hover:translate-x-1
           transition-all duration-200"
  >
    ▸ Product List
  </a>

  <a
    href="add_product.php"
    target="content_frame"
    onclick="handleMenuClick()"
    class="block px-4 py-2 rounded-md
           text-sm font-medium text-gray-700
           bg-gray-200
           hover:bg-blue-500 hover:text-white
           hover:translate-x-1
           transition-all duration-200"
  >
    ▸ Add Product
  </a>

  <a
    href="add_catagory_sub&brand.php"
    target="content_frame"
    onclick="handleMenuClick()"
    class="block px-4 py-2 rounded-md
           text-sm font-medium text-gray-700
           bg-gray-200
           hover:bg-blue-500 hover:text-white
           hover:translate-x-1
           transition-all duration-200"
  >
    ▸ Add Brand
  </a>
</div>


</div>

      <a
        href="customer_page.php"
        target="content_frame"
        onclick="handleMenuClick()"
        class="flex items-center gap-3 px-4 py-3 rounded-lg
               text-gray-900 font-semibold
               hover:bg-blue-400 transition border border-gray-600">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z" />
</svg>
Billing & Invoice</a>



      <a
        href="customer_page.php"
        target="content_frame"
        onclick="handleMenuClick()"
        class="flex items-center gap-3 px-4 py-3 rounded-lg
               text-gray-900 font-semibold
               hover:bg-blue-400 transition border border-gray-600">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
</svg>

Payment & Account</a>

<div>
<button data-sub="setting" class="w-full">
  <div
    class="flex items-center gap-3 px-4 py-3 rounded-lg
           text-gray-900 font-semibold
           hover:bg-blue-400 transition border border-gray-600"
  >
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
      <path stroke-linecap="round" stroke-linejoin="round"
            d="m19.5 8.25-7.5 7.5-7.5-7.5" />
    </svg>
  </div>
</button>

<div
  id="setting"
  class="submenu ml-12 pl-4 mt-1 space-y-1
         border-l-2 border-blue-400
         hidden"
>
  <a
    href="customer_page.php"
    target="content_frame"
    onclick="handleMenuClick()"
    class="block px-4 py-2 rounded-md
           text-sm font-medium text-gray-700
           bg-gray-200
           hover:bg-blue-500 hover:text-white
           hover:translate-x-1
           transition-all duration-200"
  >
    ▸ Product List
  </a>

  <a
    href="add_product.php"
    target="content_frame"
    onclick="handleMenuClick()"
    class="block px-4 py-2 rounded-md
           text-sm font-medium text-gray-700
           bg-gray-200
           hover:bg-blue-500 hover:text-white
           hover:translate-x-1
           transition-all duration-200"
  >
    ▸ Add Product
  </a>

  <a
    href="add_catagory_sub&brand.php"
    target="content_frame"
    onclick="handleMenuClick()"
    class="block px-4 py-2 rounded-md
           text-sm font-medium text-gray-700
           bg-gray-200
           hover:bg-blue-500 hover:text-white
           hover:translate-x-1
           transition-all duration-200"
  >
    ▸ Add Brand
  </a>
</div>



    </nav>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="flex-1 sm:ml-64 bg-blue-300 min-h-[calc(100vh-4rem)] flex">

    <iframe
  name="content_frame"
  class="content-iframe bg-gray-100 flex-1"
>
</iframe>
  </main>

</div>

<!-- FOOTER -->
<footer class="text-center py-3 text-sm text-gray-500 border-t bg-white">
  © 2025 Your Company
</footer>

<!-- JS -->
<script>
function toggleSidebar() {
  document.getElementById('sidebar')
    .classList.toggle('translate-x-full');
}

function handleMenuClick() {
  // mobile only sidebar hide
  if (window.innerWidth < 640) {
    document.getElementById('sidebar')
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