
<?php
require_once __DIR__ . "/db.php";

if (!isset($conn) || !($conn instanceof mysqli)) {
    die("Database connection error. Please check db.php.");
}

$sql = "SELECT * FROM fruitsandveggies ORDER BY Productid ASC";
$result = $conn->query($sql);

if (!$result) {
    die("Error fetching products: " . $conn->error);
}

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palengke Kiosk</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        * {
            box-sizing: border-box;
        }

        .container {
            width: 90%;
            max-width: 100%;
            margin: 0 auto;
            padding-left: 30px;
            padding-right: 30px;
        }

        body {
            margin: 0;
            background-color: #c0e8e5;
            font-family: Arial, sans-serif;
            color: #443441;
        }

        /* Navbar */
        .navbar {
            background-color: #fff !important;
            border-bottom: 1px solid #e3d2df;
        }

    
            .navbar-brand {
            font-size: 30px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .navbar-brand img {
        width: 75px;
        height: 75px;
        object-fit: contain;
        }

        .navbar-nav .nav-link {
        font-size: 25px;
        font-weight: 600;
        padding: 12px 18px;
    }
        /* Heading */
        .page-heading {
            text-align: center;
            padding: 28px 20px 20px;
        }

        .page-heading h1 {
            font-size: clamp(22px, 3vw, 30px);
            font-weight: bold;
        }

        .page-heading p {
            font-size: 18px;
            color: #4c3009;
        }

        /* Product cards */
        .product-card {
            height: 100%;
            background: #fff;
            border: 1px solid #d7c5d2;
            border-radius: 18px;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 14px rgba(60, 35, 55, 0.12);
        }

        .product-image {
            display: block;
            width: 100%;
            height: 145px;
            padding: 12px;
            object-fit: contain;
        }

        .product-card .card-body {
            padding: 12px;
        }

        .product-name {
            font-size: 15px;
            font-weight: 600;
            margin: 0;
            overflow-wrap: anywhere;
        }

        .product-price {
            font-size: 14px;
            font-weight: bold;
            white-space: nowrap;
        }

        .product-unit {
            font-size: 12px;
            color: #827582;
        }

        .btn-add {
            display: block;
            width: 100%;
            padding: 9px;
            border: none;
            border-radius: 22px;
            background-color: #39cf91;
            color: #173d2c;
            font-size: 14px;
            font-weight: bold;
        }

        .btn-add:hover {
            background-color: #27b77b;
            color: #173d2c;
        }

        /* Modal */
        .modal-content {
            border: none;
            border-radius: 18px;
            overflow: hidden;
        }

        .modal-header {
            background-color: #f6e4ef;
        }

        .modal-body {
            padding: 60px;
        }

        .modal-product-image {
            width: 125px;
            height: 115px;
            object-fit: contain;
        }

        .form-control {
            font-size: 14px;
            padding: 10px;
        }

        /* About and contact */
        .info-section {
            padding: 35px 15px;
            text-align: center;
        }

        .info-section h2 {
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 14px;
        }

        .info-section p {
            max-width: 700px;
            margin: 0 auto 12px;
            font-size: 30px;
            line-height: 1.7;
        }

        #about {
            background-color: #fff8fc;
            margin-top: 40px;
        }

        #contact {
            background-color: #f6e4ef;
        }

        .info-section a {
            color: #26764f;
        }

        /* Footer */
        footer {
            background-color: #493545;
            color: white;
            text-align: center;
            padding: 22px 10px;
            font-size: 18px;
        }

        footer a {
            color: #f9d9ec;
            text-decoration: none;
        }

        @media (max-width: 575px) {
            .navbar-brand {
                font-size: 18px;
            }

            .product-image {
                height: 135px;
            }

            .page-heading {
                padding-top: 22px;
            }
        }
    </style>
</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">

        <a class="navbar-brand" href="index.php">
            <img src="images/logo.png" alt="Palengke Kiosk Logo">
            <span>Palengke Kiosk</span>
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact Us</a>
                </li>
            </ul>
        </div>

    </div>
</nav>

<main>
    <div class="container">

        <div class="page-heading">
            <h1>Palengke Kiosk</h1>
            <p>Fresh and affordable fruits and vegetables for everyone.</p>
        </div>

        <?php if (isset($_GET["order"]) && $_GET["order"] === "success"): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Your order has been placed successfully!
                <button type="button" class="btn-close"
                    data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (isset($_GET["order"]) && $_GET["order"] === "failed"): ?>
            <div class="alert alert-danger" role="alert">
                Your order could not be placed. Please check your details and try again.
            </div>
        <?php endif; ?>

        <div class="row g-3 g-md-4 pb-4">

            <?php while ($row = $result->fetch_assoc()): ?>

                <?php
                    $productId = (int)$row["Productid"];
                    $fruit = $row["Fruit"];
                    $price = (float)$row["Price"];
                    $unit = $row["Units"] ?? "";
                    $image = trim((string)$row["Image"]);

                    // Supports image values with or without extensions.
                    if (!preg_match('/\.(png|jpe?g|webp)$/i', $image)) {
                        $image .= ".png";
                    }
                ?>

                <div class="col-6 col-md-4 col-lg-3">

                    <div class="card product-card">

                        <img
                            src="images/<?= e($image) ?>"
                            alt="<?= e($fruit) ?>"
                            class="product-image"
                            loading="lazy"
                        >

                        <div class="card-body d-flex flex-column">

                            <div class="d-flex justify-content-between align-items-start gap-2 mb-3">
                                <div>
                                    <h2 class="product-name"><?= e($fruit) ?></h2>

                                    <?php if ($unit !== ""): ?>
                                        <span class="product-unit">
                                            Per <?= e($unit) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <span class="product-price">
                                    ₱<?= number_format($price, 2) ?>
                                </span>
                            </div>

                            <button
                                type="button"
                                class="btn-add mt-auto"
                                data-bs-toggle="modal"
                                data-bs-target="#product-<?= $productId ?>"
                            >
                                Add to Cart
                            </button>

                        </div>
                    </div>

                </div>

                <!-- Product Order Modal -->
                <div
                    class="modal fade"
                    id="product-<?= $productId ?>"
                    tabindex="-1"
                    aria-labelledby="title-<?= $productId ?>"
                    aria-hidden="true"
                >
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h2 class="modal-title fs-5"
                                    id="title-<?= $productId ?>">
                                    Order Product
                                </h2>

                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"
                                ></button>
                            </div>

                            <div class="modal-body">

                                <div class="text-center mb-4">
                                    <img
                                        src="images/<?= e($image) ?>"
                                        alt="<?= e($fruit) ?>"
                                        class="modal-product-image"
                                    >

                                    <h3 class="h5 mt-2"><?= e($fruit) ?></h3>

                                    <p>
                                        ₱<?= number_format($price, 2) ?>
                                        <?php if ($unit !== ""): ?>
                                            / <?= e($unit) ?>
                                        <?php endif; ?>
                                    </p>
                                </div>

                                <form action="insert.php" method="POST">

                                    <input
                                        type="hidden"
                                        name="product_id"
                                        value="<?= $productId ?>"
                                    >

                                    <div class="mb-3">
                                        <label for="qty-<?= $productId ?>"
                                            class="form-label">
                                            Quantity
                                        </label>

                                        <input
                                            type="number"
                                            id="qty-<?= $productId ?>"
                                            name="Qty"
                                            class="form-control"
                                            min="1"
                                            step="1"
                                            required
                                        >
                                    </div>

                                    <div class="mb-3">
                                        <label for="user-<?= $productId ?>"
                                            class="form-label">
                                            Buyer's Name
                                        </label>

                                        <input
                                            type="text"
                                            id="user-<?= $productId ?>"
                                            name="User"
                                            class="form-control"
                                            maxlength="255"
                                            required
                                        >
                                    </div>

                                    <div class="mb-3">
                                        <label for="contact-<?= $productId ?>"
                                            class="form-label">
                                            Mobile Number
                                        </label>

                                        <input
                                            type="tel"
                                            id="contact-<?= $productId ?>"
                                            name="Contact"
                                            class="form-control"
                                            maxlength="20"
                                            placeholder="09XXXXXXXXX"
                                            required
                                        >
                                    </div>

                                    <button type="submit" class="btn-add">
                                        Submit Order
                                    </button>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            <?php endwhile; ?>

        </div>
    </div>

    <section id="about" class="info-section">
        <div class="container">
            <h2>About Us</h2>
            <p>
                Palengke Kiosk is your local marketplace where convenience
                meets community. We bring fresh and affordable goods from
                the market closer to you.
            </p>
        </div>
    </section>

    <section id="contact" class="info-section">
        <div class="container">
            <h2>Contact Us</h2>
            <p>Have questions or feedback? We'd love to hear from you!</p>
            <p>
                Email:
                <a href="mailto:contact@palengkekiosk.com">
                    contact@palengkekiosk.com
                </a>
            </p>
            <p>
                Phone:
                <a href="tel:+639123456789">+63 912 345 6789</a>
            </p>
        </div>
    </section>
</main>

<footer>
    <div class="container">
        <p class="mb-2">
            &copy; <?= date("Y") ?> Palengke Kiosk. All Rights Reserved.
        </p>
        <a href="#about">About Us</a>
        <span class="mx-2">|</span>
        <a href="#contact">Contact Us</a>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
