<?php 
    include_once dirname(__DIR__, 2) .'/config/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>%subject%</title>
    <style>
        /* Global Styles */
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }
        .email-wrapper{
            width: 100%;
            background-color: #f4f4f4;
        }
        /* Container */
        .email-container {
            max-width: 650px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        .email-header {
            padding: 20px;
            text-align: center;
        }

        .email-header h1 {
            /* margin: 10px 0 0; */
            font-size: 24px;
        }

        .email-logo {
            max-width: 100px;
            height: auto;
            display: block;
            margin: 0 auto 10px;
        }

        /* Content */
        .email-content {
            padding: 20px;
            border-top: #333 0.1px solid;
        }

        .email-content h2 {
            margin-top: 0;
            color: <?php echo BRANDCOLOR_PRIMARY; ?>;
        }

        /* Footer */
        .email-footer {
            /* background-color: <?php echo BRANDCOLOR_PRIMARY; ?>; */
            text-align: center;
            padding: 15px;
            /* color: #ffffff; */
            font-size: 12px;
            border-top: #333 0.1px solid;
        }

        .email-footer a {
            color: inherit;
            text-decoration: none;
        }

        /* Responsive */
        @media screen and (max-width: 600px) {
            .email-content, .email-header, .email-footer {
                padding: 15px;
            }

            .email-header h1 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <table class="email-container">
            <!-- Header -->
            <tr>
                <td class="email-header">
                    <img src="https://www.beltralace.com/frontend/views/assets/images/logo.png" alt="<?php echo SITETITLE; ?> Logo" class="email-logo">
                </td>
            </tr>

            <!-- Content -->
            <tr>
                <td class="email-content">
                    %content%
                </td>
            </tr>

            <!-- Footer -->
            <tr>
                <td class="email-footer">
                    &copy; <?php echo date('Y'); ?> <a href="<?php echo DIR; ?>"><?php echo SITETITLE; ?></a>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
