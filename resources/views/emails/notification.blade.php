<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Tahoma, 'Segoe UI', Arial, sans-serif; background-color: #f5f5f5; direction: rtl; color: #333; }
        .wrapper { max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
        .header { background: {{ $headerColor ?? '#6366f1' }}; padding: 28px 32px; text-align: center; }
        .header img { max-height: 50px; margin-bottom: 8px; }
        .header h1 { color: #ffffff; font-size: 20px; font-weight: 700; margin: 0; }
        .body { padding: 32px; }
        .body p { line-height: 1.8; color: #444; font-size: 15px; margin-bottom: 16px; }
        .footer { background: #f9f9f9; border-top: 1px solid #eee; padding: 16px 32px; text-align: center; font-size: 12px; color: #999; }
        .footer a { color: #6366f1; text-decoration: none; }
        @media (max-width: 600px) { .wrapper { margin: 10px; } .body, .header, .footer { padding: 20px 16px; } }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            @if($logoUrl)
                <img src="{{ $logoUrl }}" alt="{{ $siteName }}">
            @else
                <h1>{{ $siteName }}</h1>
            @endif
        </div>
        <div class="body">
            {!! nl2br(e($body)) !!}
        </div>
        <div class="footer">
            {!! $footerText ?? ('این ایمیل از طرف <a href="' . $siteUrl . '">' . $siteName . '</a> ارسال شده است.') !!}
        </div>
    </div>
</body>
</html>
