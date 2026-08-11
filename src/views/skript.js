/**
 * Ändert den Wert von numerischen Counter-Feldern (Erwachsene, Kinder)
 * Berücksichtigt min/max Attribute des HTML-Elements
 */
function adjustValue(id, change) {
  const input = document.getElementById(id);
  if (!input) return;

  let currentValue = parseInt(input.value) || 0;
  let min = parseInt(input.getAttribute("min")) || 0;
  let max = parseInt(input.getAttribute("max")) || 10;

  let newValue = currentValue + change;

  // Nur ändern, wenn innerhalb der Min/Max Grenzen
  if (newValue >= min && newValue <= max) {
    input.value = newValue;

    // Löst ein "change" Event aus, falls du später
    // Preise automatisch neu berechnen willst
    input.dispatchEvent(new Event("change"));
  }
}

/**
 * Steuert die Uhrzeit in 30-Minuten-Schritten
 * Format: HH:MM
 */
function adjustTime30Min(direction) {
  const timeInput = document.getElementById("checkin_time");
  if (!timeInput) return;

  let [hours, minutes] = timeInput.value.split(":").map(Number);

  // Alles in Minuten umrechnen (z.B. 15:30 -> 930 Minuten)
  let totalMinutes = hours * 60 + minutes;

  // 30 Minuten addieren oder abziehen
  totalMinutes += direction * 30;

  // Grenzen setzen laut deinem Design (Check-in ab 15:00 Uhr)
  const minMinutes = 15 * 60; // 15:00 Uhr
  const maxMinutes = 21 * 60; // 21:00 Uhr

  // Validierung der Grenzen
  if (totalMinutes < minMinutes) totalMinutes = minMinutes;
  if (totalMinutes > maxMinutes) totalMinutes = maxMinutes;

  // Zurückrechnen in Stunden und Minuten
  let newHours = Math.floor(totalMinutes / 60);
  let newMinutes = totalMinutes % 60;

  // Formatieren (mit führender Null, falls nötig, z.B. 09:00)
  const formattedHours = newHours.toString().padStart(2, "0");
  const formattedMinutes = newMinutes.toString().padStart(2, "0");

  timeInput.value = `${formattedHours}:${formattedMinutes}`;

  // Auch hier das Event für spätere Logik auslösen
  timeInput.dispatchEvent(new Event("change"));
}

// Optional: Konsolen-Bestätigung für dich beim Testen
console.log("Booking-Logic geladen: Counter und Time-Picker bereit.");

document.addEventListener("DOMContentLoaded", function () {
  const buttonZeigen = document.getElementById("gutschein-button-zeigen");
  const bereich = document.getElementById("upgrade-karte-inhalt5");

  if (buttonZeigen && bereich) {
    buttonZeigen.addEventListener("click", function () {
      bereich.style.display = "block";
      buttonZeigen.style.display = "none";
    });
  }
});

// Schritt 3: Auswahlzustand beim Laden wiederherstellen
const input = document.getElementById("zusatz_id");
const btnJa = document.querySelector(".btn-ja-upgrade");
const btnNein = document.querySelector(".btn-nein-upgrade");

if (input && btnJa && btnNein) {
  if (parseInt(input.value) === 1) {
    btnJa.classList.add("aktiv");
    btnNein.classList.remove("aktiv");
  } else {
    btnNein.classList.add("aktiv");
    btnJa.classList.remove("aktiv");
  }
}

/**
 * Schritt 3: Romantik-Upgrade wählen
 * value = 1 => Ja
 * value = 0 => Nein
 */
function setUpgrade(value) {
  const input = document.getElementById("zusatz_id");
  const btnJa = document.querySelector(".btn-ja-upgrade");
  const btnNein = document.querySelector(".btn-nein-upgrade");

  if (!input || !btnJa || !btnNein) return;

  input.value = value;

  btnJa.classList.remove("aktiv");
  btnNein.classList.remove("aktiv");

  if (value === 1) {
    btnJa.classList.add("aktiv");
  } else {
    btnNein.classList.add("aktiv");
  }
}
