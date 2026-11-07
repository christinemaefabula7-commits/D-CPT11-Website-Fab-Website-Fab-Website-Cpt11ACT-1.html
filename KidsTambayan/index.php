<?php
require_once __DIR__ . "/db.php";
$result = $conn->query("SELECT * FROM cartoonslist ORDER BY showsID ASC");
function e($val) { return htmlspecialchars((string)$val, ENT_QUOTES, "UTF-8"); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YoungAtHeartZ - Kids Tambayan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #121212; color: #fff; font-family: Arial, sans-serif; }
        .navbar { background: #000 !important; border-bottom: 2px solid #ff2a5f; padding: 10px 20px; }
        .navbar-brand, .nav-link { color: #fff !important; font-weight: bold; }
        .card { background: #1a1a1a; border: 1px solid #333; border-radius: 12px; }
        .btn-red { background: #ff2a5f; color: #fff; font-weight: bold; border: none; border-radius: 20px; }
        .btn-red:hover { background: #e02453; color: #fff; }
        .section-title { color: #ffde59; font-weight: bold; }
        .section-sub { color: #fff; max-width: 750px; margin: 0 auto; line-height: 1.6; }
        footer { border-top: 3px solid #ff2a5f; background: #080808; margin-top: 50px; padding: 25px 0; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">YoungAtHeartZ</a>
        <div class="navbar-nav ms-auto flex-row gap-3">
            <a class="nav-link" href="index.php">Home</a>
            <a class="nav-link" href="#about">About Us</a>
            <a class="nav-link" href="#contact">Contact Us</a>
        </div>
    </div>
</nav>

<main class="container py-4">
    <div class="text-center mb-4">
        <h1 class="fw-bold" style="color: #ff2a5f;">Kids Tambayan</h1>
        <p class="text-white">Explore your favorite cartoons and animated movies, and add them to your watchlist!</p>
    </div>

    <?php if (isset($_GET["status"]) && $_GET["status"] === "success"): ?>
        <div class="alert alert-success bg-dark text-success border-success text-center">Successfully added to your Watchlist!</div>
    <?php elseif (isset($_GET["status"]) && $_GET["status"] === "failed"): ?>
        <div class="alert alert-danger bg-dark text-danger border-danger text-center">Failed to add to your Watchlist. Please try again.</div>
    <?php endif; ?>

    <!-- Responsive Cards Grid -->
    <div class="row g-2 justify-content-center">
        <?php while ($row = $result->fetch_assoc()): ?>
            <?php 
            $id = (int)$row["showsID"];
            $img = trim((string)($row["Images"] ?? ""));
            $image = (strpos($img, '.') !== false) ? $img : $img . ".jpg";
            ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card p-3 h-100 text-center d-flex flex-column">
                    <div style="height: 180px;" class="d-flex align-items-center justify-content-center bg-dark rounded mb-2">
                        <img src="images/<?= e($image) ?>" style="max-height: 160px; max-width: 100%; object-fit: contain;" onerror="this.src='https://via.placeholder.com/150/1a1a1a/ff2a5f?text=No+Image'">
                    </div>
                    <h5 class="fw-bold text-truncate mb-1"><?= e($row['Title']) ?></h5>
                    <p class="text-white-50 small text-truncate mb-3"><?= e($row['Genre']) ?></p>
                    <button class="btn btn-red w-100 mt-auto py-2" data-bs-toggle="modal" data-bs-target="#modal-<?= $id ?>">Add to Watchlist</button>
                </div>
            </div>

            <!-- Modal with WatchDate & Title input -->
            <div class="modal fade text-dark" id="modal-<?= $id ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content p-4 bg-dark text-white border border-secondary">
                        <div class="modal-header border-secondary">
                            <h5 class="fw-bold text-white">Add to Watchlist</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="images/<?= e($image) ?>" height="110" class="mb-3" onerror="this.src='https://via.placeholder.com/100/1a1a1a/ff2a5f?text=Cartoon'">
                            <h5 class="fw-bold"><?= e($row['Title']) ?></h5>
                            <p class="text-white-50 small mb-4"><?= e($row['Description']) ?></p>
                            
                            <form action="insert.php" method="POST">
                                <input type="hidden" name="shows_id" value="<?= $id ?>">
                                <input type="hidden" name="title" value="<?= e($row['Title']) ?>">
                                
                                <div class="mb-3 text-start">
                                    <label for="watch_date-<?= $id ?>" class="form-label text-white small fw-bold">Set Watch Date:</label>
                                    <input type="date" class="form-control bg-dark text-white border-secondary" id="watch_date-<?= $id ?>" name="watch_date" required>
                                </div>

                                <button type="submit" class="btn btn-red w-100 py-2">Save to Library</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Divider Line Above About Section -->
    <hr class="my-5 opacity-50" style="border-top: 2px solid #ff2a5f;">

    <!-- About Section -->
    <section id="about" class="text-center py-4">
        <h2 class="section-title mb-3">About YoungAtHeartZ</h2>
        <p class="section-sub">
            YoungAtHeartZ cherishes the uniqueness of the living cartoon era that will forever be our comfort zone to remember and go back to, whatever age we have. We are here to bring you close to your favorite cartoons back then without having to struggle searching online. In KidsTambayan, whether you're a kid or young at heart, you can easily access them all in one site. It inspires, connects generations, and brings back the purest magic of childhood memories.
        </p>
    </section>

    <!-- Divider Line Between About and Contact Us Section -->
    <hr class="my-5 opacity-50" style="border-top: 2px solid #ff2a5f;">

    <!-- Contact Section -->
    <section id="contact" class="text-center py-4">
        <h2 class="section-title mb-2">Contact Us</h2>
        <p class="section-sub mb-2">Have questions, feedback, or cartoon requests? We'd love to hear from you!</p>
        <p class="text-white fw-bold">Email: support@youngatheartz.com | Phone: +63 912 345 6789</p>
    </section>
</main>

<footer>
    <p class="mb-0 text-white text-center">&copy; <?= date("Y") ?> YoungAtHeartZ (Kids Tambayan). All Rights Reserved 2026.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Awtomatikong nililinis ang URL at inaalis ang alert pagkalipas ng 3 segundo
    if (window.history.replaceState) {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('status')) {
            setTimeout(function() {
                window.history.replaceState({}, document.title, window.location.pathname);
                const alertBox = document.querySelector('.alert');
                if (alertBox) {
                    alertBox.style.transition = "opacity 0.5s ease";
                    alertBox.style.opacity = "0";
                    setTimeout(() => alertBox.remove(), 500);
                }
            }, 3000);
        }
    }
</script>
</body>
</html>