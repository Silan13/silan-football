<?php
require "db.php";
session_start();

$data = json_decode(file_get_contents("php://input"), true);

if ($data["action"] == "login") {

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username=?");
    $stmt->execute([$data["username"]]);
    $user = $stmt->fetch();

    if ($user && password_verify($data["password"], $user["password"])) {

        echo json_encode([
            "status" => "ok",
            "user_id" => $user["id"],
            "nickname" => $user["nickname"]
        ]);

    } else {
        echo json_encode(["status" => "error"]);
    }
}
?>
