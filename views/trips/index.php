<div class="page">
  <div class="hero">
    <h1>วางแผนทริป </h1>
    <p>จัดการทุกทริป กิจกรรม และงบประมาณ ในที่เดียว</p>
  </div>

  <!-- Stats Row -->
  <div class="stats-row">
    <div class="stat-card">
      <span class="num"><?= $stats['total_trips'] ?></span>
      <div class="lbl">ทริปทั้งหมด</div>
    </div>
    <div class="stat-card">
      <span class="num"><?= $stats['destinations'] ?></span>
      <div class="lbl">จุดหมาย</div>
    </div>
    <div class="stat-card">
      <span class="num"><?= $stats['ongoing'] ?></span>
      <div class="lbl">กำลังเดินทาง</div>
    </div>
    <div class="stat-card">
      <span class="num"><?= number_format($stats['total_budget'] / 1000, 0) ?>K</span>
      <div class="lbl">งบรวม (฿)</div>
    </div>
  </div>

  <!-- Trips Grid -->
  <div class="trips-grid">
    <?php foreach ($trips as $trip):
      $spent = ActivityModel::totalCost($trip['activities']);
      $pct   = ViewHelper::budgetPercent((float)$trip['budget'], $spent);
      $days  = ViewHelper::daysCount($trip['start_date'], $trip['end_date']);
    ?>
    <div class="trip-card">
      <div class="trip-card-header">
        <div class="trip-emoji"><?= $trip['cover_emoji'] ?></div>
        <div>
          <h3><?= $trip['name'] ?></h3>
          <div class="trip-dest">📍 <?= $trip['destination'] ?></div>
        </div>
      </div>

      <div class="trip-card-body">
        <div class="trip-meta">
          <span class="chip <?= ViewHelper::statusClass($trip['status']) ?>">
            <?= ViewHelper::statusLabel($trip['status']) ?>
          </span>
          <?php if ($days): ?>
            <span class="chip">📅 <?= $days ?> วัน</span>
          <?php endif; ?>
          <span class="chip">📋 <?= count($trip['activities']) ?> กิจกรรม</span>
        </div>

        <?php if ($trip['budget'] > 0): ?>
          <div class="budget-text">
            งบ ฿<?= number_format($trip['budget']) ?> · ใช้แล้ว <?= $pct ?>%
          </div>
          <div class="budget-bar">
            <div class="budget-fill" style="width:<?= $pct ?>%"></div>
          </div>
        <?php endif; ?>
      </div>

      <div class="trip-card-footer">
        <a class="btn-view" href="index.php?view=<?= $trip['id'] ?>">ดูรายละเอียด →</a>
        <a href="index.php?action=delete_trip&trip_id=<?= $trip['id'] ?>"
           class="btn-danger"
           onclick="return confirm('ลบทริปนี้?')">🗑️ ลบ</a>
      </div>
    </div>
    <?php endforeach; ?>

    <!-- Add New Trip Card -->
    <div class="add-card" onclick="openModal('addTrip')">
      <div class="add-icon">+</div>
      <p>เพิ่มทริปใหม่</p>
    </div>
  </div>

  <?php if (empty($trips)): ?>
  <div class="empty-state">
    <span class="big">🌏</span>
    <p>ยังไม่มีทริป คลิก "เพิ่มทริป" เพื่อเริ่มวางแผนการเดินทาง!</p>
  </div>
  <?php endif; ?>
</div>

<?php require BASE_PATH . '/views/partials/modal_add_trip.php'; ?>
