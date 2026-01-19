<?php include 'server_connection.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100" >
    <div class="p-8">
        <?php
        // মোট কাস্টমার সংখ্যা
        $result = $conn->query("SELECT COUNT(*) AS total_customers FROM customers");
        $row = $result->fetch_assoc();
        echo "<p class='font-semibold text-lg'>মোট কাস্টমার: <b>" . $row['total_customers'] . "</b></p>";
        ?>

<h3 class="flex justify-center font-semibold">কাস্টমার লিস্ট</h3>
<div class="hidden lg:block">
<table class="border w-full">
    <tr class="border bg-gray-50">
        <th class="border py-1 px-2">ID</th>
        <th class="border py-1 px-2">Customer Name</th>
        <th class="border py-1 px-2">Contact Person</th>
        <th class="border py-1 px-2">Phone</th>
        <th class="border py-1 px-2">Details</th>
        <th class="border py-1 px-2">Action</th>
    </tr>
    <?php
    $sql = "SELECT * FROM customers";
    $customers = $conn->query($sql);
    while ($c = $customers->fetch_assoc()) {
        echo "<tr class='border bg-white'>
            <td class='border py-1 px-2'>{$c['id']}</td>
            <td class='border py-1 px-2'>{$c['name']}</td>
            <td class='border py-1 px-2'>{$c['contact_person']}</td>
            <td class='border py-1 px-2'>{$c['phone']}</td>
            <td class='border py-1 px-2'><a href='customer.php?id={$c['id']}'>Details....</a></td>
            <td class='border py-1 px-2'>
            <button class='btn' onclick=\"editData('customers', '{$c['id']}')\">Edit</button>
            <button class='btn' onclick=\"deleteData('customers', '{$c['id']}')\">Delete</button></td>
           
        </tr>";
    }
    ?>
</table>
</div>
<div class="block sm:hidden">
        <?php 
        $sql = "SELECT * FROM customers";
        $customers = $conn->query($sql);
        while ($c = $customers->fetch_assoc()) {
        echo "
<table class='block sm:hidden w-full mb-4 border border-gray-300  overflow-hidden text-sm bg-white'>

  <tr class='border-b bg-gray-100'>
    <th class='border px-4 py-2 text-left font-semibold w-1/3'>
      Customer ID
    </th>
    <td class='border px-4 py-2 text-gray-800'>
      {$c['id']}
    </td>
  </tr>

  <tr class='border-b'>
    <th class='border px-4 py-2 text-left font-semibold'>
      Customer Name
    </th>
    <td class='border px-4 py-2'>
      {$c['name']}
    </td>
  </tr>

  <tr class='border-b bg-gray-50'>
    <th class='border px-4 py-2 text-left font-semibold'>
      Contact Person
    </th>
    <td class='border px-4 py-2'>
      {$c['contact_person']}
    </td>
  </tr>

  <tr class='border-b'>
    <th class='border px-4 py-2 text-left font-semibold'>
      Phone
    </th>
    <td class='border px-4 py-2'>
      {$c['phone']}
    </td>
  </tr>

  <tr class='border-b bg-gray-50'>
    <th class='border px-4 py-2 text-left font-semibold'>
      Details
    </th>
    <td class='border px-4 py-2'>
      <a href='customer.php?id={$c['id']}'
         class='text-blue-600 hover:text-blue-800 hover:underline font-medium'>
        Details →
      </a>
    </td>
  </tr>

  <tr class='border bg-gray-50'>
    <th class='border-r px-4 py-2 text-left font-semibold'>
      Action
    </th>
    <td class=' px-4 py-2 flex gap-2'>
      <button
        class='px-3 py-1 rounded bg-blue-500 text-white text-xs hover:bg-blue-600 transition'
        onclick=\"editData('customers', '{$c['id']}')\">
        Edit
      </button>

      <button
        class='px-3 py-1 rounded bg-red-500 text-white text-xs hover:bg-red-600 transition'
        onclick=\"deleteData('customers', '{$c['id']}')\">
        Delete
      </button>
    </td>
  </tr>

</table>
";

    }
        ?>
</div>
</div>
</body>
</html>

