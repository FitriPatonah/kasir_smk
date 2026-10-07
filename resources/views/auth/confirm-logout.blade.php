<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Keluar</title>
    <style>
        body { min-height: 100vh; margin: 0; background: #eef2f5; font-family: "Segoe UI", Arial, sans-serif; }
    </style>
</head>
<body>
    @php
        $logoutConfirmationAutoOpen = true;
        $logoutConfirmationInitialUrl = $logoutUrl;
        $logoutConfirmationCancelUrl = $dashboardUrl;
    @endphp
    @include('partials.logout-confirmation')
</body>
</html>