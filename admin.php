<?php 
include 'server_connection.php';
// ডিলিট ইমপ্লয়ি
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM employees WHERE employee_id = $id");
    header("Location: admin.php");
    exit();
}

// Employees data fetch safely
$result = $conn->query("SELECT * FROM employees");
if (!$result) {
    $employees = [];
} else {
    $employees = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>MS Corporation</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <?php include 'header_and_sidebar_for_admin.php'; ?>
<div class="main">
  <div class="for_content" id="contentArea">
    <!-- Image Slider -->
    <div class="slider" id="slider" aria-roledescription="carousel">
      <div class="slides" id="slides">
        <?php 
        $images = ["logo.jpg","img(1).jpg","img(2).jpg","img(3).jpg","img(4).jpg","img(5).jpg",
                   "img(6).jpg","img(7).jpg","img(8).jpg","img(9).jpg","img(10).jpg"];
        foreach($images as $img){
            echo '<div class="slide"><img src="image/'.$img.'"><div class="overlay-text">Majestic Mountain View</div></div>';
        }
        ?>
      </div>
      <button class="nav left" id="prev" aria-label="Previous slide">❮</button>
      <button class="nav right" id="next" aria-label="Next slide">❯</button>
      <div class="dots" id="dots" role="tablist" aria-label="Slide dots"></div>
    </div>
  </div>
   
  </div>

</div> <!-- main end -->
<script src="script.js"></script>
</body>
</html>
