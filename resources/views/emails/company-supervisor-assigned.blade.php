<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8fafc; padding: 24px; margin: 0;">
    <div style="max-width: 560px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden;">
        <div style="background: linear-gradient(to right, #1E2A78, #0EA5B7); padding: 20px 24px;">
            <h1 style="color: #ffffff; font-size: 18px; margin: 0;">BU E-Logbook</h1>
        </div>
        <div style="padding: 24px; color: #1e293b;">
            <p style="margin-top: 0;">Hello {{ $supervisor->name }},</p>

            <p>
                You have been assigned as the <strong>company supervisor</strong> for
                <strong>{{ $student->name }}</strong> on the BU E-Logbook system.
            </p>

            <p>
                You can now log in to review their daily internship reports and, once all
                reports are reviewed, complete their evaluation.
            </p>

            <p style="margin-top: 24px;">
                <a href="{{ route('login') }}"
                   style="background: linear-gradient(to right, #FF9F1C, #FF7A1C); color: #ffffff; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: bold; display: inline-block;">
                    Log In
                </a>
            </p>

            <p style="margin-top: 24px; font-size: 13px; color: #64748b;">
                If you were not expecting this, you can safely ignore this email.
            </p>
        </div>
    </div>
</body>
</html>