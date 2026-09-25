<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Password Reset | Maha Construction</title>
    <style>
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; outline: none; text-decoration: none; }
        body { margin: 0; padding: 0; width: 100% !important; background-color: #050B14; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #050B14; color: #F0EBE0;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #050B14; table-layout: fixed;">
        <tr>
            <td align="center" style="padding: 40px 15px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 580px; background-color: #0B132B; border: 1px solid rgba(212, 175, 55, 0.4); border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6);">
                    
                    <!-- Header -->
                    <tr>
                        <td align="center" style="padding: 35px 30px 25px; border-bottom: 1px solid rgba(212, 175, 55, 0.2); background: linear-gradient(180deg, rgba(212, 175, 55, 0.1) 0%, transparent 100%);">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">
                                        <div style="font-size: 22px; font-weight: 800; letter-spacing: 2px; color: #FFFFFF; font-family: 'Montserrat', Arial, sans-serif;">
                                            MAHA CONSTRUCTIONS
                                        </div>
                                        <div style="font-size: 11px; font-weight: 700; letter-spacing: 3px; color: #D4AF37; text-transform: uppercase; margin-top: 6px;">
                                            Password Reset Request
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Main Body -->
                    <tr>
                        <td style="padding: 35px 35px 25px; color: #F0EBE0; font-size: 15px; line-height: 1.6;">
                            <p style="margin: 0 0 16px 0; font-size: 16px; color: #FFFFFF;">
                                Hello,
                            </p>
                            <p style="margin: 0 0 24px 0; color: #C5CEE0; font-size: 15px; line-height: 1.6;">
                                We received a request to reset your Maha Construction Admin password.
                            </p>

                            <!-- OTP Box -->
                            <div style="margin: 25px 0; padding: 20px; background-color: #050B14; border: 1px solid rgba(212, 175, 55, 0.35); border-radius: 12px; text-align: center;">
                                <div style="font-size: 12px; font-weight: 700; letter-spacing: 1.5px; color: #94A3B8; text-transform: uppercase; margin-bottom: 8px;">
                                    Your OTP is:
                                </div>
                                <div style="font-size: 34px; font-weight: 800; letter-spacing: 8px; color: #D4AF37; font-family: 'Courier New', Courier, monospace;">
                                    {{ $otp }}
                                </div>
                            </div>

                            <p style="margin: 25px 0 15px 0; color: #C5CEE0; font-size: 14px; text-align: center;">
                                Or reset your password directly using the button below:
                            </p>

                            <!-- Reset Button -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 15px 0 25px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $resetUrl }}" target="_blank" style="display: inline-block; padding: 14px 34px; background: linear-gradient(135deg, #D4AF37 0%, #B89228 100%); color: #050B14; font-size: 14px; font-weight: 800; letter-spacing: 1.5px; text-decoration: none; border-radius: 10px; box-shadow: 0 4px 15px rgba(212, 175, 55, 0.35); text-transform: uppercase;">
                                            RESET PASSWORD
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Fallback Plain-Text URL -->
                            <div style="margin: 25px 0 20px 0; padding-top: 20px; border-top: 1px solid rgba(148, 163, 184, 0.15); font-size: 12px; color: #94A3B8; line-height: 1.5;">
                                If you're having trouble clicking the button, copy and paste this URL into your web browser:<br>
                                <a href="{{ $resetUrl }}" style="color: #D4AF37; word-break: break-all; text-decoration: underline;">{{ $resetUrl }}</a>
                            </div>

                            <!-- Expiry & Notice -->
                            <p style="margin: 20px 0 12px 0; font-size: 13px; color: #E2E8F0;">
                                <strong>Notice:</strong> This reset link will expire after 15 minutes.
                            </p>
                            <p style="margin: 0 0 25px 0; font-size: 13px; color: #94A3B8;">
                                If you did not request this password reset, please ignore this email.
                            </p>

                            <!-- Sign off -->
                            <p style="margin: 20px 0 0 0; font-size: 14px; color: #D4AF37; font-weight: 700;">
                                Maha Construction
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="padding: 20px; background-color: #080E20; border-top: 1px solid rgba(212, 175, 55, 0.15); font-size: 11px; color: #64748B;">
                            This is an automated security communication from Maha Construction Luxury Platform.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
