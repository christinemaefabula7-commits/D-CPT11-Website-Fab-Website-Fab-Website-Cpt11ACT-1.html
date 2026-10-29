
<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $productid = filter_input(
        INPUT_POST,
        "product_id",
        FILTER_VALIDATE_INT
    );

    $qty = filter_input(
        INPUT_POST,
        "Qty",
        FILTER_VALIDATE_INT
    );

    $user = trim($_POST["User"] ?? "");
    $contact = trim($_POST["Contact"] ?? "");

    if (
        !$productid ||
        !$qty ||
        $qty < 1 ||
        $user === "" ||
        $contact === ""
    ) {
        die("Please complete all fields correctly.");
    }

    // Get the actual product price from the database.
    $stmt = $conn->prepare(
        "SELECT Price FROM fruitsandveggies
         WHERE Productid = ?"
    );

    $stmt->bind_param("i", $productid);
    $stmt->execute();
    $stmt->bind_result($price);

    if (!$stmt->fetch()) {
        $stmt->close();
        die("Product not found.");
    }

    $stmt->close();

    $total = $price * $qty;

    // Save the order.
    $stmt = $conn->prepare(
        "INSERT INTO orders
         (Productid, Qty, Total, `User`, Contact)
         VALUES (?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "iidss",
        $productid,
        $qty,
        $total,
        $user,
        $contact
    );

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();

        header("Location: index.php?order=success");
        exit;
    } else {
        die("Error saving order: " . $stmt->error);
    }

} else {
    header("Location: index.php");
    exit;
}
?>
