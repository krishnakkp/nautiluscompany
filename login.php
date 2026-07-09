<?php
require_once __DIR__ . '/auth.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = (string) ($_POST['password'] ?? '');

    if ($username === ADMIN_USERNAME && password_verify($password, ADMIN_PASSWORD_HASH)) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header('Location: index.php');
        exit;
    }
    $error = 'Incorrect username or password.';
}

if (is_logged_in()) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login — Client Feedback</title>
<link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&display=swap" rel="stylesheet">
<style>
  :root { --navy:#00222f; --teal:#008e9c; --bg:#f4f6f7; --border:#dbe4e6; --text:#101010; --muted:#5b6a6d; --red:#dc2626; }
  * { box-sizing:border-box; margin:0; padding:0; }
  body { font-family:'Merriweather',Georgia,serif; background:var(--bg); min-height:100vh; display:flex; align-items:center; justify-content:center; }
  .box { background:#fff; border-radius:12px; box-shadow:0 2px 20px rgba(0,0,0,0.1); width:100%; max-width:360px; overflow:hidden; }
  .box-head { background:var(--navy); padding:26px 28px; text-align:center; border-bottom:3px solid var(--teal); }
  .box-head h1 { color:#fff; font-size:16px; letter-spacing:0.04em; }
  .box-head p { color:rgba(255,255,255,0.6); font-size:11px; margin-top:6px; }
  .box-body { padding:26px 28px; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif; }
  label { display:block; font-size:12px; font-weight:700; margin-bottom:6px; color:var(--text); }
  input { width:100%; padding:10px 12px; border:1.5px solid var(--border); border-radius:7px; font-size:14px; margin-bottom:16px; outline:none; }
  input:focus { border-color:var(--teal); }
  button { width:100%; padding:11px; background:var(--navy); color:#fff; border:none; border-radius:7px; font-weight:700; font-size:14px; cursor:pointer; }
  button:hover { background:#00161e; }
  .err { background:#fef2f2; border:1.5px solid #fca5a5; color:#991b1b; font-size:12px; padding:9px 12px; border-radius:7px; margin-bottom:16px; }
</style>
</head>
<body>
  <div class="box">
    <div class="box-head">
      <h1>ADMIN LOGIN</h1>
      <p>Client Feedback Dashboard</p>
    </div>
    <div class="box-body">
      <?php if ($error): ?><div class="err"><?= htmlspecialchars($error) ?></div><?php endif; ?>
      <form method="POST">
        <label>Username</label>
        <input type="text" name="username" required autofocus>
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit">Log In</button>
      </form>
    </div>
  </div>
</body>
</html>
