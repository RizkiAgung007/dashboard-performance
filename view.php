<?php
include("connect.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Mengambil data dari database berdasarkan ID
    $sql = "SELECT pg.grup_name, ag.area_name, tg.target_value, vg.value_name, yg.year_name
            FROM target_grup tg
            JOIN product_grup pg ON tg.product_grup_id = pg.id
            JOIN area_grup ag ON tg.area_id = ag.id
            JOIN year_grup yg ON tg.year_id = yg.id
            JOIN value_grup vg ON tg.value_id = vg.id
            WHERE tg.id = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
}

mysqli_close($conn);
?>

<?php
include("template/header.php")
?>
<div class="container mx-auto p-5 mt-10 bg-white shadow-md rounded-lg">
    <h2 class="text-3xl font-bold text-center mb-6">Detail Data</h2>
    <div class="mb-4">
        <p class="text-lg"><strong>Tahun:</strong> <span class="text-gray-700"><?php echo $row['year_name']; ?></span></p>
    </div>
    <div class="mb-4">
        <p class="text-lg"><strong>Product Grup:</strong> <span class="text-gray-700"><?php echo $row['grup_name']; ?></span></p>
    </div>
    <div class="mb-4">
        <p class="text-lg"><strong>Area:</strong> <span class="text-gray-700"><?php echo $row['area_name']; ?></span></p>
    </div>
    <div class="mb-4">
        <p class="text-lg"><strong>Penjualan:</strong> <span class="text-gray-700"><?php echo $row['value_name']; ?></span></p>
    </div>
    <div class="mb-4">
        <p class="text-lg"><strong>Target:</strong> <span class="text-gray-700"><?php echo $row['target_value']; ?></span></p>
    </div>
    <div class="text-center">
        <a href="display.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded transition duration-300">Kembali</a>
    </div>
</div>
<?php
include("template/footer.php")
?>
