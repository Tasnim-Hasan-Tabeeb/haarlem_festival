<section class="page">
  <style>
    .page { background:#f7f9fc; padding:32px 0 60px; font-family: Arial, sans-serif; }
    .wrap { width:min(1100px, 92%); margin:0 auto; }
    .hero { background:white; border-radius:16px; padding:26px; box-shadow:0 10px 30px rgba(0,0,0,.06); }
    .hero h2 { margin:0 0 8px; font-size:28px; color:#111827; }
    .hero p { margin:0; color:#6b7280; line-height:1.6; }

    .grid { margin-top:18px; display:grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap:16px; }
    .card { background:white; border-radius:14px; padding:18px; box-shadow:0 8px 22px rgba(0,0,0,.06); border:1px solid #e5e7eb; }
    .card h3 { margin:0 0 6px; font-size:18px; color:#111827; }
    .meta { display:flex; gap:10px; flex-wrap:wrap; margin-top:10px; }
    .pill { font-size:13px; padding:6px 10px; border-radius:999px; background:#eef2ff; color:#3730a3; }
    .pill.green { background:#eaf8ee; color:#166534; }
    .pill.gray { background:#f3f4f6; color:#374151; }

    .actions { margin-top:18px; display:flex; gap:10px; flex-wrap:wrap; }
    .btn { display:inline-block; padding:10px 14px; border-radius:10px; text-decoration:none; font-weight:600; }
    .btn.primary { background:#21a33b; color:white; }
    .btn.secondary { background:white; border:1px solid #e5e7eb; color:#111827; }
  </style>

  <div class="wrap">
    <div class="hero">
      <h2><?= htmlspecialchars($title ?? 'Restaurants', ENT_QUOTES, 'UTF-8') ?></h2>
      <p>A simple restaurant listing page with clean cards. You can connect this to your database later.</p>

      <div class="actions">
        <a class="btn primary" href="/home">Back to Home</a>
        <a class="btn secondary" href="/">Main Layout</a>
      </div>
    </div>

    <div class="grid">
      <?php foreach (($restaurants ?? []) as $r): ?>
        <div class="card">
          <h3><?= htmlspecialchars($r['name'], ENT_QUOTES, 'UTF-8') ?></h3>
          <div class="meta">
            <span class="pill"><?= htmlspecialchars($r['type'], ENT_QUOTES, 'UTF-8') ?></span>
            <span class="pill gray"><?= htmlspecialchars($r['price'], ENT_QUOTES, 'UTF-8') ?></span>
            <span class="pill green">⭐ <?= htmlspecialchars((string)$r['rating'], ENT_QUOTES, 'UTF-8') ?></span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
