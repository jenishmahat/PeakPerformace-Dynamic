<?php
include 'auth.php'; 
requireRole('admin'); 
$page_title = "Manage Activities - Peak Performance"; 
include 'header.php'; 
include 'db.php';    

$message = ''; 

$activity_id = '';
$title = '';
$description = '';
$activity_date = '';
$image_url = '';

if (isset($_POST['save'])) {
    $activity_id = filter_var($_POST['activity_id'], FILTER_VALIDATE_INT);
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $activity_date = $_POST['activity_date'];
    $image_url = trim($_POST['image_url']);

    if (empty($title) || empty($description) || empty($activity_date) || empty($image_url)) {
        $message = "<p style='color:red;'>Error: All fields are required.</p>";
    } elseif (!strtotime($activity_date)) {
        $message = "<p style='color:red;'>Error: Invalid date format.</p>";
    } else {
        if ($activity_id) {
            try {
                $stmt = $pdo->prepare("UPDATE activities SET title = :title, description = :description, activity_date = :activity_date, image_url = :image_url WHERE id = :id");
                $stmt->execute([
                    'title' => $title,
                    'description' => $description,
                    'activity_date' => $activity_date,
                    'image_url' => $image_url,
                    'id' => $activity_id
                ]);
                $message = "<p style='color:green;'>Activity updated successfully!</p>";
                $activity_id = $title = $description = $activity_date = $image_url = '';
            } catch (PDOException $e) {
                $message = "<p style='color:red;'>Error updating activity: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        } else {
            try {
                $stmt = $pdo->prepare("INSERT INTO activities (title, description, activity_date, image_url) VALUES (:title, :description, :activity_date, :image_url)");
                $stmt->execute([
                    'title' => $title,
                    'description' => $description,
                    'activity_date' => $activity_date,
                    'image_url' => $image_url
                ]);
                $message = "<p style='color:green;'>Activity added successfully!</p>";
                $title = $description = $activity_date = $image_url = '';
            } catch (PDOException $e) {
                $message = "<p style='color:red;'>Error adding activity: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        }
    }
}

if (isset($_GET['delete'])) {
    $activity_id_to_delete = filter_var($_GET['delete'], FILTER_VALIDATE_INT);
    if ($activity_id_to_delete === false || $activity_id_to_delete === null) {
        $message = "<p style='color:red;'>Error: Invalid activity ID for deletion.</p>";
    } else {
        try {
            $stmt = $pdo->prepare("DELETE FROM activities WHERE id = :id");
            $stmt->execute(['id' => $activity_id_to_delete]);
            $message = "<p style='color:green;'>Activity deleted successfully!</p>";
        } catch (PDOException $e) {
            $message = "<p style='color:red;'>Error deleting activity: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
}

if (isset($_GET['edit'])) {
    $activity_id_to_edit = filter_var($_GET['edit'], FILTER_VALIDATE_INT);
    if ($activity_id_to_edit === false || $activity_id_to_edit === null) {
        $message = "<p style='color:red;'>Error: Invalid activity ID for editing.</p>";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM activities WHERE id = :id");
            $stmt->execute(['id' => $activity_id_to_edit]);
            $activity_to_edit = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($activity_to_edit) {
                $activity_id = $activity_to_edit['id'];
                $title = $activity_to_edit['title'];
                $description = $activity_to_edit['description'];
                $activity_date = $activity_to_edit['activity_date'];
                $image_url = $activity_to_edit['image_url'];
            } else {
                $message = "<p style='color:red;'>Activity not found.</p>";
            }
        } catch (PDOException $e) {
            $message = "<p style='color:red;'>Error fetching activity for edit: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
}

$activities = $pdo->query("SELECT * FROM activities ORDER BY activity_date DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container py-4">
    <h2>Manage Activities</h2>

    <?php if ($message): ?>
        <div class="alert <?= strpos($message, 'Error') !== false ? 'alert-danger' : 'alert-success' ?> mt-3" role="alert">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <div class="card shadow p-4 mb-4">
        <h3><?= $activity_id ? 'Edit Activity' : 'Add New Activity' ?></h3>
        <form method="POST">
            <input type="hidden" name="activity_id" value="<?= htmlspecialchars($activity_id) ?>">

            <div class="form-group mb-3">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" class="form-control" placeholder="Activity Title" value="<?= htmlspecialchars($title) ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="description">Description:</label>
                <textarea id="description" name="description" class="form-control" placeholder="Activity Description" rows="4" required><?= htmlspecialchars($description) ?></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="activity_date">Date:</label>
                <input type="date" id="activity_date" name="activity_date" class="form-control" value="<?= htmlspecialchars($activity_date) ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="image_url">Image URL:</label>
                <input type="text" id="image_url" name="image_url" class="form-control" placeholder="e.g., images/yoga.jpg" value="<?= htmlspecialchars($image_url) ?>" required>
                <small class="form-text text-muted">Provide the path to the image for this activity.</small>
            </div>
            <button type="submit" name="save" class="btn btn-primary"><?= $activity_id ? 'Update Activity' : 'Add Activity' ?></button>
            <?php if ($activity_id): ?>
                <a href="admin_activities.php" class="btn btn-secondary ms-2">Cancel Edit</a>
            <?php endif; ?>
        </form>
    </div>

    <h3 class="mt-5">Existing Activities</h3>
    <?php if (empty($activities)): ?>
        <p>No activities found. Add a new activity above.</p>
    <?php else: ?>
        <table class="table table-bordered table-striped mt-3">
            <thead class="table-dark">
                <tr>
                    <th>S.N.</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $sn = 1; ?>
                <?php foreach ($activities as $a): ?>
                <tr>
                    <td><?= $sn++ ?></td>
                    <td><?= htmlspecialchars($a['title']) ?></td>
                    <td><?= nl2br(htmlspecialchars($a['description'])) ?></td>
                    <td><?= htmlspecialchars($a['activity_date']) ?></td>
                    <td>
                        <?php if (!empty($a['image_url'])): ?>
                            <img src="<?= htmlspecialchars($a['image_url']) ?>" alt="Activity Image" style="width: 100px; height: auto; border-radius: 5px;">
                        <?php else: ?>
                            No Image
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="?edit=<?= htmlspecialchars($a['id']) ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="?delete=<?= htmlspecialchars($a['id']) ?>"
                               onclick="return confirm('Are you sure you want to delete the activity: \'<?= htmlspecialchars($a['title']) ?>\'?')"
                               class="btn btn-sm btn-danger">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
