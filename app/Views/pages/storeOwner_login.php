<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Owner Login | Sari-sari Store</title>
    <style>
        :root {
            color-scheme: light;
            --ink: #202b25;
            --muted: #718078;
            --green: #176b4a;
            --green-dark: #10553a;
            --line: #e4ebe6;
        }
        * { box-sizing: border-box; }
        body {
            align-items: center;
            background: #f4f7f4;
            color: var(--ink);
            display: flex;
            font: 15px/1.5 system-ui, -apple-system, "Segoe UI", sans-serif;
            justify-content: center;
            margin: 0;
            min-height: 100vh;
            padding: 24px;
        }
        .login-card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: 0 16px 48px #18271d12;
            max-width: 430px;
            padding: 36px;
            width: 100%;
        }
        .brand { color: var(--green); font-size: 13px; font-weight: 800; letter-spacing: .08em; }
        h1 { font-size: 27px; letter-spacing: -.04em; margin: 10px 0 5px; }
        .subtitle { color: var(--muted); margin: 0 0 25px; }
        label { display: block; font-size: 13px; font-weight: 650; margin: 15px 0 6px; }
        input {
            border: 1px solid #d5dfd8;
            border-radius: 8px;
            font: inherit;
            min-height: 44px;
            padding: 10px 12px;
            width: 100%;
        }
        input:focus { border-color: var(--green); outline: 3px solid #176b4a20; }
        button {
            background: var(--green);
            border: 0;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            font: inherit;
            font-weight: 700;
            margin-top: 22px;
            min-height: 44px;
            width: 100%;
        }
        button:hover { background: var(--green-dark); }
        .alert {
            background: #fff0ef;
            border-radius: 8px;
            color: #962e2e;
            margin: 0 0 18px;
            padding: 11px 13px;
        }
        @media (max-width: 480px) { .login-card { padding: 28px 22px; } }
    </style>
</head>
<body>
    <main class="login-card">
        <div class="brand">SARI-SARI STORE</div>
        <h1>Welcome back</h1>
        <p class="subtitle">Sign in to manage your store dashboard.</p>

        <?php if (session()->getFlashdata('error')): ?>
            <p class="alert" role="alert"><?= esc(session()->getFlashdata('error')) ?></p>
        <?php endif ?>

        <form action="<?= site_url('storeOwner/login') ?>" method="post">
            <?= csrf_field() ?>
            <label for="username">Username</label>
            <input id="username" name="username" type="text" value="<?= esc(old('username')) ?>" autocomplete="username" required autofocus>

            <label for="password">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required>

            <button type="submit">Sign in</button>
        </form>
    </main>
</body>
</html>
