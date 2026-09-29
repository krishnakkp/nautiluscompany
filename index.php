<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quarterly Client Feedback</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;600;700;900&display=swap" rel="stylesheet">
  <style>
    :root {
      --navy: #00222f;
      --navy-dark: #00161e;
      --navy-light: #e6eef0;
      --teal: #008e9c;
      --text: #101010;
      --muted: #5b6a6d;
      --border: #dbe4e6;
      --bg: #f4f6f7;
      --white: #ffffff;
      --black: #000000;
      --green: #16a34a;
      --red: #dc2626;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Merriweather', Georgia, 'Times New Roman', serif;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      padding: 0 0 60px;
    }

    .card {
      max-width: 620px;
      margin: 32px auto 0;
      background: var(--white);
      border-radius: 12px;
      box-shadow: 0 2px 16px rgba(0,0,0,0.08);
      overflow: hidden;
    }

    .card-header {
      background: linear-gradient(135deg, var(--navy) 0%, var(--teal) 100%);
      padding: 24px 28px;
      color: white;
    }
    .card-header .card-logo { height: 46px; display: block; margin: 0 auto 18px; }
    .card-header .step-label {
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      opacity: 0.7;
      margin-bottom: 6px;
      font-weight: 700;
    }
    .card-header h2 { font-size: 18px; font-weight: 700; }
    .card-header p { font-size: 13px; opacity: 0.85; margin-top: 6px; line-height: 1.6; font-weight: 400; }

    .card-body { padding: 24px 28px; }

    .field { margin-bottom: 22px; }
    .field label {
      display: block;
      font-size: 13px;
      font-weight: 700;
      color: var(--text);
      margin-bottom: 8px;
      line-height: 1.5;
    }
    .field label .required { color: var(--red); margin-left: 2px; }
    .field label .optional { color: var(--muted); font-weight: 400; font-size: 12px; }

    input[type="text"], textarea, select {
      width: 100%;
      padding: 10px 13px;
      border: 1.5px solid var(--border);
      border-radius: 7px;
      font-size: 14px;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;
      color: var(--text);
      background: white;
      transition: border-color 0.15s;
      outline: none;
    }
    input[type="text"]:focus, textarea:focus, select:focus {
      border-color: var(--teal);
      box-shadow: 0 0 0 3px rgba(0,142,156,0.12);
    }
    textarea { resize: vertical; min-height: 80px; line-height: 1.5; }

    .star-group { display: grid; grid-template-columns: repeat(5,1fr); gap: 6px; }
    .star-group input[type="radio"] { display: none; }
    .star-group label {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 4px;
      padding: 10px 4px;
      border: 1.5px solid var(--border);
      border-radius: 8px;
      cursor: pointer;
      font-size: 11px;
      font-weight: 600;
      color: var(--muted);
      background: white;
      transition: all 0.15s;
      user-select: none;
      text-align: center;
      line-height: 1.2;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;
    }
    .star-group label .snum {
      font-size: 17px;
      font-weight: 800;
      color: var(--navy);
      line-height: 1;
    }
    .star-group label:hover { border-color: var(--navy); background: var(--navy-light); }
    .star-group input[type="radio"]:checked + label {
      background: var(--navy);
      border-color: var(--navy);
      color: white;
    }
    .star-group input[type="radio"]:checked + label .snum { color: white; }

    .conf-rating { display: flex; flex-direction: column; gap: 8px; }
    .conf-rating input[type="radio"] { display: none; }
    .conf-rating label {
      display: flex;
      align-items: center;
      padding: 11px 14px;
      border: 1.5px solid var(--border);
      border-radius: 8px;
      cursor: pointer;
      font-size: 13px;
      color: var(--text);
      background: white;
      transition: all 0.15s;
      user-select: none;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;
    }
    .conf-rating label:hover { border-color: var(--navy); background: var(--navy-light); }
    .conf-rating input[type="radio"]:checked + label {
      background: var(--navy);
      border-color: var(--navy);
      color: white;
    }

    .section-divider {
      display: flex;
      align-items: center;
      gap: 10px;
      margin: 8px 0 20px;
    }
    .section-divider span {
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: var(--muted);
      white-space: nowrap;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;
    }
    .section-divider::before, .section-divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--border);
    }

    .divider { border: none; border-top: 1px solid #f0f2f5; margin: 6px 0 22px; }

    .nav { display: flex; gap: 10px; justify-content: space-between; align-items: center; padding-top: 8px; }
    .btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 11px 22px;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 700;
      cursor: pointer;
      border: none;
      transition: all 0.15s;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;
    }
    .btn-primary { background: var(--navy); color: white; }
    .btn-primary:hover { background: var(--navy-dark); }
    .btn-secondary { background: #f0f2f5; color: var(--text); }
    .btn-secondary:hover { background: #e4e7ec; }
    .btn-submit { background: var(--teal); color: white; width: 100%; justify-content: center; font-size: 15px; padding: 14px; }
    .btn-submit:hover { background: #00707b; }
    .btn-submit:disabled { opacity: 0.6; cursor: not-allowed; }

    .progress-track { background: #eef1f2; height: 4px; }
    .progress-bar { height: 4px; background: var(--teal); width: 0%; transition: width 0.4s ease; }

    .step { display: none; }
    .step.active { display: block; }

    .step-dots { display: flex; gap: 6px; justify-content: center; margin-top: 18px; }
    .dot {
      width: 8px; height: 8px; border-radius: 50%;
      background: rgba(255,255,255,0.28);
      transition: all 0.2s;
    }
    .dot.active { background: #ffffff; width: 22px; border-radius: 4px; }
    .dot.done { background: rgba(255,255,255,0.6); }

    #thankyou { display: none; }
    #thankyou .card-body {
      text-align: center;
      padding: 48px 28px;
    }
    #thankyou p { color: var(--navy); font-size: 17px; font-weight: 700; line-height: 1.6; max-width: 380px; margin: 0 auto; }

    .error-banner {
      display: none;
      background: #fef2f2;
      border: 1.5px solid #fca5a5;
      color: #991b1b;
      font-size: 13px;
      padding: 10px 14px;
      border-radius: 8px;
      margin-bottom: 18px;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;
    }

    .form-footer {
      text-align: center;
      padding: 16px;
      font-size: 11px;
      color: var(--muted);
    }

    @media (max-width: 480px) {
      .card { margin: 16px 12px 0; border-radius: 10px; }
      .card-header, .card-body { padding: 20px; }
      .star-group label { padding: 8px 2px; font-size: 10px; }
      .star-group label .snum { font-size: 15px; }
    }
  </style>
</head>
<body>

<div class="card">

  <form id="feedbackForm">
    <input type="hidden" name="survey_period" id="survey_period" value="">

    <!-- STEP 1: About you -->
    <div class="step active" id="step-1">
      <div class="card-header">
        <img src="assets/logo-white.webp" alt="Company logo" class="card-logo">
        <div class="step-label">Step 1 of 3</div>
        <h2>About You</h2>
        <p>Just a couple of details so we know who this feedback is from.</p>
        <div class="step-dots">
          <div class="dot active"></div>
          <div class="dot"></div>
          <div class="dot"></div>
        </div>
      </div>
      <div class="progress-track"><div class="progress-bar"></div></div>
      <div class="card-body">
        <div class="field">
          <label>Your name <span class="required">*</span></label>
          <input type="text" name="contact_name" placeholder="e.g. John Smith" required>
        </div>
        <div class="field">
          <label>Company name <span class="required">*</span></label>
          <input type="text" name="company" placeholder="e.g. Meridian Bulk Carriers" required>
        </div>
        <div class="nav">
          <span></span>
          <button type="button" class="btn btn-primary" onclick="nextStep(1)">Next &rarr;</button>
        </div>
      </div>
    </div>

    <!-- STEP 2: Ratings -->
    <div class="step" id="step-2">
      <div class="card-header">
        <img src="assets/logo-white.webp" alt="Company logo" class="card-logo">
        <div class="step-label">Step 2 of 3</div>
        <h2>Your Ratings</h2>
        <p>Please rate us on each area for this quarter.</p>
        <div class="step-dots">
          <div class="dot done"></div>
          <div class="dot active"></div>
          <div class="dot"></div>
        </div>
      </div>
      <div class="progress-track"><div class="progress-bar"></div></div>
      <div class="card-body">
        <div class="field">
          <label>Overall satisfaction <span class="required">*</span></label>
          <div class="star-group">
            <input type="radio" name="overall_satisfaction" id="os1" value="1 - Very Poor" required>
            <label for="os1"><span class="snum">1</span>Very Poor</label>
            <input type="radio" name="overall_satisfaction" id="os2" value="2 - Poor">
            <label for="os2"><span class="snum">2</span>Poor</label>
            <input type="radio" name="overall_satisfaction" id="os3" value="3 - Neutral">
            <label for="os3"><span class="snum">3</span>Neutral</label>
            <input type="radio" name="overall_satisfaction" id="os4" value="4 - Good">
            <label for="os4"><span class="snum">4</span>Good</label>
            <input type="radio" name="overall_satisfaction" id="os5" value="5 - Excellent">
            <label for="os5"><span class="snum">5</span>Excellent</label>
          </div>
        </div>

        <hr class="divider">

        <div class="field">
          <label>Service quality <span class="required">*</span></label>
          <div class="star-group">
            <input type="radio" name="service_quality" id="sq1" value="1 - Very Poor" required>
            <label for="sq1"><span class="snum">1</span>Very Poor</label>
            <input type="radio" name="service_quality" id="sq2" value="2 - Poor">
            <label for="sq2"><span class="snum">2</span>Poor</label>
            <input type="radio" name="service_quality" id="sq3" value="3 - Neutral">
            <label for="sq3"><span class="snum">3</span>Neutral</label>
            <input type="radio" name="service_quality" id="sq4" value="4 - Good">
            <label for="sq4"><span class="snum">4</span>Good</label>
            <input type="radio" name="service_quality" id="sq5" value="5 - Excellent">
            <label for="sq5"><span class="snum">5</span>Excellent</label>
          </div>
        </div>

        <hr class="divider">

        <div class="field">
          <label>Communication <span class="required">*</span></label>
          <div class="star-group">
            <input type="radio" name="communication" id="co1" value="1 - Very Poor" required>
            <label for="co1"><span class="snum">1</span>Very Poor</label>
            <input type="radio" name="communication" id="co2" value="2 - Poor">
            <label for="co2"><span class="snum">2</span>Poor</label>
            <input type="radio" name="communication" id="co3" value="3 - Neutral">
            <label for="co3"><span class="snum">3</span>Neutral</label>
            <input type="radio" name="communication" id="co4" value="4 - Good">
            <label for="co4"><span class="snum">4</span>Good</label>
            <input type="radio" name="communication" id="co5" value="5 - Excellent">
            <label for="co5"><span class="snum">5</span>Excellent</label>
          </div>
        </div>

        <hr class="divider">

        <div class="field">
          <label>Confidence in us as a long-term partner <span class="required">*</span></label>
          <div class="conf-rating">
            <input type="radio" name="confidence" id="cf1" value="Very Confident" required>
            <label for="cf1">Very confident</label>
            <input type="radio" name="confidence" id="cf2" value="Confident">
            <label for="cf2">Confident</label>
            <input type="radio" name="confidence" id="cf3" value="Neutral">
            <label for="cf3">Neutral</label>
            <input type="radio" name="confidence" id="cf4" value="Some Concerns">
            <label for="cf4">Some concerns</label>
            <input type="radio" name="confidence" id="cf5" value="Significant Concerns">
            <label for="cf5">Significant concerns</label>
          </div>
        </div>

        <div class="nav">
          <button type="button" class="btn btn-secondary" onclick="prevStep(2)">&larr; Back</button>
          <button type="button" class="btn btn-primary" onclick="nextStep(2)">Next &rarr;</button>
        </div>
      </div>
    </div>

    <!-- STEP 3: Comments — all areas in one form -->
    <div class="step" id="step-3">
      <div class="card-header">
        <img src="assets/logo-white.webp" alt="Company logo" class="card-logo">
        <div class="step-label">Step 3 of 3</div>
        <h2>Your Comments</h2>
        <p>Six questions covering the full picture. Be as brief or as detailed as you like.</p>
        <div class="step-dots">
          <div class="dot done"></div>
          <div class="dot done"></div>
          <div class="dot active"></div>
        </div>
      </div>
      <div class="progress-track"><div class="progress-bar"></div></div>
      <div class="card-body">
        <div class="error-banner" id="submitError"></div>

        <div class="section-divider"><span>General</span></div>

        <div class="field">
          <label>What went well this quarter? <span class="required">*</span></label>
          <textarea name="positive_feedback" placeholder="Tell us what you appreciated..." rows="3" required></textarea>
        </div>
        <div class="field">
          <label>Any issues or concerns? <span class="required">*</span></label>
          <textarea name="issues_concerns" placeholder="Anything that could have gone better..." rows="3" required></textarea>
        </div>

        <div class="section-divider"><span>Operations</span></div>

        <div class="field">
          <label>Were there any operational delays, incidents, or issues this quarter? If yes, how well did we handle them? <span class="required">*</span></label>
          <textarea name="operations_feedback" placeholder="e.g. port calls, crew changes, incident handling..." rows="3" required></textarea>
        </div>

        <div class="section-divider"><span>Communication</span></div>

        <div class="field">
          <label>When you needed an update or had a question, how quickly and clearly did we respond? <span class="required">*</span></label>
          <textarea name="communication_feedback" placeholder="e.g. response times, clarity of updates, proactiveness..." rows="3" required></textarea>
        </div>

        <div class="section-divider"><span>Commercial</span></div>

        <div class="field">
          <label>Do you feel you are getting good value for the fees you pay Nautilus? What is behind your answer? <span class="required">*</span></label>
          <textarea name="commercial_feedback" placeholder="e.g. pricing feels fair, or areas where cost does not match value..." rows="3" required></textarea>
        </div>

        <div class="section-divider"><span>Our Partnership</span></div>

        <div class="field">
          <label>If you could change one thing about how we work together, what would it be? <span class="required">*</span></label>
          <textarea name="relationship_feedback" placeholder="Your honest answer helps us improve..." rows="3" required></textarea>
        </div>

        <div class="field">
          <label>Anything else you would like to share? <span class="optional">(optional)</span></label>
          <textarea name="other_comments" placeholder="Any other comments..." rows="3"></textarea>
        </div>

        <div class="nav" style="display:block">
          <button type="submit" class="btn btn-submit" id="submitBtn">Submit Feedback</button>
          <div style="text-align:center;margin-top:10px">
            <button type="button" class="btn btn-secondary" style="font-size:12px;padding:7px 14px" onclick="prevStep(3)">&larr; Back</button>
          </div>
        </div>
      </div>
    </div>

  </form>

  <!-- Thank you screen -->
  <div id="thankyou">
    <div class="card-header">
      <img src="assets/logo-white.webp" alt="Company logo" class="card-logo">
      <div class="step-label">Complete</div>
      <h2>Feedback Received</h2>
    </div>
    <div class="progress-track"><div class="progress-bar" style="width:100%"></div></div>
    <div class="card-body">
      <p>Thank you for your valuable feedback.</p>
    </div>
  </div>

</div>

<div class="form-footer">
  Copyright &copy; 2026 Nautilus Shipping. All rights reserved.
</div>

<script>
  const TOTAL_STEPS = 3;
  const SUBMIT_ENDPOINT = 'submit-feedback.php';

  // Auto-set survey period from URL ?q=Q1/Q2/Q3/Q4 and ?y=2026
  (function() {
    const params = new URLSearchParams(window.location.search);
    const q = params.get('q') || '';
    const y = params.get('y') || new Date().getFullYear();
    const label = q ? (q + ' ' + y) : '';
    if (label) {
      document.getElementById('survey_period').value = label;
    }
  })();

  function updateProgress(step) {
    const pct = ((step / TOTAL_STEPS) * 100) + '%';
    document.querySelectorAll('.progress-bar').forEach(el => el.style.width = pct);
  }

  function nextStep(current) {
    const stepEl = document.getElementById('step-' + current);
    const required = stepEl.querySelectorAll('[required]');
    let valid = true;
    required.forEach(el => {
      if (el.type === 'radio') {
        const group = stepEl.querySelectorAll(`[name="${el.name}"]`);
        const checked = Array.from(group).some(r => r.checked);
        if (!checked) { valid = false; el.closest('.field').querySelector('label').style.color = '#dc2626'; }
        else { el.closest('.field').querySelector('label').style.color = ''; }
      } else {
        if (!el.value.trim()) { valid = false; el.style.borderColor = '#dc2626'; }
        else { el.style.borderColor = ''; }
      }
    });
    if (!valid) return;
    goStep(current + 1);
  }

  function prevStep(current) {
    goStep(current - 1);
  }

  function goStep(n) {
    for (let i = 1; i <= TOTAL_STEPS; i++) {
      const el = document.getElementById('step-' + i);
      if (el) el.classList.toggle('active', i === n);
    }
    updateProgress(n);
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  document.getElementById('feedbackForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const errorBanner = document.getElementById('submitError');
    errorBanner.style.display = 'none';

    const step3 = document.getElementById('step-3');
    const required = step3.querySelectorAll('[required]');
    let valid = true;
    required.forEach(el => {
      if (!el.value.trim()) { valid = false; el.style.borderColor = '#dc2626'; }
      else { el.style.borderColor = ''; }
    });
    if (!valid) return;

    const form = e.target;
    const data = new FormData(form);

    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Submitting...';

    try {
      const res = await fetch(SUBMIT_ENDPOINT, { method: 'POST', body: data, headers: { 'Accept': 'application/json' } });
      const result = await res.json().catch(() => null);

      if (res.ok && result && result.success) {
        form.style.display = 'none';
        document.getElementById('thankyou').style.display = 'block';
        document.querySelectorAll('.progress-bar').forEach(el => el.style.width = '100%');
      } else {
        errorBanner.textContent = (result && result.message) || 'There was a problem submitting your feedback. Please try again.';
        errorBanner.style.display = 'block';
        submitBtn.disabled = false;
        submitBtn.textContent = 'Submit Feedback';
      }
    } catch (err) {
      errorBanner.textContent = 'There was a problem submitting your feedback. Please check your connection and try again.';
      errorBanner.style.display = 'block';
      submitBtn.disabled = false;
      submitBtn.textContent = 'Submit Feedback';
    }
  });

  updateProgress(1);
</script>

</body>
</html>
