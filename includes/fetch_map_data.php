<?php
require_once '../includes/connect_db.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("CALL get_crime_map_data()");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>