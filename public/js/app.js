// ── Modal ──────────────────────────────────────────────────────────────────────
function openModal(id) {
  document.getElementById('modal' + id).classList.add('open');
}

function closeModal(id) {
  document.getElementById('modal' + id).classList.remove('open');
}

// Click outside to close
document.querySelectorAll('.modal-overlay').forEach(function (el) {
  el.addEventListener('click', function (e) {
    if (e.target === el) el.classList.remove('open');
  });
});

// Escape key to close
document.addEventListener('keydown', function (e) {
  if (e.key === 'Escape') {
    document.querySelectorAll('.modal-overlay.open').forEach(function (el) {
      el.classList.remove('open');
    });
  }
});

// ── Emoji Picker ───────────────────────────────────────────────────────────────
function pickEmoji(el, emoji) {
  document.querySelectorAll('.emoji-opt').forEach(function (e) {
    e.classList.remove('selected');
  });
  el.classList.add('selected');
  document.getElementById('selectedEmoji').value = emoji;
}
