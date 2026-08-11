<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Checkout - Schritt 1</title>
    <link rel="stylesheet" href="/booking-checkout/src/views/style.css">
</head>
<body>
    <div class="haupt-container">

        <div class="navigation">
            <div class="logo">
                <img src="/booking-checkout/src/public/img/Logo.png" alt="Booking Logo">
            </div>
            <div class="zurueck">
                <a href="#" class="btn-zurueck">
                    <img src="/booking-checkout/src/public/img/Back.png" alt="Zurück">
                </a>
            </div>
        </div>

       <?php
        $morgen = date('Y-m-d', strtotime('+1 day'));
        $uebermorgen = date('Y-m-d', strtotime('+2 day'));

        $checkinValue = $_SESSION['checkout']['checkin'] ?? $morgen;
        $checkoutValue = $_SESSION['checkout']['checkout'] ?? $uebermorgen;

        if ($checkinValue < $morgen) {
            $checkinValue = $morgen;
        }

        if ($checkoutValue <= $checkinValue) {
            $checkoutValue = date('Y-m-d', strtotime($checkinValue . ' +1 day'));
        }
        ?>

        <form class="content-wrapper" action="/booking-checkout/index.php?step=1" method="post">

            <div class="karten-container">
                
                <section class="reise-karte">
                    <div class="reise-karte-header">
                        <h2 class="titel">Reisedaten</h2>
                        <div class="standort">
                            <img src="/booking-checkout/src/public/img/Location.png" alt="Location Icon">
                            <span><?php echo htmlspecialchars($standortName); ?></span>
                        </div>
                    </div>

                    <div class="eingabe-zeile">

                        <!-- CHECK-IN -->
                        <div class="input-group">
                            <label for="checkin">Check-in Datum</label>
                            <div class="input-wrapper date-wrapper">
                                <input 
                                    type="date" 
                                    id="checkin" 
                                    name="checkin" 
                                    value="<?php echo htmlspecialchars($checkinValue); ?>"
                                    min="<?php echo $morgen; ?>"
                                >
                            </div>

                            <?php if (!empty($_SESSION['errors']['checkin'])): ?>
                                <div class="error-box">
                                    <?php echo $_SESSION['errors']['checkin']; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- CHECK-OUT -->
                        <div class="input-group">
                            <label for="checkout">Check-out Datum</label>
                            <div class="input-wrapper date-wrapper">
                                <input 
                                    type="date" 
                                    id="checkout" 
                                    name="checkout" 
                                    value="<?php echo htmlspecialchars($checkoutValue); ?>"
                                    min="<?php echo date('Y-m-d', strtotime($checkinValue . ' +1 day')); ?>"
                                >
                            </div>

                            <?php if (!empty($_SESSION['errors']['checkout'])): ?>
                                <div class="error-box">
                                    <?php echo $_SESSION['errors']['checkout']; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- ERWACHSENE -->
                        <div class="input-group">
                            <label for="erwachsene">Erwachsene</label>
                            <div class="input-wrapper counter">
                                <input 
                                    type="number" 
                                    id="erwachsene" 
                                    name="erwachsene" 
                                    value="<?php echo $_SESSION['checkout']['erwachsene'] ?? 2; ?>" 
                                    min="2" 
                                    max="10"
                                >
                                <div class="stepper-logic">
                                    <span class="step-up" onclick="adjustValue('erwachsene', 1)"></span>
                                    <span class="step-down" onclick="adjustValue('erwachsene', -1)"></span>
                                </div>
                            </div>

                            <?php if (!empty($_SESSION['errors']['erwachsene'])): ?>
                                <div class="error-box">
                                    <?php echo $_SESSION['errors']['erwachsene']; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- KINDER -->
                        <div class="input-group">
                            <label for="kinder">Kinder</label>
                            <div class="input-wrapper counter">
                                <input 
                                    type="number" 
                                    id="kinder" 
                                    name="kinder" 
                                    value="<?php echo $_SESSION['checkout']['kinder'] ?? 0; ?>" 
                                    min="0" 
                                    max="10"
                                >
                                <div class="stepper-logic">
                                    <span class="step-up" onclick="adjustValue('kinder', 1)"></span>
                                    <span class="step-down" onclick="adjustValue('kinder', -1)"></span>
                                </div>
                            </div>

                            <?php if (!empty($_SESSION['errors']['kinder'])): ?>
                                <div class="error-box">
                                    <?php echo $_SESSION['errors']['kinder']; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </section>

                <div class="karten-container-upgrade">
                    <section class="upgrade-karte-navigation">
                        <div class="button-area-step3">
                            <button type="submit" class="btn-weiter-step3">
                                <span class="btn-prozent-step3">25%</span>
                                <span class="btn-text-step3">Weiter</span>
                                <span class="btn-pfeil-step3">→</span>
                            </button>
                        </div>
                    </section>
                </div>

            </div>
        </form>
    </div>

    <script src="/booking-checkout/src/views/skript.js"></script>

    <?php unset($_SESSION['errors']); ?>
</body>
</html>