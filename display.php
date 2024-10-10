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
                <a href="index.php" class="block p-2 text-gray-700 hover:bg-gray-200 rounded">Home</a>
            </li>
            <li>
                <a href="display.php" class="block p-2 text-blue-700 bg-gray-200 rounded">Display</a>
            </li>
        </ul>
    </div>

    <div class="container mx-auto p-5">
    <h2 class="text-2xl font-bold text-center mb-5">Data Master</h2>
    <table class="min-w-full bg-white shadow-md rounded border border-gray-200">
        <thead>
            <tr class="bg-gray-100 text-gray-700">
                <th class="py-3 px-4 border-b text-center">Tahun</th>
                <th class="py-3 px-4 border-b text-center">Produk</th>
                <th class="py-3 px-4 border-b text-center">Area</th>
                <th class="py-3 px-4 border-b text-center">Bulan</th>
                <th class="py-3 px-4 border-b text-center">Target</th>
                <th class="py-3 px-4 border-b text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include("connect.php");

            $sql = "SELECT tg.id, pg.grup_name, ag.area_name, tg.target_value, mg.month_name, yg.year_name
            FROM target_grup tg
            JOIN product_grup pg ON tg.product_grup_id = pg.id
            JOIN area_grup ag ON tg.area_id = ag.id
            JOIN month_grup mg ON tg.month_id = mg.id
            JOIN year_grup yg ON tg.year_id = yg.id";
            $result = mysqli_query($conn, $sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr class='text-center'>
                            <td class='py-2 px-4 border-b'>" . $row['year_name'] . "</td>
                            <td class='py-2 px-4 border-b'>" . $row['grup_name'] . "</td>
                            <td class='py-2 px-4 border-b'>" . $row['area_name'] . "</td>
                            <td class='py-2 px-4 border-b'>" . $row['month_name'] . "</td>
                            <td class='py-2 px-4 border-b'>" . $row['target_value'] . "</td>
                            <td class='py-2 px-4 border-b'>
                                <div class='flex justify-center space-x-2'>
                                    <a href='view.php?id=" . $row['id'] . "' class='bg-blue-500 text-white py-1 px-2 rounded hover:bg-blue-600'>View</a>
                                    <a href='update.php?id=" . $row['id'] . "' class='bg-yellow-500 text-white py-1 px-2 rounded hover:bg-yellow-600'>Update</a>
                                    <a href='delete.php?id=" . $row['id'] . "' class='bg-red-500 text-white py-1 px-2 rounded hover:bg-red-600' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Delete</a>
                                </div>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center py-4'>Tidak ada data yang ditemukan</td></tr>";
            }

            mysqli_close($conn);
            ?>
        </tbody>
    </table>
    <canvas id="myChart" width="20" height="5" class="mt-5"></canvas>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    function fetchDataAndDrawChart() {
        fetch('get_data.php')
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.area_name);
                const targetValues = data.map(item => item.target_value);
                const productNames = data.map(item => item.grup_name);

                const ctx = document.getElementById('myChart').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Target Values',
                            data: targetValues,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Target'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Area'
                                }
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

    window.onload = fetchDataAndDrawChart;
</script>

<?php
include("template/footer.php");
?>
