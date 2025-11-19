<?php include 'server_connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MS Corporation</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <?php include 'header_and_sidebar_for_admin.php'; ?>
  <div class="main">
    <div class="for_content" id="contentArea">
      <?php  
      // মোট ইমপ্লয়ি দেখানোর জন্য
      $result = $conn->query("SELECT COUNT(*) AS total_employee FROM employees");
      $row = $result->fetch_assoc();
      echo "<p> মোট Employee <b>" .$row['total_employee']."</b></p>";
      ?>
      <div class="for_pc">
          <table>
            <tr>
              <th>Employee ID:</th>
              <th>Employee Name:</th>
              <th>Employee Role:</th>
              <th>Action:</th>
            </tr>
            <?php  
            $sql = "SELECT * FROM employees ";
            $employees = $conn->query($sql);
            while ($e = $employees->fetch_assoc()){
              echo "
              <tr>
              <td>{$e['employee_id']}</td>
              <td>{$e['name']}</td>
              <td>{$e['role']}</td>
              <td onclick=\"window.location.href='delete.php?table=employees&id={$e['employee_id']}'\" style='cursor:pointer; color:red;'>Delete</td>
              </tr>
              ";
            }
            
            ?>
          </table>
      </div>
      <div class="for_phone">
        <table>
          <?php   
          $sql = "SELECT * FROM employees";
          $employ = $conn->query($sql);
          while($e = $employ->fetch_assoc()){
              echo "
               <table border='1' cellspacing='0' cellpadding='6' style='margin-bottom:20px; border-collapse:collapse; width:100%; border-radius:7px;'>
              <tr>
              <th>Employee ID:</th>
              <td>{$e['employee_id']}</td>
              </tr>
              <tr>
              <th>Employee Name:</th>
              <td>{$e['name']}</td>
              </tr>
              <tr>
              <th>Employee Role:</th>
              <td>{$e['role']}</td>
              </tr>
              <tr>
              <th>Action:</th>
              <td onclick=\"window.location.href='delete.php?table=employees&id={$e['employee_id']}'\" style='cursor:pointer; color:red;'>Delete</td>
              
              </tr>
              
              
              
              ";


          }
          
          
          
          ?>
        </table>
      </div>

    </div>
  </div>
  <script src="script.js"></script>
</body>
</html>