<?php
session_start();

// Simple password authentication (same as reviews admin)
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

// Path to the pricing JSON file
$pricingFile = __DIR__ . '/pricing-data.json';

// Default pricing data
$defaultPricing = [
    ['hours' => 12, 'individual' => 840, 'group' => 444],
    ['hours' => 16, 'individual' => 960, 'group' => 576],
    ['hours' => 26, 'individual' => 1300, 'group' => 728],
    ['hours' => 40, 'individual' => 1720, 'group' => 1040],
    ['hours' => 60, 'individual' => 2400, 'group' => 1500],
    ['hours' => 80, 'individual' => 3040, 'group' => 1880],
    ['hours' => 100, 'individual' => 3700, 'group' => 2250],
];

// Load existing pricing or create default
if (!file_exists($pricingFile)) {
    file_put_contents($pricingFile, json_encode($defaultPricing, JSON_PRETTY_PRINT));
}

$pricing = json_decode(file_get_contents($pricingFile), true);

// Handle save
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $newPricing = [];
    
    foreach ($_POST['hours'] as $index => $hours) {
        $newPricing[] = [
            'hours' => intval($hours),
            'individual' => intval($_POST['individual'][$index]),
            'group' => intval($_POST['group'][$index])
        ];
    }
    
    file_put_contents($pricingFile, json_encode($newPricing, JSON_PRETTY_PRINT));
    $pricing = $newPricing;
    $message = '✅ Prices updated successfully!';
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: manage-pricing.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing Management - Beltralace</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; }
        .header {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 { color: #333; font-size: 28px; }
        .nav { display: flex; gap: 15px; }
        .nav a {
            padding: 10px 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }
        .nav a.logout { background: #dc3545; }
        .nav a:hover { opacity: 0.9; }
        .section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .message {
            padding: 15px;
            background: #d4edda;
            color: #155724;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        .pricing-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .pricing-table th {
            background: #667eea;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }
        .pricing-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        .pricing-table tr:hover {
            background: #f8f9ff;
        }
        .pricing-table input {
            width: 100%;
            padding: 8px 12px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
        }
        .pricing-table input:focus {
            outline: none;
            border-color: #667eea;
        }
        .calculated {
            color: #666;
            font-size: 13px;
            margin-top: 5px;
        }
        .save-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
        }
        .save-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }
        .instructions {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .instructions h3 {
            margin-bottom: 10px;
            color: #856404;
        }
        .instructions ul {
            margin-left: 20px;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💰 Pricing Management</h1>
            <div class="nav">
                <a href="manage-reviews.php">📝 Reviews</a>
                <a href="?logout=1" class="logout" onclick="return confirm('Logout?')">Logout</a>
            </div>
        </div>
        
        <?php if ($message): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>
        
        <div class="section">
            <div class="instructions">
                <h3>📋 Instructions:</h3>
                <ul>
                    <li>Edit the prices in the table below</li>
                    <li>The "Per Hour" rates are automatically calculated</li>
                    <li>Click "Save Changes" to update the pricing on your website</li>
                    <li>Changes will be reflected immediately on the pricing page</li>
                </ul>
            </div>
            
            <form method="POST">
                <table class="pricing-table">
                    <thead>
                        <tr>
                            <th>Hours</th>
                            <th>Individual Price ($)</th>
                            <th>Group Price ($)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pricing as $index => $tier): ?>
                            <tr>
                                <td>
                                    <input type="number" name="hours[]" value="<?= $tier['hours'] ?>" required> Hours
                                </td>
                                <td>
                                    <input type="number" name="individual[]" value="<?= $tier['individual'] ?>" required>
                                    <div class="calculated">
                                        @ $<?= number_format($tier['individual'] / $tier['hours'], 2) ?>/hour
                                    </div>
                                </td>
                                <td>
                                    <input type="number" name="group[]" value="<?= $tier['group'] ?>" required>
                                    <div class="calculated">
                                        @ $<?= number_format($tier['group'] / $tier['hours'], 2) ?>/hour
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <button type="submit" name="save" class="save-btn">
                    💾 Save Changes
                </button>
            </form>
        </div>
    </div>
</body>
</html>
