<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Client Feedback</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&display=swap" rel="stylesheet">
  <style>
    :root {
      --navy: #00222f;
      --navy-dark: #00161e;
      --teal: #008e9c;
      --border: #dbe4e6;
      --bg: #f4f6f7;
      --text: #101010;
      --muted: #5b6a6d;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Merriweather', Georgia, 'Times New Roman', serif;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
    }
    .site-header {
      background: var(--navy);
      padding: 26px 24px;
      text-align: center;
      border-bottom: 3px solid var(--teal);
    }
    .site-header img { height: 38px; display: block; margin: 0 auto 10px; }
    .site-header p { color: rgba(255,255,255,0.65); font-size: 12px; margin-top: 2px; font-weight: 400; }

    .wrap {
      max-width: 560px;
      margin: 0 auto;
      padding: 48px 24px 60px;
      text-align: center;
    }
    .wrap h1 { font-size: 20px; font-weight: 700; color: var(--navy); margin-bottom: 10px; }
    .wrap p.sub {
      font-size: 14px;
      color: var(--muted);
      margin-bottom: 34px;
      line-height: 1.6;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;
    }

    .choices {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }
    .choice-btn {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      justify-content: center;
      gap: 4px;
      background: #fff;
      border: 1.5px solid var(--border);
      border-radius: 12px;
      padding: 20px 20px;
      text-decoration: none;
      color: var(--navy);
      text-align: left;
      transition: all 0.15s;
      box-shadow: 0 1px 4px rgba(0,0,0,0.03);
    }
    .choice-btn:hover {
      border-color: var(--teal);
      box-shadow: 0 4px 14px rgba(0,142,156,0.15);
      transform: translateY(-1px);
    }
    .choice-btn .letter {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 26px;
      height: 26px;
      border-radius: 50%;
      background: var(--navy);
      color: #fff;
      font-size: 12px;
      font-weight: 700;
      margin-bottom: 6px;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;
    }
    .choice-btn .name {
      font-size: 14px;
      font-weight: 700;
    }
    .choice-btn .desc {
      font-size: 11.5px;
      color: var(--muted);
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;
      line-height: 1.4;
    }

    .form-footer {
      text-align: center;
      padding: 16px;
      font-size: 11px;
      color: var(--muted);
    }

    @media (max-width: 480px) {
      .choices { grid-template-columns: 1fr; }
      .wrap { padding: 36px 18px 48px; }
    }
  </style>
</head>
<body>

<div class="site-header">
  <img src="assets/logo-white.webp" alt="Company logo">
  <p>Monthly Client Feedback</p>
</div>

<div class="wrap">
  <h1>Choose this month's feedback form</h1>
  <p class="sub">Please select the form that matches the check-in your account contact pointed you to.</p>

  <div class="choices">
    <a class="choice-btn" href="feedback-form.html?t=a">
      <span class="letter">A</span>
      <span class="name">Operations</span>
      <span class="desc">Vessel performance &amp; day-to-day operations</span>
    </a>
    <a class="choice-btn" href="feedback-form.html?t=b">
      <span class="letter">B</span>
      <span class="name">Communication</span>
      <span class="desc">Responsiveness &amp; how we keep you updated</span>
    </a>
    <a class="choice-btn" href="feedback-form.html?t=c">
      <span class="letter">C</span>
      <span class="name">Commercial</span>
      <span class="desc">Value for money &amp; pricing</span>
    </a>
    <a class="choice-btn" href="feedback-form.html?t=d">
      <span class="letter">D</span>
      <span class="name">Relationship</span>
      <span class="desc">Our long-term partnership</span>
    </a>
  </div>
</div>

<div class="form-footer">
  &copy; <span id="year"></span>
</div>

<script>
  document.getElementById('year').textContent = new Date().getFullYear();
</script>

</body>
</html>
