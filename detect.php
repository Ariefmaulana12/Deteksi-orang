<?php
// detect.php (Contoh Penggunaan PHP untuk Menyimpan Hasil Deteksi)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $detectionResult = $_POST['result']; // Menyimpan hasil deteksi
    // Lakukan penyimpanan ke database atau ke file (misalnya MySQL)
    // $conn = new mysqli("host", "user", "password", "database");
    // $query = "INSERT INTO detections (result) VALUES ('$detectionResult')";
    // $conn->query($query);
    // $conn->close();

    echo json_encode(['status' => 'success', 'message' => 'Data Tersimpan']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Request tidak valid']);
}
?>
