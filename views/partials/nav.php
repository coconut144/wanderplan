<nav>
  <a class="logo" href="index.php">Wander<span>Plan</span></a>
  <div class="spacer"></div>
  <?php if (!isset($trip)): ?>
    <button class="btn-nav" onclick="openModal('addTrip')">+ เพิ่มทริป</button>
  <?php endif; ?>
</nav>
