<?php
session_start();

// Simple password authentication
$admin_password = 'beltralace2026'; // CHANGE THIS!

if (!isset($_SESSION['admin_auth'])) {
    if (isset($_POST['password'])) {
        if ($_POST['password'] === $admin_password) {
            $_SESSION['admin_auth'] = true;
        } else {
            $error = 'Invalid password';
        }
    }
    
    if (!isset($_SESSION['admin_auth'])) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Admin Login</title>
            <style>
                body { font-family: Arial; background: #f5f5f5; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
                .login { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 300px; }
                h2 { margin-top: 0; text-align: center; }
                input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
                button { width: 100%; padding: 12px; background: #667eea; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
                button:hover { background: #5568d3; }
                .error { color: red; font-size: 14px; margin-top: 10px; }
            </style>
        </head>
        <body>
            <div class="login">
                <h2>🔒 Admin Login</h2>
                <form method="POST">
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit">Login</button>
                    <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
                </form>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: manage-reviews.php');
    exit;
}

// Database connection
$host = 'localhost';
$dbname = 'asqwyaug_db';
$username = 'asqwyaug_root';
$password = 'alabaster34!';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle actions
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $reviewId = intval($_POST['review_id'] ?? 0);
    
    if ($reviewId > 0) {
        switch ($_POST['action']) {
            case 'approve':
                $stmt = $pdo->prepare("UPDATE reviews SET is_published = 1, updated_at = NOW() WHERE id = ?");
                $stmt->execute([$reviewId]);
                $message = "Review approved!";
                break;
            case 'unpublish':
                $stmt = $pdo->prepare("UPDATE reviews SET is_published = 0, updated_at = NOW() WHERE id = ?");
                $stmt->execute([$reviewId]);
                $message = "Review unpublished!";
                break;
            case 'delete':
                $stmt = $pdo->prepare("DELETE FROM reviews WHERE id = ?");
                $stmt->execute([$reviewId]);
                $message = "Review deleted!";
                break;
        }
    }
}

// Fetch all reviews
$stmt = $pdo->query("SELECT * FROM reviews ORDER BY is_published ASC, created_at DESC");
$allReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
$pending = array_filter($allReviews, fn($r) => $r['is_published'] == 0);
$published = array_filter($allReviews, fn($r) => $r['is_published'] == 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Management - Beltralace</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        .header { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { color: #333; font-size: 28px; }
        .logout-btn { padding: 10px 20px; background: #dc3545; color: white; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; }
        .stats { display: flex; gap: 20px; margin-top: 20px; }
        .stat-box { flex: 1; padding: 20px; border-radius: 8px; color: white; }
        .stat-box.pending { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .stat-box.published { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .stat-box .number { font-size: 36px; font-weight: bold; margin-bottom: 5px; }
        .stat-box .label { font-size: 14px; opacity: 0.9; }
        .section { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 30px; }
        .section h2 { color: #333; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #667eea; }
        .review-card { border: 2px solid #e0e0e0; border-radius: 8px; padding: 20px; margin-bottom: 20px; }
        .review-card.pending { border-color: #f5576c; background: #fff5f7; }
        .reviewer-name { font-size: 18px; font-weight: 600; color: #333; margin-bottom: 5px; }
        .reviewer-email { color: #666; font-size: 14px; margin-bottom: 10px; }
        .rating { color: #ffc107; font-size: 20px; margin: 10px 0; }
        .review-text { color: #555; line-height: 1.6; margin: 15px 0; }
        .actions { display: flex; gap: 10px; margin-top: 15px; }
        .btn { padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 600; }
        .btn-approve { background: #28a745; color: white; }
        .btn-reject { background: #dc3545; color: white; }
        .btn-unpublish { background: #ffc107; color: #333; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; margin-left: 10px; }
        .badge-pending { background: #f5576c; color: white; }
        .badge-published { background: #28a745; color: white; }
        .message { padding: 15px; background: #d4edda; color: #155724; border-radius: 8px; margin-bottom: 20px; }
        .empty { text-align: center; padding: 40px; color: #999; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>📝 Review Management</h1>
                <div class="stats">
                    <div class="stat-box pending">
                        <div class="number"><?= count($pending) ?></div>
                        <div class="label">Pending</div>
                    </div>
                    <div class="stat-box published">
                        <div class="number"><?= count($published) ?></div>
                        <div class="label">Published</div>
                    </div>
                </div>
            </div>
            <a href="?logout=1" class="logout-btn" onclick="return confirm('Logout?')">Logout</a>
        </div>
        
        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        
        <div class="section">
            <h2>⏳ Pending Reviews (<?= count($pending) ?>)</h2>
            <?php if (empty($pending)): ?>
                <div class="empty">✅ No pending reviews!</div>
            <?php else: ?>
                <?php foreach ($pending as $review): ?>
                    <div class="review-card pending">
                        <div class="reviewer-name">
                            <?= htmlspecialchars($review['name']) ?>
                            <span class="badge badge-pending">PENDING</span>
                        </div>
                        <?php if ($review['email']): ?>
                            <div class="reviewer-email"><?= htmlspecialchars($review['email']) ?></div>
                        <?php endif; ?>
                        <div class="rating">
                            <?= str_repeat('★', $review['rating'] ?? 5) ?>
                            <?= str_repeat('☆', 5 - ($review['rating'] ?? 5)) ?>
                        </div>
                        <div class="review-text"><?= nl2br(htmlspecialchars($review['review'])) ?></div>
                        <div class="actions">
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="review_id" value="<?= $review['id'] ?>">
                                <input type="hidden" name="action" value="approve">
                                <button type="submit" class="btn btn-approve" onclick="return confirm('Approve?')">✓ Approve</button>
                            </form>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="review_id" value="<?= $review['id'] ?>">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" class="btn btn-reject" onclick="return confirm('Delete?')">✗ Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <div class="section">
            <h2>✅ Published Reviews (<?= count($published) ?>)</h2>
            <?php if (empty($published)): ?>
                <div class="empty">No published reviews yet.</div>
            <?php else: ?>
                <?php foreach ($published as $review): ?>
                    <div class="review-card">
                        <div class="reviewer-name">
                            <?= htmlspecialchars($review['name']) ?>
                            <span class="badge badge-published">PUBLISHED</span>
                        </div>
                        <?php if ($review['email']): ?>
                            <div class="reviewer-email"><?= htmlspecialchars($review['email']) ?></div>
                        <?php endif; ?>
                        <div class="rating">
                            <?= str_repeat('★', $review['rating'] ?? 5) ?>
                            <?= str_repeat('☆', 5 - ($review['rating'] ?? 5)) ?>
                        </div>
                        <div class="review-text"><?= nl2br(htmlspecialchars($review['review'])) ?></div>
                        <div class="actions">
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="review_id" value="<?= $review['id'] ?>">
                                <input type="hidden" name="action" value="unpublish">
                                <button type="submit" class="btn btn-unpublish" onclick="return confirm('Unpublish?')">↩ Unpublish</button>
                            </form>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="review_id" value="<?= $review['id'] ?>">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" class="btn btn-reject" onclick="return confirm('Delete?')">✗ Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
