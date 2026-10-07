<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Akun Diperbarui</title>
</head>
<body style="margin:0;padding:0;background:#f4f6fa;font-family:Arial,Helvetica,sans-serif;color:#22314a;">
<div style="max-width:480px;margin:32px auto;background:#fff;border-radius:12px;overflow:hidden;border:1px solid #e1e8f1;">

    <div style="background:#1e3a5f;padding:20px 28px;">
        <span style="color:#fff;font-size:17px;font-weight:700;">{{ config('app.name') }}</span>
    </div>

    <div style="padding:28px;">
        <h2 style="margin:0 0 12px;font-size:18px;color:#1e3a5f;">Halo, {{ $user->name }} 👋</h2>

        <p style="font-size:14px;line-height:1.6;margin:0 0 16px;">
            Kami menginformasikan bahwa data akun kamu di sistem <strong>{{ config('app.name') }}</strong>
            baru saja diperbarui pada
            <strong>{{ now()->translatedFormat('d F Y, H:i') }} WIB</strong>.
        </p>

        @if(count($perubahan) > 0)
            <div style="background:#f5f8fc;border:1px solid #e1e8f1;border-radius:8px;padding:14px 16px;margin-bottom:16px;">
                <div style="font-size:12.5px;color:#708099;font-weight:700;margin-bottom:6px;text-transform:uppercase;letter-spacing:.3px;">
                    Yang berubah:
                </div>
                <ul style="margin:0;padding-left:18px;font-size:14px;line-height:1.7;">
                    @foreach($perubahan as $field)
                        <li>{{ $field }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <p style="font-size:13px;line-height:1.6;color:#5a6a80;margin:0;">
            Kalau kamu tidak merasa meminta perubahan ini, segera hubungi admin toko kamu.
        </p>
    </div>

    <div style="padding:14px 28px;background:#f5f8fc;font-size:11.5px;color:#8e9bb0;text-align:center;">
        Email ini dikirim otomatis, mohon tidak membalas ke alamat ini.
    </div>

</div>
</body>
</html>
