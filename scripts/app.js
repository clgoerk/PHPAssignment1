document.addEventListener("DOMContentLoaded", function() {
  const countdownEl = document.getElementById('countdown');
  if (countdownEl && countdownEl.dataset.remaining) {
    let remaining = parseInt(countdownEl.dataset.remaining, 10);
    function updateCountdown() {
      if (remaining > 0) {
        let minutes = Math.floor(remaining / 60);
        let seconds = remaining % 60;
        countdownEl.textContent = "Account locked. Please wait " + minutes + "m " + seconds + "s.";
        remaining--;
        setTimeout(updateCountdown, 1000);
      } else {
        countdownEl.textContent = "You can try logging in now.";
      }
    }
    updateCountdown();
  }
});