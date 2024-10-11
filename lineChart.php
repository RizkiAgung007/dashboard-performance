<?php
include("template/header.php");
?>

<style>
    /* canvas {
        max-width: 50%; 
        height: auto;
    } */
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
                <a href="display.php" class="block p-2 text-gray-700 hover:bg-gray-200 rounded">Display</a>
            </li>
            <li>
                <a href="dashboard.php" class="block p-2 text-gray-700 hover:bg-gray-200 rounded">Dashboard</a>
            </li>
            <li>
                <a href="lineChart.php" class="block p-2 text-blue-700 bg-gray-200 rounded">LineChart</a>
            </li>
            <li>
                <a href="barChart.php" class="block p-2 text-gray-700 hover:bg-gray-200 rounded">BarChart</a>
            </li>
        </ul>
    </div>
    <div class="container mx-auto p-5">
        <div class="flex flex-col justify-center items-center">
            <h2 class="text-2xl font-bold text-center mb-5">Line Chart</h2>
            <canvas id="myChartLine" height="40" width="100" class="mt-8"></canvas>
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
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    title: function(tooltipItem) {
                                        const index = tooltipItem[0].dataIndex;
                                        return productNames[index];
                                    }
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
    }
</script>

<?php
include("template/footer.php");
?>
