<?php
session_start();

// Current password for verification
$current_password = 'beltralace2026';

$message = '';
$error = '';

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Verify current password
    if ($old_password !== $current_password) {
        $error = 'Current password is incorrect!';
    } elseif (strlen($new_password) < 8) {
        $error = 'New password must be at least 8 characters long!';
    } elseif ($new_password !== $confirm_password) {
        $error = 'New passwords do not match!';
    } else {
        // Update both files
        $review_file = __DIR__ . '/manage-reviews.php';
        $pricing_file = __DIR__ . '/manage-pricing.php';
        
        // Read and update review management file
        $review_content = file_get_contents($review_file);
        $review_content = str_replace(
            "\$admin_password = '$current_password';",
            "\$admin_password = '$new_password';",
            $review_content
        );
        file_put_contents($review_file, $review_content);
        
        // Read and update pricing management file
        $pricing_content = file_get_contents($pricing_file);
        $pricing_content = str_replace(
            "\$admin_password = '$current_password';",
            "\$admin_password = '$new_password';",
            $pricing_content
        );
        file_put_contents($pricing_file, $pricing_content);
        
        // Update this file's current password
        $self_content = file_get_contents(__FILE__);
        $self_content = str_replace(
            "\$current_password = '$current_password';",
            "\$current_password = '$new_password';",
            $self_content
        );
        file_put_contents(__FILE__, $self_content);
        
        $message = "✅ Password changed successfully! Your new password is: <strong>$new_password</strong>";
        $message .= "<br><br>📝 Please save this password somewhere safe!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Admin Password - Beltralace</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 500px;
            width: 100%;
        }
        h1 {
            color: #1a1a6e;
            margin-bottom: 10px;
            font-size: 28px;
            text-align: center;
        }
        .subtitle {
            color: #666;
            text-align: center;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }
        input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            transition: border-color 0.3s;
        }
        input:focus {
            outline: none;
            border-color: #667eea;
        }
        .password-hint {
            font-size: 12px;
            color: #999;
            margin-top: 5px;
        }
        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }
        button:hover {
            transform: translateY(-2px);
        }
        .message {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .info-box {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .info-box h3 {
            color: #856404;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .info-box ul {
            margin-left: 20px;
            color: #856404;
            font-size: 13px;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 Change Admin Password</h1>
        <p class="subtitle">Update passwords for Review & Pricing Management</p>
        
        <?php if ($message): ?>
            <div class="message success"><?= $message ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="message error">❌ <?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="old_password">Current Password</label>
                <input type="password" id="old_password" name="old_password" required>
            </div>
            
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" required minlength="8">
                <div class="password-hint">At least 8 characters</div>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required minlength="8">
            </div>
            
            <button type="submit">Change Password</button>
        </form>
        
        <div class="info-box">
            <h3>📋 What this changes:</h3>
            <ul>
                <li>Review Management password</li>
                <li>Pricing Management password</li>
                <li>Both will use the same new password</li>
            </ul>
        </div>
        
        <div class="back-link">
            <a href="manage-reviews.php">← Back to Review Management</a>
        </div>
    </div>
</body>
</html>
