<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <style>
    body { font-family: Inter, system-ui, sans-serif; }
  </style>
</head>

<body class="bg-slate-100">

<div class="flex min-h-screen">

  <!-- Sidebar -->
  <aside class="w-64 bg-gray-100 text-slate-200 flex flex-col">
  <!-- Logo -->
  <div class="px-6 py-5 text-xl font-bold text-white border-b border-slate-800">
    Shop<span class="text-indigo-400">Admin</span>
  </div>

  <!-- Menu -->
  <nav class="flex-1 px-4 py-6 space-y-2 text-sm">

    <!-- Dashboard -->
    <button onclick="setActive(this); loadPage('dashbord2.php')"
      class="sidebar-btn active border py-2 block rounded text-start text-xl w-48 text-gray-700 pl-2">
      <span class="icon-box">📊</span>
      <span>Dashboard</span>
    </button>

    <!-- Products -->
    <button onclick="setActive(this); loadPage('products.php')"
      class="sidebar-btn active border py-2 block rounded  text-xl w-48 text-start text-gray-700 pl-2">
      <span class="icon-box">📦</span>
      <span>Products</span>
    </button>

    <!-- Orders -->
    <button onclick="setActive(this); loadPage('orders.php')"
      class="sidebar-btn active border py-2 block rounded  text-xl w-48 text-start text-gray-700 pl-2">
      <span class="icon-box">🧾</span>
      <span>Orders</span>
    </button>

    <!-- Tracking -->
    <button onclick="setActive(this); loadPage('tracking.php')"
      class="sidebar-btn active border py-2 block rounded  text-xl w-48 text-start text-gray-700 pl-2">
      <span class="icon-box">🚚</span>
      <span>Order Tracking</span>
    </button>

    <!-- Company -->
    <button onclick="setActive(this); loadPage('company.php')"
      class="sidebar-btn active border py-2 block rounded  text-xl w-48 text-start text-gray-700 pl-2">
      <span class="icon-box">⚙️</span>
      <span>Company Info</span>
    </button>

  </nav>

  <div class="p-4 border-t border-slate-800 text-xs text-slate-400">
    © 2025 ShopAdmin
  </div>
</aside>


  <!-- Main Content -->
  <div class="flex-1 flex flex-col">

    <!-- Header -->
    <header class="bg-white shadow-sm px-6 py-4 flex items-center justify-between">
      <input type="text"
        placeholder="Search orders, products..."
        class="w-1/2 px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500">

      <div class="flex items-center gap-6">
        🔔
        <div class="flex items-center gap-3">
          <img src="https://i.pravatar.cc/40" class="rounded-full border">
          <div class="text-sm">
            <p class="font-semibold text-slate-700">Admin</p>
            <p class="text-slate-400 text-xs">Super Admin</p>
          </div>
        </div>
      </div>
    </header>

    <!-- BODY (iframe) -->
    <main class="flex-1 ">
      <iframe
        id="mainFrame"
        src="dashboard2.php"
        class="w-full h-full border-none bg-gray-50">
      </iframe>
    </main>

  </div>
</div>

<script>
  function loadPage(page) {
    document.getElementById('mainFrame').src = page;
  }
</script>

</body>
</html>
