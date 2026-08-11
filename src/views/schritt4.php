<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Checkout - Schritt 4 - Bestätigung</title>
    <link rel="stylesheet" href="/booking-checkout/src/views/style.css">
</head>
<body>

<div class="haupt-container">
    
    <header class="navigation">
        <div class="logo">
            <img src="/booking-checkout/src/public/img/Logo.png" alt="Booking Logo">
        </div>
        <div class="zurueck">
            <a href="/booking-checkout/index.php?step=3" class="btn-zurueck">
                <img src="/booking-checkout/src/public/img/Back.png" alt="Zurück">
            </a>
        </div>
    </header>

    <form class="content-wrapper step-4" action="/booking-checkout/index.php?step=4" method="post">
        
        <div class="karten-container-upgrade">
            <section class="upgrade-karte-inhalt">
                
                <div class="reise-karte-header4">
                    <h2 class="titel-schritt4">Bestätige Deine Buchung</h2>
                    <div class="standort-wrapper">
                        <img src="/booking-checkout/src/public/img/Location.png" alt="Standort" class="pin-icon">
                        <span class="standort-text"><?php echo htmlspecialchars($standortName); ?></span>
                    </div>
                </div>

                <div class="buchungs-details-grid">
                    <div class="detail-row">
                        <span class="detail-label">Datum:</span>
                        <span class="detail-wert"><?php echo htmlspecialchars($datumAnzeige); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Erwachsene:</span>
                        <span class="detail-wert"><?php echo (int)$erwachsene; ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Kinder:</span>
                        <span class="detail-wert"><?php echo (int)$kinder; ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Ankunftszeit:</span>
                        <span class="detail-wert">ab <?php echo htmlspecialchars($ankunftszeit); ?> Uhr</span>
                    </div>
                </div>

                <div class="trennlinie-punktiert"></div>

                <div class="preis-rechnung">
                    <div class="preis-row">
                        <span>
                            <?php echo $naechte . ' ' . ($naechte === 1 ? 'Nacht' : 'Nächte'); ?>
                            x € <?php echo number_format($preisProNacht, 2, ',', '.'); ?>:
                        </span>
                        <span class="detail-wert">€ <?php echo number_format($basispreis, 2, ',', '.'); ?></span>
                    </div>

                    <?php if ($zusatzpreis > 0): ?>
                        <div class="preis-row">
                            <span>
                            <?php echo htmlspecialchars($zusatzBezeichnung); ?><br>
                            (<?php echo $naechte . ' ' . ($naechte === 1 ? 'Nacht' : 'Nächte'); ?> x € <?php echo number_format($preisZusatzProNacht, 2, ',', '.'); ?>):
                        </span>
                            <span class="detail-wert">+ € <?php echo number_format($zusatzpreis, 2, ',', '.'); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if ($gutscheinWert > 0): ?>
                        <div class="preis-row">
                            <span>Gutschein (<?php echo htmlspecialchars($gutscheinCode); ?>):</span>
                            <span class="detail-wert">- € <?php echo number_format($gutscheinWert, 2, ',', '.'); ?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="trennlinie-punktiert"></div>

                <div class="preis-rechnung">
                    <div class="preis-row gesamt">
                        <span class="detail-wert">Insgesamt:</span>
                        <span class="detail-wert">€ <?php echo number_format($gesamtpreis, 2, ',', '.'); ?></span>
                    </div>
                </div>

                <?php
                $gutscheinBereichSichtbar =
                    !empty($_SESSION['gutschein_error']) ||
                    !empty($_SESSION['gutschein_success']) ||
                    !empty($gutscheinCode);
                ?>

                <?php if (!$gutscheinBereichSichtbar): ?>
                    <button type="button" class="btn-gutschein" id="gutschein-button-zeigen">
                        <img src="/booking-checkout/src/public/img/Ticket.png" alt="Gutschein-Icon">
                        <span>Ich habe einen Gutschein</span>
                    </button>
                <?php endif; ?>

            </section>

            <div
                id="upgrade-karte-inhalt5"
                class="upgrade-karte-inhalt5"
                style="<?php echo (!empty($_SESSION['gutschein_error']) || !empty($_SESSION['gutschein_success']) || !empty($gutscheinCode)) ? 'display: block;' : 'display: none;'; ?>"
            >
                <h2 class="gutschein-untertitel">Gib folgend deinen Gutscheincode ein</h2>

                <div class="gutschein-input-container">
                    <input
                        type="text"
                        name="gutschein_code"
                        class="gutschein-input-field"
                        placeholder="UZUIIIKK"
                        id="gutschein-eingabe"
                        value="<?php echo htmlspecialchars($gutscheinCode); ?>"
                    >

                    <button type="submit" name="gutschein_pruefen" class="btn-prufe-gutschein" formnovalidate>
                        Prüfen
                    </button>
                </div>

                <?php if (!empty($_SESSION['gutschein_error'])): ?>
                    <div class="error-box2">
                        <?php echo htmlspecialchars($_SESSION['gutschein_error']); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($_SESSION['gutschein_success'])): ?>
                    <div class="success-text">
                        <?php echo htmlspecialchars($_SESSION['gutschein_success']); ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>

        <div class="karten-navigation-wrapper">
            <section class="navigation-box-schritt4">
                
                <div class="agb-container">
                    <input type="checkbox" id="agb" name="agb" required>
                    <label for="agb">
                        Ich stimme den <a href="#">AGB</a> und den <a href="#">Datenschutzbestimmungen</a> zu.
                    </label>
                </div>

                <div class="button-area-final">
                    <button type="submit" name="buchung_bestaetigen" class="btn-bezahlen-final">
                        <span class="prozent-kreis-final">90%</span>
                        <span class="label-text-final">Bestätigen</span>
                        <span class="pfeil-symbol-final">→</span>
                    </button>
                </div>

            </section>
        </div>

    </form>
</div>

<script src="/booking-checkout/src/views/skript.js"></script>
</body>
</html>