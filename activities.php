<?php
$page_title = "Activities - Peak Performance";
include 'auth.php'; 
include 'header.php'; 
include 'db.php';     
?>

<section class="hero-banner">
    <div class="overlay"></div>
    <div class="hero-content">
        <h1>Our Activities</h1>
        <p>Explore a variety of programs to stay active, energized, and connected.</p>
    </div>
</section>

<section class="activities-list container mt-5">
    <div class="row">
        <?php
        try {
            // Fetch activities from the database
            $stmt = $pdo->query("SELECT * FROM activities ORDER BY activity_date DESC");
            $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($activities)) {
                echo '<div class="col-12"><p class="text-center">No activities found at the moment. Please check back later!</p></div>';
            } else {
                foreach ($activities as $activity):
                    ?>
                    <div class="col-lg-3 col-md-6 mb-4"> <div class="activity-card">
                            <div class="card-image-container">
                                <img src="<?= htmlspecialchars($activity['image_url']) ?>" alt="<?= htmlspecialchars($activity['title']) ?>" class="card-img-top">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($activity['title']) ?></h5>
                                <p class="card-text description-full"><?= nl2br(htmlspecialchars($activity['description'])) ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                endforeach;
            }
        } catch (PDOException $e) {
            echo '<div class="col-12"><p style="color:red;">Error fetching activities: ' . htmlspecialchars($e->getMessage()) . '</p></div>';
        }
        ?>
    </div>
</section>

<?php include 'footer.php'; ?>