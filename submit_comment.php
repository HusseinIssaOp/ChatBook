<?php

require("./config/db.php");
// the database mysql
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["commentText"])) {
  
    session_start();
    $user_id = $_SESSION["user_id"] ?? null;

    
    $commentText = $_POST["commentText"];
  
    $stmt = $pdo->prepare("INSERT INTO comments (user_id, comment_text) VALUES (?, ?)");
    $stmt->execute([$user_id, $commentText]);

    if ($stmt->rowCount() > 0) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "Invalid request";
}
?>