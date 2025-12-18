<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Admin</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <style>
    :root { --header-h:56px; }
    .content-iframe { width:100%; height:calc(100vh - var(--header-h)); border:0; }
    /* mobile panel hidden to right, animate to 0 */
    .panel { transform: translateX(100%); transition: transform .25s ease; }
    .panel.open { transform: translateX(0); }
    .backdrop-visible { opacity:.35; pointer-events:auto; }
    /* mini mode */
    .mini .label { display:none; }
    .mini .submenu { display:none!important; }
  </style>
</head>
<body class="bg-gray-100 font-sans">

<header id="hdr" class="sticky top-0 z-20 bg-white border-b">
  <div class="px-4 py-3 flex items-center justify-between">

    <!-- LEFT (Desktop only) -->
    <div class="hidden sm:flex items-center gap-3">
      <h1 class="text-xl font-semibold">Dashboard</h1>

      <div class="relative">
        <input id="globalSearch" 
               class="border rounded px-3 py-2 w-64 lg:w-80"
               placeholder="Search orders, products..." />
        <button onclick="document.getElementById('globalSearch').value='';" 
                class="absolute right-2 top-2 text-sm text-gray-500">✖</button>
      </div>
    </div>

    <!-- RIGHT (Mobile & Desktop) -->
    <div class="flex items-center justify-between w-full sm:w-auto">

      <!-- LEFT SIDE (Admin info) -->
      <div class="flex items-center gap-2">
        <img src="https://i.pravatar.cc/40?img=12" class="w-9 h-9 rounded-full border" alt="Admin avatar"/>
        <div class="text-sm">
          <div class="font-medium">Admin</div>
          <div class="text-xs text-gray-500">Super Admin</div>
        </div>
      </div>

      <!-- RIGHT SIDE (Mobile menu button) -->
      <button id="openMobile" class="md:hidden p-2 rounded hover:bg-gray-100 text-2xl ml-auto" aria-label="Open menu">
        ☰
      </button>

    </div>

  </div>
</header>

<div>
  <div class="min-h-screen flex">

    <!-- desktop sidebar (visible on md+) -->
    <aside id="desktopSidebar" class="hidden md:flex flex-col bg-gray-800 text-white w-64 p-2">

      <nav id="nav" class="p-2 flex-1 overflow-auto space-y-1" role="navigation">
        <a class="nav-item flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-700" href="admin_dashbord.php" target="content_frame">
          <svg class="w-5 h-5 text-indigo-300" viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h8V3H3v10zM3 21h8v-6H3v6zM13 21h8V11h-8v10zM13 3v6h8V3h-8z"/></svg>
          <span class="label">Dashboard</span>
        </a>

        <div>
          <button data-sub="prod" class="w-full flex items-center justify-between px-3 py-2 rounded hover:bg-gray-700" aria-expanded="false" aria-controls="prod">
            <span class="flex items-center gap-3">
              <svg class="w-5 h-5 text-indigo-300" viewBox="0 0 24 24" fill="currentColor"><path d="M3 7h18v2H3V7zm0 4h18v2H3v-2zm0 4h18v2H3v-2z"/></svg>
              <span class="label font-medium">Products</span>
            </span>
            <svg class="w-4 h-4 text-gray-300" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>

          <div id="prod" class="pl-12 space-y-1 submenu hidden">
            <a class="block px-3 py-2 rounded hover:bg-gray-700" href="add_product.php" target="content_frame">Add Product</a>
            <a class="block px-3 py-2 rounded hover:bg-gray-700" href="product_list_view.php" target="content_frame">Product List</a>
            <a class="block px-3 py-2 rounded hover:bg-gray-700" href="add_catagory_sub&brand.php" target="content_frame">Add Brand</a>
          </div>
        </div>
        <!-- For orders  -->
        <div>
          <button data-sub="order" class="w-full flex items-center justify-between px-3 py-2 rounded hover:bg-gray-700" aria-expanded="false" aria-controls="order">
            <span class="flex items-center gap-3">
              <svg class="w-5 h-5 text-indigo-300" viewBox="0 0 24 24" fill="currentColor"><path d="M3 7h18v2H3V7zm0 4h18v2H3v-2zm0 4h18v2H3v-2z"/></svg>
              <span class="label font-medium">Orders</span>
            </span>
            <svg class="w-4 h-4 text-gray-300" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>

          <div id="order" class="pl-12 space-y-1 submenu hidden">
            <a class="block px-3 py-2 rounded hover:bg-gray-700" href="admin_orders.php" target="content_frame">Order Running</a>
            <a class="block px-3 py-2 rounded hover:bg-gray-700" href="complete_order.php" target="content_frame">Order Complete</a>
            <a class="block px-3 py-2 rounded hover:bg-gray-700" href="add_catagory_sub&brand.php" target="content_frame">Add Brand</a>
          </div>
        </div>

        <a class="nav-item flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-700" href="order_tracking.php" target="content_frame">
          <svg class="w-5 h-5 text-indigo-300" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l1.5 4.5L18 8l-4 2.5L12 15l-2-4.5L6 8l4.5-1.5L12 2z"/></svg>
          <span class="label">Order Tracking</span>
        </a>
        <a class="nav-item flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-700" href="company_info.php" target="content_frame">
          <svg class="w-5 h-5 text-indigo-300" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l1.5 4.5L18 8l-4 2.5L12 15l-2-4.5L6 8l4.5-1.5L12 2z"/></svg>
          <span class="label">Company Information</span>
        </a>
      </nav>
    </aside>

    <!-- main -->
    <main class="flex-1">
      <iframe name="content_frame" src="admin_dashbord.php" class="content-iframe"></iframe>
    </main>
  </div>
</div>

<!-- MOBILE PANEL (shows full desktop sidebar content with icons) -->
<div id="mobileWrap" class="fixed top-18 inset-0 z-40 md:hidden hidden">
  <div id="backdrop" class="absolute inset-0 bg-black opacity-0 pointer-events-none transition-opacity"></div>

  <aside id="panel" class="panel absolute right-0 top-0 bottom-0 w-64 bg-gray-800 text-white p-3 shadow-xl overflow-y-auto">

    <!-- FULL SIDEBAR (same as desktop) -->
    <nav class="space-y-1">
     <nav id="nav" class="p-2 flex-1 overflow-auto space-y-1" role="navigation">
        <a class="nav-item flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-700" href="admin_dashbord.php" target="content_frame">
          <svg class="w-5 h-5 text-indigo-300" viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h8V3H3v10zM3 21h8v-6H3v6zM13 21h8V11h-8v10zM13 3v6h8V3h-8z"/></svg>
          <span class="label">Dashboard</span>
        </a>

        <div>
          <button data-sub="prod2" class="w-full flex items-center justify-between px-3 py-2 rounded hover:bg-gray-700" aria-expanded="false" aria-controls="prod">
            <span class="flex items-center gap-3">
              <svg class="w-5 h-5 text-indigo-300" viewBox="0 0 24 24" fill="currentColor"><path d="M3 7h18v2H3V7zm0 4h18v2H3v-2zm0 4h18v2H3v-2z"/></svg>
              <span class="label font-medium">Products</span>
            </span>
            <svg class="w-4 h-4 text-gray-300" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>

          <div id="prod2" class="pl-12 space-y-1 submenu hidden">
            <a class="block px-3 py-2 rounded hover:bg-gray-700" href="add_product.php" target="content_frame">Add Product</a>
            <a class="block px-3 py-2 rounded hover:bg-gray-700" href="product_list_view.php" target="content_frame">Product List</a>
            <a class="block px-3 py-2 rounded hover:bg-gray-700" href="add_catagory_sub&brand.php" target="content_frame">Add Brand</a>
          </div>
        </div>
        <!-- For orders  -->
        <div>
          <button data-sub="order2" class="w-full flex items-center justify-between px-3 py-2 rounded hover:bg-gray-700" aria-expanded="false" aria-controls="order">
            <span class="flex items-center gap-3">
              <svg class="w-5 h-5 text-indigo-300" viewBox="0 0 24 24" fill="currentColor"><path d="M3 7h18v2H3V7zm0 4h18v2H3v-2zm0 4h18v2H3v-2z"/></svg>
              <span class="label font-medium">Orders</span>
            </span>
            <svg class="w-4 h-4 text-gray-300" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>

          <div id="order2" class="pl-12 space-y-1 submenu hidden">
            <a class="block px-3 py-2 rounded hover:bg-gray-700" href="admin_orders.php" target="content_frame">Order Running</a>
            <a class="block px-3 py-2 rounded hover:bg-gray-700" href="complete_order.php" target="content_frame">Order Complete</a>
            <a class="block px-3 py-2 rounded hover:bg-gray-700" href="add_catagory_sub&brand.php" target="content_frame">Add Brand</a>
          </div>
        </div>

        <a class="nav-item flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-700" href="order_tracking.php" target="content_frame">
          <svg class="w-5 h-5 text-indigo-300" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l1.5 4.5L18 8l-4 2.5L12 15l-2-4.5L6 8l4.5-1.5L12 2z"/></svg>
          <span class="label">Order Tracking</span>
        </a>
        <a class="nav-item flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-700" href="company_info.php" target="content_frame">
          <svg class="w-5 h-5 text-indigo-300" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l1.5 4.5L18 8l-4 2.5L12 15l-2-4.5L6 8l4.5-1.5L12 2z"/></svg>
          <span class="label">Company Information</span>
        </a>
    </nav>
  </aside>
</div>

<script>
(function(){
  // header height var
  const setHeaderH = ()=> {
    const h = document.getElementById('hdr')?.offsetHeight || 56;
    document.documentElement.style.setProperty('--header-h', h + 'px');
  };
  setHeaderH();
  window.addEventListener('resize', setHeaderH);

  // submenu toggle (desktop & mobile)
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

  // menu search (desktop)
  const search = document.getElementById('search');
  if(search){
    search.addEventListener('input', e=>{
      const q = e.target.value.toLowerCase();
      document.querySelectorAll('#nav a, #nav button').forEach(el=>{
        const txt = (el.innerText||'').toLowerCase();
        el.style.display = (!q || txt.includes(q)) ? '' : 'none';
      });
    });
  }

  // mobile panel open/close (toggle)
  const mobileWrap = document.getElementById('mobileWrap');
  const panel = document.getElementById('panel');
  const backdrop = document.getElementById('backdrop');
  const openBtn = document.getElementById('openMobile');
  const closeBtn = document.getElementById('closeMobile');

  function showMobile(){
    if(!mobileWrap || !panel || !backdrop) return;
    mobileWrap.classList.remove('hidden');
    // backdrop visible
    backdrop.style.transition = 'opacity .2s';
    backdrop.style.opacity = '0.35';
    backdrop.style.pointerEvents = 'auto';
    // slide panel in
    requestAnimationFrame(()=> panel.classList.add('open'));
    document.body.style.overflow = 'hidden';
  }
  function hideMobile(){
    if(!mobileWrap || !panel || !backdrop) return;
    panel.classList.remove('open');
    backdrop.style.opacity = '0';
    backdrop.style.pointerEvents = 'none';
    setTimeout(()=> mobileWrap.classList.add('hidden'), 240);
    document.body.style.overflow = '';
  }

  openBtn?.addEventListener('click', ()=> panel?.classList.contains('open') ? hideMobile() : showMobile());
  closeBtn?.addEventListener('click', hideMobile);
  backdrop?.addEventListener('click', hideMobile);

  // close mobile panel when any panel link is clicked (allow submenu buttons to toggle without closing)
  document.querySelectorAll('#panel a').forEach(a=>{
    a.addEventListener('click', ()=> {
      // short delay so target navigation can process
      setTimeout(hideMobile, 80);
    });
  });

  // active link highlight (desktop)
  document.querySelectorAll('a[target="content_frame"]').forEach(a=>{
    a.addEventListener('click', ()=>{
      document.querySelectorAll('.nav-item').forEach(n=>n.classList.remove('bg-gray-700'));
      if(a.classList.contains('nav-item')) a.classList.add('bg-gray-700');
      if(window.innerWidth < 768) hideMobile();
    });
  });

})();
</script>

</body>
</html>