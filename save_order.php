<?php
session_start();
require "db.php";

$d = json_decode(file_get_contents("php://input"), true);
$status = "Pending";
$itemsJson = json_encode($d['items']);

$stmt = $connection->prepare("INSERT INTO orders (order_id,user_id,name,phone,address,note,payment,items,total,status,created_at) VALUES (?,?,?,?,?,?,?,?,?,?,NOW())");
$stmt->bind_param("sissssssds",
  $d['id'], $_SESSION['user_id'], $d['name'], $d['phone'],
  $d['address'], $d['note'], $d['payment'],
  $itemsJson, $d['total'], $status
);
$stmt->execute();

echo json_encode(["success" => true]);