<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Activation</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f7;">

    <table width="100%"cellpadding="0" cellspacing="0" style="background-color: #f4f4f7; padding: 20px;">
        <tr>
            <td>
                <!-- Outer Container -->
                <table width="100%" max-width="600px" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="padding: 20px; background-color: #4CAF50; color: #ffffff;">
                            <h1 style="margin: 0; font-size: 24px;">Activate Your Account</h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 30px 20px; color: #333333;">
                            <p style="font-size: 18px; margin: 0;">Hello, <strong>{{ $user->email }}</strong></p>
                            <p style="font-size: 16px; color: #666666; line-height: 1.6;">
                                Thank you for registering! To complete your registration, please click the button below to activate your account.
                            </p>
                            <p style="text-align: center; padding: 20px;">
                                <a href="{{ $activationLink }}" style="background-color: #4CAF50; color: #ffffff; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-size: 16px; font-weight: bold;">
                                    Activate Account
                                </a>
                            </p>
                            <p style="font-size: 14px; color: #999999; text-align: center;">
                                Or copy and paste the link below into your browser if the button doesn't work:
                            </p>
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="background-color: #f4f4f7; padding: 20px; text-align: center; color: #999999; font-size: 12px;">
                            <p style="margin: 0;">If you did not request this, please ignore this email.</p>
                            <p style="margin: 0;">&copy; 2023 Your Company. All rights reserved.</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
