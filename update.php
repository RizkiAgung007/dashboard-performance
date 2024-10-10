<?php
include("template/header.php");
include("connect.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Mengambil data dari database berdasarkan id
    $sql = "SELECT pg.grup_name, ag.area_name, tg.target_value, mg.month_name, yg.year_name 
            FROM target_grup tg
            JOIN product_grup pg ON tg.product_grup_id = pg.id
            JOIN area_grup ag ON tg.area_id = ag.id
            JOIN month_grup mg ON tg.month_id = mg.id
            JOIN year_grup yg ON tg.year_id = yg.id
            WHERE tg.id = '$id'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "<div class='bg-red-500 text-white p-3 rounded-md mb-4'>Error fetching data: " . mysqli_error($conn) . "</div>";
        exit;
    }
    $row = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $grup_name = mysqli_real_escape_string($conn, $_POST['grup_name']);
    $area_name = mysqli_real_escape_string($conn, $_POST['area_name']);
    $target_value = mysqli_real_escape_string($conn, $_POST['target_value']);
    $year_name = mysqli_real_escape_string($conn, $_POST['year_name']);
    $month_name = mysqli_real_escape_string($conn, $_POST['month_name']);

    // Mengupdate data
    $updateSql = "UPDATE target_grup tg
                  SET tg.target_value = '$target_value'
                  WHERE tg.id = '$id'";

    // Eksekusi query update target_grup
    if (!mysqli_query($conn, $updateSql)) {
        echo "<div class='bg-red-500 text-white p-3 rounded-md mb-4'>Error updating target_value: " . mysqli_error($conn) . "</div>";
    }

    // Mengupdate data di tabel lain secara terpisah
    $updateGrupSql = "UPDATE product_grup SET grup_name = '$grup_name' WHERE id = (SELECT product_grup_id FROM target_grup WHERE id = '$id')";
    if (!mysqli_query($conn, $updateGrupSql)) {
        echo "<div class='bg-red-500 text-white p-3 rounded-md mb-4'>Error updating grup_name: " . mysqli_error($conn) . "</div>";
    }

    $updateAreaSql = "UPDATE area_grup SET area_name = '$area_name' WHERE id = (SELECT area_id FROM target_grup WHERE id = '$id')";
    if (!mysqli_query($conn, $updateAreaSql)) {
        echo "<div class='bg-red-500 text-white p-3 rounded-md mb-4'>Error updating area_name: " . mysqli_error($conn) . "</div>";
    }

    $updateMonthSql = "UPDATE month_grup SET month_name = '$month_name' WHERE id = (SELECT month_id FROM target_grup WHERE id = '$id')";
    if (!mysqli_query($conn, $updateMonthSql)) {
        echo "<div class='bg-red-500 text-white p-3 rounded-md mb-4'>Error updating month_name: " . mysqli_error($conn) . "</div>";
    }

    $updateYearSql = "UPDATE year_grup SET year_name = '$year_name' WHERE id = (SELECT year_id FROM target_grup WHERE id = '$id')";
    if (!mysqli_query($conn, $updateYearSql)) {
        echo "<div class='bg-red-500 text-white p-3 rounded-md mb-4'>Error updating year_name: " . mysqli_error($conn) . "</div>";
    }

    // Mengecek apakah ada perubahan data
    if (mysqli_affected_rows($conn) > 0) {
        echo "<div class='bg-green-500 text-white p-3 rounded-md mb-4'>Data berhasil diupdate.</div>";
        header("Location: display.php");
        exit;
    } else {
        echo "<div class='bg-yellow-500 text-black p-3 rounded-md mb-4'>Tidak ada perubahan data.</div>";
        header("Location: display.php");
    }
}
?>

<div class="container mx-auto p-5 mt-10 bg-white shadow-md rounded-lg">
    <a href="display.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded mb-5 inline-block">Back</a>
    <h2 class="text-3xl font-bold text-center mb-6">Update Data</h2>
    <form action="" method="POST">
        <div class="mb-4">
            <label for="year_name" class="block text-lg font-medium text-gray-700">Tahun</label>
            <input type="text" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" id="year_name" name="year_name" value="<?php echo htmlspecialchars($row['year_name']); ?>" required>
        </div>

        <div class="mb-4">
            <label for="grup_name" class="block text-lg font-medium text-gray-700">Produk</label>
            <input type="text" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" id="grup_name" name="grup_name" value="<?php echo htmlspecialchars($row['grup_name']); ?>" required>
        </div>

        <div class="mb-4">
            <label for="area_name" class="block text-lg font-medium text-gray-700">Area</label>
            <input type="text" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" id="area_name" name="area_name" value="<?php echo htmlspecialchars($row['area_name']); ?>" required>
        </div>

        <div class="mb-4">
            <label for="month_name" class="block text-lg font-medium text-gray-700">Bulan</label>
            <input type="text" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" id="month_name" name="month_name" value="<?php echo htmlspecialchars($row['month_name']); ?>" required>
        </div>

        <div class="mb-4">
            <label for="target_value" class="block text-lg font-medium text-gray-700">Target</label>
            <input type="number" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" id="target_value" name="target_value" value="<?php echo htmlspecialchars($row['target_value']); ?>" required>
        </div>

        <div class="text-center">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded transition duration-300">Update</button>
        </div>
    </form>
</div>

<?php
include("template/footer.php");
?>
