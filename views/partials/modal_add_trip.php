<div class="modal-overlay" id="modaladdTrip">
  <div class="modal">
    <h2> สร้างทริปใหม่</h2>
    <form method="POST" action="index.php">
      <input type="hidden" name="action" value="add_trip">
      <input type="hidden" name="cover_emoji" id="selectedEmoji" value="✈️">

      <div class="form-group">
        <label>เลือกไอคอน</label>
        <div class="emoji-picker" id="emojiPicker">
          <?php foreach (['✈️','🌸','🏖️','🗼','🏔️','🌴','🏝️','🎌','🗺️','🚗','🚂'] as $em): ?>
            <div class="emoji-opt <?= $em === '✈️' ? 'selected' : '' ?>"
                 onclick="pickEmoji(this,'<?= $em ?>')"><?= $em ?></div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="form-group">
        <label>ชื่อทริป *</label>
        <input type="text" name="name" placeholder="เช่น ทริปญี่ปุ่น ฤดูใบไม้ร่วง" required>
      </div>

      <div class="form-group">
        <label>จุดหมายปลายทาง *</label>
        <input type="text" name="destination" placeholder="เช่น โตเกียว ประเทศญี่ปุ่น" required>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>วันเริ่มต้น</label>
          <input type="date" name="start_date">
        </div>
        <div class="form-group">
          <label>วันสิ้นสุด</label>
          <input type="date" name="end_date">
        </div>
      </div>

      <div class="form-group">
        <label>งบประมาณ (฿)</label>
        <input type="number" name="budget" min="0" placeholder="0">
      </div>

      <div class="form-group">
        <label>หมายเหตุ</label>
        <textarea name="notes" rows="2" placeholder="บันทึกข้อมูลสำคัญ..."></textarea>
      </div>

      <div class="modal-btns">
        <button type="button" class="btn-cancel" onclick="closeModal('addTrip')">ยกเลิก</button>
        <button type="submit" class="btn-submit">สร้างทริป </button>
      </div>
    </form>
  </div>
</div>
