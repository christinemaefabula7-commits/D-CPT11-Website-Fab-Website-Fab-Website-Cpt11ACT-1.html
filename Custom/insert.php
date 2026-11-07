<?php
require_once __DIR__ . "/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $showsId = filter_input(INPUT_POST, "shows_id", FILTER_VALIDATE_INT);
    $title = isset($_POST["title"]) ? trim($_POST["title"]) : "";
    $watchDate = isset($_POST["watch_date"]) ? trim($_POST["watch_date"]) : "";

    // I-check kung valid ang showsId, title, at watch_date
    if (!$showsId || empty($title) || empty($watchDate)) {
        header("Location: index.php?status=failed");
        exit;
    }

    // Isinama ang 'Title' sa SQL INSERT query para pumasok na ito sa database
    $stmt = $conn->prepare("INSERT INTO watchlist (ShowsID, Title, WatchDate) VALUES (?, ?, ?)");
    
    // "iss" = integer ($showsId), string ($title), string ($watchDate)
    $stmt->bind_param("iss", $showsId, $title, $watchDate);

    if ($stmt->execute()) {
        header("Location: index.php?status=success");
    } else {
        header("Location: index.php?status=failed");
    }
    
    $stmt->close();
    $conn->close();
} else {
    header("Location: index.php");
}
exit;
?>