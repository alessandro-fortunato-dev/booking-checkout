<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Checkout - Schritt 3 - Romantik Upgrade</title>
    <link rel="stylesheet" href="/booking-checkout/src/views/style.css">
</head>
<body>

    <div class="haupt-container">

        <header class="navigation">
            <div class="logo">
                <img src="/booking-checkout/src/public/img/Logo.png" alt="Booking Logo">
            </div>
            <div class="zurueck">
                <a href="/booking-checkout/index.php?step=2" class="btn-zurueck">
                    <img src="/booking-checkout/src/public/img/Back.png" alt="Zurück">
                </a>
            </div>
        </header>

        <form class="content-wrapper step-3" action="/booking-checkout/index.php?step=3" method="post">

            <!-- 🔥 WICHTIG: Hidden Input -->
            <input type="hidden" name="zusatz_id" id="zusatz_id" value="<?php echo in_array($zusatzId, $gewaehlteZusatzleistungen, true) ? $zusatzId : 0; ?>">

            <div class="karten-container-upgrade">
                <section class="upgrade-karte-inhalt">

                    <div class="reise-karte-header2">
                        <h2 class="titel">Verpasse deiner Auszeit etwas Besonderes</h2>
                        <div class="upgrade-icon">
                            <img src="/booking-checkout/src/public/img/Heart.png" alt="Upgrade" style="width: 28px; margin-top: 10px;">
                        </div>
                    </div>

                    <div class="upgrade-layout-wrapper">
                        <div class="upgrade-bild-container">
                            <img src="/booking-checkout/src/public/img/Romantika.png" alt="Romantik" class="upgrade-foto">
                        </div>

                        <div class="upgrade-text-bereich">
                            <h4 class="romantik"><?php echo htmlspecialchars($zusatzBezeichnung); ?></h4>
                            <p><?php echo nl2br(htmlspecialchars($zusatzBeschreibung)); ?></p>
                            
                        </div>
                    </div>

                    <div class="auswahl-container-upgrade">

                        <!-- ❌ NEIN -->
                        <button type="button" class="btn-nein-upgrade" onclick="setUpgrade(0)">
                            Nein, danke
                        </button>

                        <!-- ✅ JA -->
                        <div class="ja-pille-verbund">
                            <span class="preis-tag">+ €<?php echo number_format($zusatzPreis, 0, ',', '.'); ?></span>
                            <button type="button" class="btn-ja-upgrade" onclick="setUpgrade(1)">
                                Ja, gerne
                            </button>
                        </div>

                    </div>

                </section>
            </div>

            <div class="karten-container-upgrade">
                <section class="upgrade-karte-navigation">
                    <div class="button-area-step3">
                        <button type="submit" class="btn-weiter-step3">
                            <span class="btn-prozent-step3">75%</span>
                            <span class="btn-text-step3">Weiter</span>
                            <span class="btn-pfeil-step3">→</span>
                        </button>
                    </div>
                </section>
            </div>

        </form>
    </div>

    <script src="/booking-checkout/src/views/skript.js"></script>

</body>
</html>