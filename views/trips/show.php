<div class="page">
  <a class="back-btn" href="index.php">← กลับหน้าหลัก</a>

  <!-- Trip Header -->
  <div class="detail-header">
    <div class="detail-emoji"><?= $trip['cover_emoji'] ?></div>
    <div class="detail-info">
      <h1><?= $trip['name'] ?></h1>
      <p class="dest">📍 <?= $trip['destination'] ?></p>
      <div class="detail-metas">
        <span class="chip <?= ViewHelper::statusClass($trip['status']) ?>">
          <?= ViewHelper::statusLabel($trip['status']) ?>
        </span>
        <?php if ($trip['start_date']): ?>
          <span class="chip">📅 <?= $trip['start_date'] ?> – <?= $trip['end_date'] ?></span>
        <?php endif; ?>
      </div>
    </div>

    <!-- Status Switcher -->
    <div class="status-switcher">
      <?php foreach (['planning' => 'วางแผน', 'ongoing' => 'กำลังเดิน', 'done' => 'เสร็จแล้ว'] as $s => $l): ?>
        <a href="index.php?action=update_status&trip_id=<?= $trip['id'] ?>&status=<?= $s ?>"
           class="<?= $trip['status'] === $s ? 'active-s' : '' ?>">
          <?= $l ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Trip Stats -->
  <div class="detail-stats">
    <div class="d-stat">
      <div class="val"><?= $tripStats['days'] ?: '–' ?></div>
      <div class="key">วัน</div>
    </div>
    <div class="d-stat">
      <div class="val"><?= number_format($trip['budget']) ?></div>
      <div class="key">งบประมาณ (฿)</div>
    </div>
    <div class="d-stat">
      <div class="val" style="color:var(--accent2)"><?= number_format($tripStats['spent']) ?></div>
      <div class="key">ใช้จ่ายแล้ว (฿)</div>
    </div>
    <div class="d-stat">
      <div class="val" style="color:var(--pink)">
        <?= $tripStats['done_count'] ?>/<?= $tripStats['total_act'] ?>
      </div>
      <div class="key">กิจกรรม</div>
    </div>
  </div>

  <!-- Budget Progress -->
  <?php if ($trip['budget'] > 0): ?>
  <div class="budget-viz">
    <div class="bv-row">
      <span>งบที่ใช้ไป <?= $tripStats['budget_pct'] ?>%</span>
      <span>เหลือ ฿<?= number_format($trip['budget'] - $tripStats['spent']) ?></span>
    </div>
    <div class="bv-bar">
      <div class="bv-fill" style="width:<?= $tripStats['budget_pct'] ?>%"></div>
    </div>
  </div>
  <?php endif; ?>

  <!-- Notes -->
  <?php if ($trip['notes']): ?>
  <div class="notes-box">📝 <?= $trip['notes'] ?></div>
  <?php endif; ?>

  <!-- Activities Section -->
  <div class="section-title">
    กิจกรรม / แพลน
    <button class="btn-nav" onclick="openModal('addAct')">+ เพิ่มกิจกรรม</button>
  </div>

  <?php if (empty($trip['activities'])): ?>
    <div class="empty-state" style="padding:2rem">
      <span class="big">🗺️</span>
      <p>ยังไม่มีกิจกรรม เพิ่มสิ่งที่จะทำในทริปนี้กันเลย!</p>
    </div>
  <?php else: ?>
  <div class="activities-list">
    <?php foreach ($trip['activities'] as $act): ?>
    <div class="act-item <?= $act['done'] ? 'done-item' : '' ?>">
      <a class="act-check <?= $act['done'] ? 'checked' : '' ?>"
         href="index.php?action=toggle_activity&trip_id=<?= $trip['id'] ?>&act_id=<?= $act['id'] ?>">
        <?= $act['done'] ? '✓' : '' ?>
      </a>
      <span class="act-icon"><?= ViewHelper::typeIcon($act['type']) ?></span>
      <div class="act-body">
        <div class="act-title" style="<?= $act['done'] ? 'text-decoration:line-through' : '' ?>">
          <?= $act['title'] ?>
        </div>
        <?php if ($act['time']): ?>
          <div class="act-meta">🕐 <?= $act['time'] ?></div>
        <?php endif; ?>
      </div>
      <?php if ($act['cost'] > 0): ?>
        <div class="act-cost">฿<?= number_format($act['cost']) ?></div>
      <?php endif; ?>
      <a class="act-del"
         href="index.php?action=delete_activity&trip_id=<?= $trip['id'] ?>&act_id=<?= $act['id'] ?>"
         onclick="return confirm('ลบกิจกรรมนี้?')">✕</a>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</div>

<?php require BASE_PATH . '/views/partials/modal_add_activity.php'; ?>
