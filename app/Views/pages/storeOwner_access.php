<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Owner Access | Sari-sari Store</title>
    <style>
        :root { --ink:#202b25; --muted:#718078; --green:#176b4a; --green-dark:#10553a; --line:#e4ebe6; }
        * { box-sizing:border-box; }
        body { align-items:center; background:#f4f7f4; color:var(--ink); display:flex; font:15px/1.5 system-ui,-apple-system,"Segoe UI",sans-serif; justify-content:center; margin:0; min-height:100vh; padding:24px; }
        .card { background:#fff; border:1px solid var(--line); border-radius:16px; box-shadow:0 16px 48px #18271d12; max-width:430px; padding:36px; width:100%; }
        .brand { color:var(--green); font-size:13px; font-weight:800; letter-spacing:.08em; }
        h1 { font-size:27px; margin:10px 0 5px; }
        .subtitle { color:var(--muted); margin:0 0 24px; }
        .options { display:grid; gap:12px; }
        .option { align-items:center; border:1px solid var(--line); border-radius:10px; color:var(--ink); display:flex; flex-direction:column; padding:18px; text-decoration:none; }
        .option strong { font-size:16px; }
        .option span { color:var(--muted); font-size:13px; margin-top:3px; }
        .option.primary { background:var(--green); border-color:var(--green); color:#fff; }
        .option.primary span { color:#dfece5; }
        .option.primary:hover { background:var(--green-dark); }
    </style>
</head>
<body>
<main class="card">
    <div class="brand">SARI-SARI STORE</div>
    <h1>Store owner access</h1>
    <p class="subtitle">Choose an option to continue.</p>
    <div class="options">
        <a class="option primary" href="<?= site_url('login?mode=signin') ?>">
            <strong>Sign in</strong>
            <span>Use an existing account</span>
        </a>
        <a class="option" href="<?= site_url('register') ?>">
            <strong>Create an account</strong>
            <span>Register a new store owner</span>
        </a>
    </div>
</main>
</body>
</html>
