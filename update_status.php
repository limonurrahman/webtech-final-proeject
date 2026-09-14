<?php
include "../includes/auth.php";
requireRole("staff");
include "../config/db.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$id = intval($data["id"] ?? 0);
$status = $data["status"] ?? "";

$allowed = ["Pending", "In Progress", "Resolved"];

if ($id <= 0 || !in_array($status, $allowed)) {
    echo json_encode(["success" => false, "message" => "Invalid data"]);
    exit();
}

$stmt = $conn->prepare("UPDATE complaints SET status=? WHERE id=?");
$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Status updated"]);
} else {
    echo json_encode(["success" => false, "message" => "Update failed"]);
}
?>
