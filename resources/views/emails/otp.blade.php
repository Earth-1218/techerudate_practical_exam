<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            margin: auto;
        }
        .header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .otp {
            font-size: 20px;
            font-weight: bold;
            color: #4CAF50;
            margin-bottom: 20px;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">OTP Verification Code</div>
        
        <p>Hi {{ $user->name }},</p>

        <p>Your OTP verification code is:</p>

        <div class="otp">{{ $otp }}</div>

        <p>Use this code to complete your registration. The code will expire in 10 minutes.</p>

        <div class="footer">
            <p>If you did not request this, please ignore this email.</p>
        </div>
    </div>
</body>
</html>
