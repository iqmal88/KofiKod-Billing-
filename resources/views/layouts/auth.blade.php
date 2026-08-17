<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Authentication')</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --brand-forest: #1E291B;   /* Your Dark Forest Green theme baseline */
            --brand-bronze: #8C6D53;   /* Accent Earth Brown parameter token */
            --brand-charcoal: #0F172A;
        }
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #F8FAFC;
        }
        .bg-auth-gradient {
            background: linear-gradient(135deg, var(--brand-forest) 0%, #111810 100%);
            position: relative;
            overflow: hidden;
        }
        /* Soft professional overlay texture effect mimicking premium agency logins */
        .bg-auth-gradient::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: radial-gradient(rgba(140, 109, 83, 0.15) 1px, transparent 0);
            background-size: 24px 24px;
            opacity: 0.8;
        }
        .text-bronze {
            color: var(--brand-bronze) !important;
        }
        .btn-brand-submit {
            background-color: var(--brand-forest);
            color: #ffffff;
            border: 0;
            transition: all 0.2s ease;
        }
        .btn-brand-submit:hover {
            background-color: #2D3E29;
            color: #ffffff;
        }
        .form-control-brand-focus:focus {
            border-color: var(--brand-bronze) !important;
            box-shadow: 0 0 0 0.25rem rgba(140, 109, 83, 0.15) !important;
        }
        .input-group:focus-within .input-group-text {
            border-color: var(--brand-bronze) !important;
            background-color: #ffffff !important;
            color: var(--brand-forest) !important;
        }
        .feature-item {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(10px);
            transition: transform 0.2s ease;
        }
        .feature-item:hover {
            transform: translateX(4px);
            background: rgba(255, 255, 255, 0.07);
        }
    </style>
</head>
<body>

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>