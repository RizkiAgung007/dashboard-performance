<?php
include("connect.php");

$query = "SELECT area_grup.area_name, target_grup.target_value, product_grup.grup_name, month_grup.month_name, year_grup.year_name
          FROM target_grup 
          INNER JOIN area_grup ON target_grup.area_id = area_grup.id
          INNER JOIN product_grup ON target_grup.product_grup_id = product_grup.id
          INNER JOIN month_grup ON target_grup.month_id = month_grup.id
          INNER JOIN year_grup ON target_grup.year_id = year_grup.id";
$result = mysqli_query($conn, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data); // Mengembalikan data dalam format JSON
mysqli_close($conn);
?>