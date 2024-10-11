<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $grup_name = $_POST['grup_name'];
    $area_name = $_POST['area_name'];
    $target_value = $_POST['target_value'];
    $year_name = $_POST['year_name'];
    $value_name = $_POST['value_name'];

    include("connect.php");

    // Mengecek apakah sudah ada barang didalam database
    $checkProductGroup = "SELECT id FROM product_grup WHERE grup_name = '$grup_name'";
    $resultProductGroup = mysqli_query($conn, $checkProductGroup);
    if ($resultProductGroup -> num_rows > 0) {
        $row = $resultProductGroup -> fetch_assoc();
        $product_grup_id = $row['id'];

        // Jika tidak ada barang yang sama maka buat baru
    } else {
        $insertProductGroup = "INSERT INTO product_grup (grup_name) VALUES ('$grup_name')";
        if (mysqli_query($conn, $insertProductGroup) === TRUE) {
            $product_grup_id = mysqli_insert_id($conn);
        } else {
            echo "ERROR: " . $insertProductGroup . "<br>";
        }
    }

    // Mengecek apakah sudah ada area didalam database
    $checkArea = "SELECT id FROM area_grup WHERE area_name = '$area_name'";
    $resultArea = mysqli_query($conn, $checkArea);
    if ($resultArea -> num_rows > 0) {
        $row = $resultArea->fetch_assoc();
        $area_id = $row['id'];

        // Jika tidak ada area yang sama maka buat baru
    } else {
        $insertArea = "INSERT INTO area_grup (area_name) VALUES ('$area_name')";
        if (mysqli_query($conn, $insertArea) === TRUE) {
            $area_id = mysqli_insert_id($conn);
        } else {
            echo "ERROR: " . $insertArea . "<br>";
        }
    }

    // Mengecek apakah sudah ada tahun didalam database
    $checkYear = "SELECT id FROM year_grup WHERE year_name = '$year_name'";
    $resultYear = mysqli_query($conn, $checkYear);
    if ($resultYear -> num_rows > 0) {
        $row = $resultYear -> fetch_assoc();
        $year_id = $row['id'];

        // Jika tidak ada tahun yang sama maka buat baru
    } else {
        $insertYear = "INSERT INTO year_grup (year_name) VALUES ('$year_name')";
        if (mysqli_query($conn, $insertYear) === TRUE) {
            $year_id = mysqli_insert_id($conn);
        } else {
            echo "ERROR: ". $insertYear. "<br>";
        }
    }
    // 
    // Mengecek apakah sudah ada value didalam database
    $checkValue = "SELECT id FROM value_grup WHERE value_name = '$value_name'";
    $resultValue = mysqli_query($conn, $checkValue);
    if ($resultValue -> num_rows > 0) {
        $row = $resultValue -> fetch_assoc();
        $value_id = $row['id'];

        // Jika tidak ada tahun yang sama maka buat baru
    } else {
        $insertValue = "INSERT INTO value_grup (value_name) VALUES ('$value_name')";
        if (mysqli_query($conn, $insertValue) === TRUE) {
            $value_id = mysqli_insert_id($conn);
        } else {
            echo "ERROR: ". $insertValue. "<br>";
        }
    }
       
    // Memasukkan tahun, produk, area, penjualan dan target ke dalam tabel target_grup
    $insertTarget = "INSERT INTO target_grup (product_grup_id, area_id, target_value, year_id, value_id) VALUES ('$product_grup_id', '$area_id', '$target_value', '$year_id', '$value_id')";

    if (mysqli_query($conn, $insertTarget) === TRUE) {
        echo "Data berhasil tersimpan";
        header('Location: display.php');
    } else {
        echo "ERROR: " . $insertTarget . "<br>";
    }
}

mysqli_close($conn);
?>