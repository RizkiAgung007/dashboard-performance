<?php
include("connect.php");

$filter_channel = isset($_GET['filter_channel']) ? $_GET['filter_channel'] : '';

$sql = "SELECT tg.target_value, vg.value_name, ag.area_name, pg.grup_name
FROM target_grup tg
JOIN product_grup pg ON tg.product_grup_id = pg.id
JOIN area_grup ag ON tg.area_id = ag.id
JOIN value_grup vg ON tg.value_id = vg.id";

if ($filter_channel) {
    $sql .= " JOIN channel_grup cg ON tg.channel_id = cg.id WHERE cg.channel_name = '$filter_channel'";
}

$result = mysqli_query($conn, $sql);
$data = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($data);

mysqli_close($conn);
?>
