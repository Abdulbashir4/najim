<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <title>স্টোর ফর্ম</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f7f9fc;
      padding: 30px;
    }
    .store-form {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      max-width: 500px;
      margin: auto;
    }
    .store-form h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }
    label {
      font-weight: bold;
      margin-bottom: 5px;
      display: block;
      color: #444;
    }
    input, textarea, select {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
    }
    textarea {
      resize: none;
      height: 80px;
    }
    button {
      background: #4CAF50;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      width: 100%;
    }
    button:hover {
      background: #45a049;
    }
  </style>
</head>
<body>
  <div class="store-form page-content">
    <h2>স্টোর ফর্ম</h2>
    <form action="store_insert.php" method="POST">
      <label>১. প্রোডাক্ট নাম:</label>
      <input type="text" name="product_name" required>

      <label>২. কত পিস:</label>
      <input type="number" name="quantity" required>

      <label>৩. দর (প্রতি পিস/মোট):</label>
      <input type="number" step="0.01" name="price" required>

      <label>৪. দোকান নাম:</label>
      <input type="text" name="shop_name" required>

      <label>৫. তারিখ ও সময়:</label>
      <input type="datetime-local" name="purchase_datetime" required>

      <label>৬. কত টাকা দেওয়া হলো:</label>
      <input type="number" step="0.01" name="paid_amount" required>

      <label>৭. কত টাকা বাকি আছে:</label>
      <input type="number" step="0.01" name="due_amount">

      <label>৮. নোট:</label>
      <textarea name="note"></textarea>

      <button type="submit">সেভ করুন</button>
    </form>
  </div>
</body>
</html>
