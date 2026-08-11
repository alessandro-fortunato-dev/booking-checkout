# GreenStay Booking

GreenStay Booking ist eine mehrstufige Buchungsanwendung, die im Rahmen meines IHK-Abschlussprojekts zum Fachinformatiker für Anwendungsentwicklung entstanden ist.

Die Anwendung ermöglicht die Erfassung und Verarbeitung einer Buchung über mehrere Schritte hinweg und speichert die Daten in einer MySQL-Datenbank.

## Funktionen

- Auswahl von Check-in und Check-out
- Auswahl der Anzahl von Erwachsenen und Kindern
- Erfassung persönlicher Buchungsdaten
- Auswahl optionaler Zusatzleistungen
- Gutscheinprüfung
- Automatische Preisberechnung
- Zusammenfassung der Buchungsdaten
- Speicherung der Buchung in einer MySQL-Datenbank
- Anzeige einer Buchungsbestätigung

## Technologien

- PHP
- MySQL
- HTML5
- CSS3
- JavaScript
- PDO
- XAMPP

## Projektstruktur

Die Anwendung ist in mehrere Bereiche strukturiert:

- **Controller** – Verarbeitung der Anwendungslogik und Benutzereingaben
- **Models** – Datenbankzugriffe und Verarbeitung der Daten
- **Views** – Darstellung der einzelnen Buchungsschritte
- **PDO** – Datenbankverbindung zu MySQL
- **Sessions** – Zwischenspeicherung der Buchungsdaten während des Buchungsprozesses
- **Routing** – Steuerung der einzelnen Schritte der Anwendung

## Installation

1. Repository herunterladen oder klonen.
2. Projektordner in den `htdocs`-Ordner von XAMPP kopieren.
3. Apache und MySQL über XAMPP starten.
4. In phpMyAdmin eine Datenbank mit dem Namen `greenstay_booking` erstellen.
5. Die Datei `sql/greenstay_booking.sql` in die Datenbank importieren.
6. Die Datei `.env.example` kopieren und die Kopie in `.env` umbenennen.
7. Die eigenen Datenbank-Zugangsdaten in `.env` eintragen.

Beispiel:

```env
DB_HOST=localhost
DB_NAME=greenstay_booking
DB_USER=root
DB_PASSWORD=
```

8. Die Anwendung im Browser öffnen:

```text
http://localhost/booking-checkout/index.php?step=1
```

## Hinweis

Die Datei `.env` wird nicht versioniert und ist über `.gitignore` vom Repository ausgeschlossen. Die Datei `.env.example` dient ausschließlich als Vorlage für die lokale Konfiguration.

Die bereitgestellten Datenbankeinträge sind Demo-/Mockdaten.