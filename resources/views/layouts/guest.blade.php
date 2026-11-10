<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#07152f">
    <title>{{ trim($__env->yieldContent('title', config('app.name', 'ProKerja'))) }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root{font-family:'Plus Jakarta Sans',ui-sans-serif,system-ui,sans-serif;color-scheme:light}
        body{margin:0;min-width:320px;background:#f4f7fc;font-family:'Plus Jakarta Sans',ui-sans-serif,system-ui,sans-serif;-webkit-font-smoothing:antialiased}
        .auth-premium{min-height:100svh;position:relative;isolation:isolate;overflow:hidden;background:radial-gradient(ellipse at 12% 8%,rgba(79,130,255,.13),transparent 32%),radial-gradient(ellipse at 90% 90%,rgba(14,165,233,.09),transparent 30%),linear-gradient(135deg,#f8faff 0%,#eef3fb 100%)}
        .auth-premium:before{content:"";position:absolute;inset:0;z-index:-1;opacity:.26;pointer-events:none;background-image:radial-gradient(#8ca5ca 0.65px,transparent .65px);background-size:22px 22px;mask-image:linear-gradient(to bottom,black,transparent 80%)}
        .auth-premium .grid.w-full.overflow-hidden{border:1px solid rgba(255,255,255,.9)!important;border-radius:30px!important;background:rgba(255,255,255,.94)!important;box-shadow:0 34px 90px rgba(18,39,79,.13),0 5px 18px rgba(18,39,79,.045)!important;backdrop-filter:blur(18px)}
        .auth-premium [class*="bg-[#2563EB]"]{background:linear-gradient(145deg,#07152f 0%,#0d2d63 54%,#164b94 100%)!important;position:relative;isolation:isolate}
        .auth-premium [class*="bg-[#2563EB]"]:before{content:"";position:absolute;inset:0;z-index:-1;pointer-events:none;background:radial-gradient(circle at 80% 15%,rgba(83,151,255,.27),transparent 34%),radial-gradient(circle at 8% 90%,rgba(24,91,185,.32),transparent 38%)}
        .auth-premium [class*="bg-[#2563EB]"] h1{letter-spacing:-.055em;line-height:1.12}
        .auth-premium input:not([type=hidden]){min-height:52px;border-radius:14px!important;border-color:#dce4f0!important;background:#fbfcff!important;color:#13233f!important;box-shadow:inset 0 1px 2px rgba(16,35,66,.025);transition:border-color .2s,box-shadow .2s,background .2s}
        .auth-premium input:not([type=hidden]):hover{border-color:#b9c9e2!important}
        .auth-premium input:not([type=hidden]):focus{border-color:#3478e5!important;background:white!important;box-shadow:0 0 0 4px rgba(52,120,229,.12)!important;outline:none}
        .auth-premium button[type=submit]{min-height:52px;border-radius:14px!important;background:linear-gradient(105deg,#1557c8,#347deb)!important;box-shadow:0 10px 22px rgba(31,99,211,.22)!important;transition:transform .2s,box-shadow .2s,filter .2s}
        .auth-premium button[type=submit]:hover:not(:disabled){transform:translateY(-1px);box-shadow:0 14px 26px rgba(31,99,211,.27)!important;filter:saturate(1.08)}
        .auth-premium a{transition:color .18s,background .18s,border-color .18s}
        .auth-premium .text-slate-900{color:#142541}
        .auth-premium .text-slate-500{color:#687991}
        .auth-premium .rounded-2xl.border-blue-100,.auth-premium .rounded-2xl.border.border-blue-100{border-color:#dce8fa!important;background:linear-gradient(120deg,#f3f7ff,#f8fbff)!important}
        .auth-premium .otp-digit{width:clamp(38px,9vw,54px);height:clamp(48px,11vw,62px);border-radius:15px!important;font-size:clamp(18px,4vw,23px);font-weight:800}
        @media(max-width:1023px){.auth-premium{padding-top:max(12px,env(safe-area-inset-top));padding-bottom:max(12px,env(safe-area-inset-bottom))}.auth-premium .grid.w-full.overflow-hidden{border-radius:24px!important}.auth-premium .grid.w-full.overflow-hidden>div:last-child{padding:clamp(22px,5vw,38px)!important}}
        @media(max-width:480px){.auth-premium .grid.w-full.overflow-hidden{border-radius:20px!important;box-shadow:0 18px 48px rgba(18,39,79,.10)!important}.auth-premium .grid.w-full.overflow-hidden>div:last-child{padding:22px 18px!important}.auth-premium h1{font-size:clamp(28px,8vw,36px)!important}.auth-premium h2{letter-spacing:-.04em}.auth-premium .otp-digit{width:clamp(37px,12vw,46px);height:52px;border-radius:12px!important}}
        @media(prefers-reduced-motion:reduce){.auth-premium *, .auth-premium *:before,.auth-premium *:after{scroll-behavior:auto!important;animation-duration:.01ms!important;animation-iteration-count:1!important;transition-duration:.01ms!important}}
    </style>
</head>
<body class="antialiased">
    {{ $slot }}
</body>
</html>
