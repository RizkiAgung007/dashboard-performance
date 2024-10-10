<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $grup_name = $_POST['grup_name'];
    $area_name = $_POST['area_name'];
    $target_value = $_POST['target_value'];
    $month_name = $_POST['month_name'];
    $year_name = $_POST['year_name'];

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

    // Mengecek apakah sudah ada bulan di dalam database
    $checkMonth = "SELECT id FROM month_grup WHERE month_name = '$month_name'";
    $resultMonth = mysqli_query($conn, $checkMonth);
    if ($resultMonth->num_rows > 0) {
        $row = $resultMonth->fetch_assoc();
        $month_id = $row['id'];
        
        // Jika bulan tidak ada, Anda bisa memasukkan bulan baru jika perlu
    } else {
        $insertMonth = "INSERT INTO month_grup (month_name) VALUES ('$month_name')";
        if (mysqli_query($conn, $insertMonth) === TRUE) {
            $month_id = mysqli_insert_id($conn);
        } else {
        echo "ERROR: " . $insertMonth . "<br>";
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
        $insertYear = "INSERT INTO year_grup (year_name) VALUES ($year_name)";
        if (mysqli_query($conn, $insertYear) === TRUE) {
            $year_id = mysqli_insert_id($conn);
        } else {
            echo "ERROR: ". $insertYear. "<br>";
        }
    }
       
    // Memasukkan produk, area, bulan, dan target ke dalam tabel target_grup
    $insertTarget = "INSERT INTO target_grup (product_grup_id, area_id, target_value, month_id, year_id) VALUES ('$product_grup_id', '$area_id', '$target_value', '$month_id', '$year_id')";

    if (mysqli_query($conn, $insertTarget) === TRUE) {
        echo "Data berhasil tersimpan";
        header('Location: display.php');
    } else {
        echo "ERROR: " . $insertTarget . "<br>";
    }
}

mysqli_close($conn);
?>