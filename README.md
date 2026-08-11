# GreenStay Booking

GreenStay Booking ist eine mehrstufige Buchungsanwendung, die im Rahmen meines IHK-Abschlussprojekts zum Fachinformatiker für Anwendungsentwicklung entwickelt wurde.

Die Anwendung bildet einen vollständigen Buchungsprozess über mehrere Schritte ab. Buchungsdaten werden während des Prozesses zwischengespeichert, validiert und anschließend in einer MySQL-Datenbank gespeichert.

## Funktionen

- Auswahl von Check-in und Check-out
- Auswahl der Anzahl von Erwachsenen und Kindern
- Erfassung persönlicher Buchungsdaten
- Auswahl optionaler Zusatzleistungen
- Prüfung von Gutscheinen
- Automatische Preisberechnung
- Zusammenfassung der Buchungsdaten
- Speicherung der Buchung in MySQL
- Anzeige einer Buchungsbestätigung

## Technologien

- PHP
- MySQL
- PDO
- HTML5
- CSS3
- JavaScript
- PHP Sessions
- Git
- XAMPP

## Architektur und Umsetzung

Die Anwendung ist in mehrere Bereiche aufgeteilt:

- **Controller** – verarbeitet Benutzereingaben und steuert den Buchungsablauf
- **Models** – kapseln Datenbankzugriffe und Datenverarbeitung
- **Views** – stellen die einzelnen Schritte des Buchungsprozesses dar
- **PDO** – ermöglicht den Datenbankzugriff auf MySQL
- **Sessions** – speichern Buchungsdaten zwischen den einzelnen Schritten
- **Routing** – steuert den Aufruf der jeweiligen Buchungsschritte

Die Datenbankzugangsdaten werden nicht direkt im Quellcode gespeichert, sondern über eine lokale `.env`-Datei konfiguriert.

## Installation

1. Repository herunterladen oder klonen.
2. Projektordner in den `htdocs`-Ordner von XAMPP kopieren.
3. Apache und MySQL über XAMPP starten.
4. In phpMyAdmin eine Datenbank mit dem Namen `greenstay_booking` erstellen.
5. `sql/greenstay_booking.sql` in die Datenbank importieren.
6. `.env.example` kopieren und die Kopie in `.env` umbenennen.
7. Die lokalen Datenbank-Zugangsdaten in `.env` eintragen.

Beispiel:

```env
DB_HOST=localhost
DB_NAME=greenstay_booking
DB_USER=root
DB_PASSWORD=

8. Anwendung im Browser öffnen:

```text
http://localhost/booking-checkout/index.php?step=1
```

## Sicherheit und Konfiguration

Die Datei `.env` enthält die lokale Datenbankkonfiguration und wird nicht versioniert. Sie ist deshalb über `.gitignore` vom Repository ausgeschlossen.

`.env.example` enthält lediglich die benötigte Konfigurationsstruktur und dient als Vorlage für die lokale Einrichtung.

## Datenbank

Das Repository enthält unter `sql/greenstay_booking.sql` die benötigte Datenbankstruktur.

Enthaltene Beispieldaten dienen ausschließlich zu Demonstrations- und Testzwecken.

## Projektkontext

Dieses Projekt entstand im Rahmen meines IHK-Abschlussprojekts zum Fachinformatiker für Anwendungsentwicklung.

Ziel war die Umsetzung eines mehrstufigen Buchungsprozesses mit PHP und MySQL sowie die strukturierte Trennung von Anwendungslogik, Datenbankzugriff und Benutzeroberfläche.