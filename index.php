<?php
include("template/header.php");
?>

<style>
    .btn {
        width: 100px;
        align-items: center;
        margin: 0 8px;
    }
</style>

<div class="flex bg-gray-100 min-h-screen">
    <div class="flex flex-col bg-white shadow-lg w-64 p-4">
        <div class="flex items-center justify-between">
            <a href="/" class="text-xl font-semibold text-gray-700">Dashboard</a>
        </div>
        <hr class="my-4">
        <ul class="flex flex-col space-y-1">
            <li>
                <a href="index.php" class="block p-2 text-blue-700 bg-gray-200 rounded">Home</a>
            </li>
            <li>
                <a href="display.php" class="block p-2 text-gray-700 hover:bg-gray-200 rounded">Display</a>
            </li>
        </ul>
    </div>

    <div class="container mx-auto p-5">
        <h2 class="text-2xl font-bold text-center mb-4">Form Input</h2>
        
        <form action="proces.php" method="POST" class="bg-white shadow-md rounded-lg p-6">
            <div class="mb-4">
                <label for="year_name" class="block text-sm font-medium text-gray-700">Tahun</label>
                <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-300" id="year_name" name="year_name" required>
            </div>

            <div class="mb-4">
                <label for="grup_name" class="block text-sm font-medium text-gray-700">Produk</label>
                <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-300" id="grup_name" name="grup_name" required>
            </div>

            <div class="mb-4">
                <label for="month_name" class="block text-sm font-medium text-gray-700">Bulan</label>
                <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-300" id="month_name" name="month_name" required>
            </div>

            <div class="mb-4">
                <label for="area_name" class="block text-sm font-medium text-gray-700">Area</label>
                <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-300" id="area_name" name="area_name" required>
            </div>
        
            <div class="mb-4">
                <label for="target_value" class="block text-sm font-medium text-gray-700">Target</label>
                <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-300" id="target_value" name="target_value" required>
            </div>

            <div class="flex justify-end">
                <input type="submit" class="btn bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition duration-200" value="Submit">
            </div>
        </form>
    </div>
</div>

<?php
include("template/footer.php");
?>
