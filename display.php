<?php
include("template/header.php");
?>

<style>
    .btn {
        width: 100px;
        align-items: center;
        margin: 0 8px;
    }

    canvas {
        max-width: 50%; /* Canvas tidak lebih lebar dari kontainer */
        height: auto; /* Tinggi akan menyesuaikan dengan lebar */
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
                <a href="index.php" class="block p-2 text-gray-700 hover:bg-gray-200 rounded">Home</a>
            </li>
            <li>
                <a href="display.php" class="block p-2 text-blue-700 bg-gray-200 rounded">Display</a>
            </li>
            <li>
                <a href="dashboard.php" class="block p-2 text-gray-700 hover:bg-gray-200 rounded">Dashboard</a>
            </li>
        </ul>
    </div>

    <div class="container mx-auto p-5">
        <!-- Tampilan Produk, Target, Penjulan -->
        <div class="flex justify-between mb-8">
            <!-- Menghitung jumlah produk yang ada di database -->
            <?php
            include("connect.php");
            $countProductsQuery = "SELECT COUNT(*) AS total_products FROM product_grup";
            $countProductsResult = mysqli_query($conn, $countProductsQuery);
            $totalProducts = 0;

            if ($countProductsResult) {
                $row = mysqli_fetch_assoc($countProductsResult);
                $totalProducts = $row['total_products'];
            }
            ?>
            <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-sm">
                <h3 class="text-2xl font-semibold text-gray-800 text-center">Jumlah Produk</h3>
                <p class="text-3xl font-bold text-blue-600 text-center"><?php echo $totalProducts; ?></p>
            </div>

            <!-- Menghitung jumlah target -->
            <?php
            $countTargetQuery = "SELECT SUM(target_value) AS total_target FROM target_grup";
            $countTargetResult = mysqli_query($conn, $countTargetQuery);
            $totalTarget = 0;

            if ($countTargetResult) {
                $row = mysqli_fetch_assoc($countTargetResult);
                $totalTarget = $row['total_target'] !== null ? $row['total_target'] : 0;
            }
            ?>
            <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-sm">
                <h3 class="text-2xl font-semibold text-gray-800 text-center">Jumlah Target</h3>
                <p class="text-3xl font-bold text-blue-600 text-center"><?php echo $totalTarget; ?></p>
            </div>

            <!-- Menghitung jumlah penjualan -->
            <?php
            $countValueQuery = "SELECT SUM(value_name) AS total_value FROM value_grup";
            $countValueResult = mysqli_query($conn, $countValueQuery);
            $totalValue = 0;

            if ($countValueResult) {
                $row = mysqli_fetch_assoc($countValueResult);
                $totalValue = $row['total_value'] !== null ? $row['total_value'] : 0;
            }
            ?>
            <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-sm">
                <h3 class="text-2xl font-semibold text-gray-800 text-center">Total Penjualan</h3>
                <p class="text-3xl font-bold text-blue-600 text-center"><?php echo $totalValue; ?></p>
            </div>
        </div>

        <table class="min-w-full bg-white shadow-md rounded border border-gray-200">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="py-3 px-4 border-b text-center">Tahun</th>
                    <th class="py-3 px-4 border-b text-center">Produk</th>
                    <th class="py-3 px-4 border-b text-center">Area</th>
                    <th class="py-3 px-4 border-b text-center">Penjualan</th>
                    <th class="py-3 px-4 border-b text-center">Target</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include("connect.php");

                $sql = "SELECT tg.id, pg.grup_name, ag.area_name, tg.target_value, vg.value_name, yg.year_name
                FROM target_grup tg
                JOIN product_grup pg ON tg.product_grup_id = pg.id
                JOIN area_grup ag ON tg.area_id = ag.id
                JOIN value_grup vg ON tg.value_id = vg.id
                JOIN year_grup yg ON tg.year_id = yg.id";
                $result = mysqli_query($conn, $sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr class='text-center'>
                                <td class='py-2 px-4 border-b'>" . $row['year_name'] . "</td>
                                <td class='py-2 px-4 border-b'>" . $row['grup_name'] . "</td>
                                <td class='py-2 px-4 border-b'>" . $row['area_name'] . "</td>
                                <td class='py-2 px-4 border-b'>" . $row['value_name'] . "</td>
                                <td class='py-2 px-4 border-b'>" . $row['target_value'] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center py-4'>Tidak ada data yang ditemukan</td></tr>";
                }

                mysqli_close($conn);
                ?>
            </tbody>
        </table>
        <div class="flex">
            <canvas id="myChartLine" class="mt-5 w-full h-8"></canvas>
            <canvas id="myChartBar" class="mt-5 w-full h-8"></canvas>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    function ChartLine() {
        fetch('get_data.php')
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.area_name);
                const targetValues = data.map(item => item.target_value);
                const productNames = data.map(item => item.grup_name);
                const valueSale = data.map(item => item.value_name);

                const ctx = document.getElementById('myChartLine').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Target',
                            data: targetValues,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }, {
                            label: 'Penjualan',
                            data: valueSale,
                            backgroundColor: 'rgba(255, 0, 0, 0.2)',
                            borderColor: 'rgba(255, 0, 0, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: { display: true, text: 'Target' }
                            },
                            x: {
                                title: { display: true, text: 'Area' }
                            }
                        },
                        tooltips: {
                            callbacks: {
                                title: function(tooltipItem, data) {
                                    const index = tooltipItem[0].index;
                                    return productNames[index];
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    function ChartBar() {
        fetch('get_data.php')
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.area_name);
                const targetValues = data.map(item => item.target_value);
                const productNames = data.map(item => item.grup_name);
                const valueSale = data.map(item => item.value_name);

                const cty = document.getElementById('myChartBar').getContext('2d');
                new Chart(cty, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Target',
                            data: targetValues,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }, {
                            label: 'Penjualan',
                            data: valueSale,
                            backgroundColor: 'rgba(255, 0, 0, 0.2)',
                            borderColor: 'rgba(255, 0, 0, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: { display: true, text: 'Target' }
                            },
                            x: {
                                title: { display: true, text: 'Area' }
                            }
                        },
                        tooltips: {
                            callbacks: {
                                title: function(tooltipItem, data) {
                                    const index = tooltipItem[0].index;
                                    return productNames[index];
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    window.onload = function() {
        ChartLine();
        ChartBar();
    };
</script>

<?php
include("template/footer.php");
?>
