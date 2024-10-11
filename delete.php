<?php
include("connect.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Mengambil product_grup_id dan area_grup_id serta month_id sebelum menghapus target_grup
    $sqlGetIds = "SELECT product_grup_id, area_id, year_id, value_id FROM target_grup WHERE id = '$id'";
    $result = mysqli_query($conn, $sqlGetIds);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $product_grup_id = $row['product_grup_id'];
        $area_grup_id = $row['area_id'];
        $year_grup_id = $row['year_id'];
        $value_grup_id = $row['value_id'];

        // Menghapus data dari tabel target_grup
        $sqlDeleteTarget = "DELETE FROM target_grup WHERE id = '$id'";
        mysqli_query($conn, $sqlDeleteTarget);

        // Cek jika penghapusan target_grup berhasil
        if (mysqli_affected_rows($conn) > 0) {

            // Menghapus data dari tabel product_grup jika tidak ada referensi di target_grup
            $checkProductReferencing = "SELECT COUNT(*) AS count FROM target_grup WHERE product_grup_id = '$product_grup_id'";
            $checkProductResult = mysqli_query($conn, $checkProductReferencing);
            $checkProductRow = mysqli_fetch_assoc($checkProductResult);
            if ($checkProductRow['count'] == 0) {
                $sqlDeleteProduct = "DELETE FROM product_grup WHERE id = '$product_grup_id'";
                mysqli_query($conn, $sqlDeleteProduct);
            }

            // Menghapus data dari tabel area_grup jika tidak ada referensi di target_grup
            $checkAreaReferencing = "SELECT COUNT(*) AS count FROM target_grup WHERE area_id = '$area_grup_id'";
            $checkAreaResult = mysqli_query($conn, $checkAreaReferencing);
            $checkAreaRow = mysqli_fetch_assoc($checkAreaResult);
            if ($checkAreaRow['count'] == 0) {
                $sqlDeleteArea = "DELETE FROM area_grup WHERE id = '$area_grup_id'";
                mysqli_query($conn, $sqlDeleteArea);
            }

            // Menghapus data dari tabel year_grup jika tidak ada refrensi di target_grup
            $checkYearReferencing = "SELECT COUNT(*) AS count FROM target_grup WHERE year_id = '$year_grup_id'";
            $checkYearResult = mysqli_query($conn, $checkYearReferencing);
            $checkYearRow = mysqli_fetch_assoc($checkYearResult);
            if ($checkYearRow['count'] == 0) {
            $sqlDeleteYear = "DELETE FROM year_grup WHERE id = '$year_grup_id'";
                mysqli_query($conn, $sqlDeleteYear);
            }

            // Menghapus data dari tabel value_grup jika tidak ada refrensi di target_grup
            $checkValueReferencing = "SELECT COUNT(*) AS count FROM target_grup WHERE value_id = '$value_grup_id'";
            $checkValueResult = mysqli_query($conn, $checkValueReferencing);
            $checkValueRow = mysqli_fetch_assoc($checkValueResult);
            if ($checkValueRow['count'] == 0) {
            $sqlDeleteValue = "DELETE FROM value_grup WHERE id = '$value_grup_id'";
                mysqli_query($conn, $sqlDeleteValue);
            }

            session_start();
            $_SESSION["delete"] = "Post deleted successfully";
            header("Location: display.php");
            exit();
        } else {
            echo "Error: Gagal menghapus target grup.";
        }
    } else {
        echo "Error: Data not found.";
    }
} else {
    echo "No ID provided";
}

mysqli_close($conn);
?>
