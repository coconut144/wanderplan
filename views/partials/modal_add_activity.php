<div class="modal-overlay" id="modaladdAct">
  <div class="modal">
    <h2>🗺️ เพิ่มกิจกรรม</h2>
    <form method="POST" action="index.php">
      <input type="hidden" name="action" value="add_activity">
      <input type="hidden" name="trip_id" value="<?= $trip['id'] ?>">

      <div class="form-group">
        <label>ชื่อกิจกรรม</label>
        <input type="text" name="title" placeholder="เช่น กินราเมนที่ Ichiran" required>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>ประเภท</label>
          <select name="type">
            <option value="sightseeing">🗺️ ท่องเที่ยว</option>
            <option value="food">🍜 อาหาร</option>
            <option value="transport">🚗 เดินทาง</option>
            <option value="hotel">🏨 ที่พัก</option>
            <option value="shopping">🛍️ ช้อปปิ้ง</option>
            <option value="other">📌 อื่นๆ</option>
          </select>
        </div>
        <div class="form-group">
          <label>เวลา</label>
          <input type="time" name="time">
        </div>
      </div>

      <div class="form-group">
        <label>ค่าใช้จ่าย (฿)</label>
        <input type="number" name="cost" min="0" placeholder="0" value="0">
      </div>

      <div class="modal-btns">
        <button type="button" class="btn-cancel" onclick="closeModal('addAct')">ยกเลิก</button>
        <button type="submit" class="btn-submit">เพิ่มกิจกรรม</button>
      </div>
    </form>
  </div>
</div>
