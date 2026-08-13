<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; background:#f4f5f7; padding:24px;">
    <div style="max-width:500px; margin:0 auto; background:#ffffff; border-radius:8px; padding:32px;">
        <h2 style="color:#1E2A78;">Welcome to BU E-Logbook</h2>

        <p>Hi {{ $user->name }},</p>

        <p>An account has been created for you on the BU E-Logbook system as a
            <strong>{{ $user->getRoleNames()->first() }}</strong>.</p>

        <p><strong>Email:</strong> {{ $user->email }}<br>
           <strong>Temporary Password:</strong> {{ $password }}</p>

        <p style="margin:24px 0;">
            <a href="{{ route('login') }}"
               style="background:linear-gradient(to right,#FF9F1C,#0EA5B7); color:#ffffff; padding:10px 20px; border-radius:6px; text-decoration:none; font-weight:bold;">
                Log In Now
            </a>
        </p>

        <p>We recommend changing your password after your first login.</p>

        <p>Thanks,<br>{{ config('app.name') }}</p>
    </div>
</body>
</html>