<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard</title>
   <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

  <!-- Main -->
  <main class="flex-1">

    <!-- Topbar -->
    <header class="bg-white border-b px-6 py-4 flex justify-between items-center">
      <input
        type="text"
        placeholder="Search orders, products..."
        class="w-1/2 px-4 py-2 border rounded-lg focus:outline-none"
      />
      <div class="flex items-center gap-3">
        <img src="https://i.pravatar.cc/40" class="rounded-full" />
        <div>
          <p class="font-semibold">Admin</p>
          <p class="text-xs text-gray-500">Super Admin</p>
        </div>
      </div>
    </header>

    <!-- Content -->
    <div class="p-6 space-y-6">

      <!-- Stats -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-xl shadow">
          <p class="text-sm text-gray-500">Total Sales</p>
          <h2 class="text-2xl font-bold">৳32,000.00</h2>
          <p class="text-green-500 text-sm">+8.4% vs last week</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
          <p class="text-sm text-gray-500">Total Orders</p>
          <h2 class="text-2xl font-bold">19</h2>
          <p class="text-red-500 text-sm">-2.1% vs last week</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
          <p class="text-sm text-gray-500">Pending Orders</p>
          <h2 class="text-2xl font-bold">13</h2>
          <p class="text-green-500 text-sm">+8.4%</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
          <p class="text-sm text-gray-500">Revenue</p>
          <h2 class="text-2xl font-bold">$56,430</h2>
          <p class="text-green-500 text-sm">+12.6%</p>
        </div>
      </div>

      <!-- Middle Section -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Chart -->
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow">
          <div class="flex justify-between mb-4">
            <h3 class="font-semibold">Revenue (Last 30 days)</h3>
            <span class="text-sm text-gray-400">Updated 2h ago</span>
          </div>
          <div class="h-48 bg-gradient-to-t from-indigo-100 to-transparent rounded-lg flex items-center justify-center text-gray-400">
            Chart Placeholder
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white p-6 rounded-xl shadow space-y-3">
          <h3 class="font-semibold">Quick Actions</h3>
          <button class="w-full bg-indigo-600 text-white py-2 rounded-lg">Add Product</button>
          <button class="w-full bg-orange-500 text-white py-2 rounded-lg">Add Discount</button>
          <button class="w-full bg-green-600 text-white py-2 rounded-lg">Export CSV</button>
          <button class="w-full bg-gray-200 py-2 rounded-lg">Settings</button>
        </div>
      </div>

      <!-- Activity -->
      <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="font-semibold mb-4">Activity</h3>
        <ul class="space-y-3 text-sm">
          <li class="flex items-center gap-2">
            🟢 New user signed up <span class="text-gray-400">— 10m ago</span>
          </li>
          <li class="flex items-center gap-2">
            📦 Order #2712 shipped <span class="text-gray-400">— 30m ago</span>
          </li>
          <li class="flex items-center gap-2 text-yellow-600">
            ⚠️ Payment failed <span class="text-gray-400">— 2h ago</span>
          </li>
        </ul>
      </div>

    </div>
  </main>
</div>

</body>
</html>
