<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Checkout - Schritt 2</title>
    <link rel="stylesheet" href="/booking-checkout/src/views/style.css">
</head>
<body>
    <div class="haupt-container">

        <div class="navigation">
            <div class="logo">
                <img src="/booking-checkout/src/public/img/Logo.png" alt="Booking Logo">
            </div>
            <div class="zurueck">
                <a href="/booking-checkout/index.php?step=1" class="btn-zurueck">
                    <img src="/booking-checkout/src/public/img/Back.png" alt="Zurück">
                </a>
            </div>
        </div>

        <form class="content-wrapper" action="/booking-checkout/index.php?step=2" method="post">
            <div class="karten-container">
                
                <section class="reise-karte">
                    <div class="reise-karte-header">
                        <h2 class="titel">Persönliche Daten</h2>
                        <div class="standort">
                            <img src="/booking-checkout/src/public/img/Location.png" alt="Location Icon">
                            <span><?php echo htmlspecialchars($standortName); ?></span>
                        </div>
                    </div>
                    <br>

                    <div class="input-grid">
                        <div class="input-group">
                            <label for="vorname">Vorname <span class="pflichtfeld">*</span></label>
                            <div class="input-field2">
                                <div class="icon-circle">
                                    <img src="/booking-checkout/src/public/img/Account.png" alt="Account-Icon">
                                </div>
                                <input
                                    type="text"
                                    name="vorname"
                                    placeholder="Vorname"
                                    value="<?php echo htmlspecialchars($_SESSION['checkout']['vorname'] ?? ''); ?>"
>
                            </div>
                            <?php if (!empty($_SESSION['errors']['vorname'])): ?>
                                <div class="error-box">
                                    <?php echo $_SESSION['errors']['vorname']; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="input-group">
                            <label for="nachname">Nachname <span class="pflichtfeld">*</span></label>
                            <div class="input-field2">
                                <div class="icon-circle">
                                    <img src="/booking-checkout/src/public/img/Account.png" alt="Account-Icon">
                                </div>
                                <input type="text" id="nachname" name="nachname" placeholder="Nachname"value="<?php echo htmlspecialchars($_SESSION['checkout']['nachname'] ?? ''); ?>">
                            </div>
                            <?php if (!empty($_SESSION['errors']['nachname'])): ?>
                                <div class="error-box">
                                    <?php echo $_SESSION['errors']['nachname']; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="input-group">
                            <label for="email">E-Mail-Adresse <span class="pflichtfeld">*</span></label>
                            <div class="input-field2">
                                <div class="icon-circle">
                                    <img src="/booking-checkout/src/public/img/Letter.png" alt="Account-Icon">
                                </div>
                                <input type="email" id="email" name="email" placeholder="E-Mail" required value="<?php echo htmlspecialchars($_SESSION['checkout']['email'] ?? ''); ?>">
                            </div>
                            <?php if (!empty($_SESSION['errors']['email'])): ?>
                                <div class="error-box">
                                    <?php echo $_SESSION['errors']['email']; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="input-group">
                            <label for="telefon">Telefon <span class="pflichtfeld">*</span></label>
                            <div class="input-field2">
                                <div class="icon-circle">
                                    <img src="/booking-checkout/src/public/img/Phone.png" alt="Account-Icon">
                                </div>
                                <input type="tel" id="telefon" name="telefon" placeholder="Telefon" value="<?php echo htmlspecialchars($_SESSION['checkout']['telefon'] ?? ''); ?>">
                            </div>
                            <?php if (!empty($_SESSION['errors']['telefon'])): ?>
                                <div class="error-box">
                                    <?php echo $_SESSION['errors']['telefon']; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="input-grid">
                        <div class="input-group">
                            <label for="land">Land <span class="pflichtfeld">*</span></label>
                            <div class="input-field2">
                                <div class="icon-circle">
                                    <img src="/booking-checkout/src/public/img/MapMarker.png" alt="Account-Icon">
                                </div>
                                <input type="text" id="land" name="land" placeholder="Land" value="<?php echo htmlspecialchars($_SESSION['checkout']['land'] ?? ''); ?>">
                            </div>
                            <?php if (!empty($_SESSION['errors']['land'])): ?>
                                <div class="error-box">
                                    <?php echo $_SESSION['errors']['land']; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="input-group">
                            <label for="strasse_hausNr">Strasse und Hausnummer <span class="pflichtfeld">*</span></label>
                            <div class="input-field2">
                                <div class="icon-circle">
                                    <img src="/booking-checkout/src/public/img/Address.png" alt="Account-Icon">
                                </div>
                                <input type="text" id="strasse_hausNr" name="strasse_hausNr" placeholder="Strasse und Hausnummer" value="<?php echo htmlspecialchars($_SESSION['checkout']['strasse_hausNr'] ?? ''); ?>">
                            </div>
                            <?php if (!empty($_SESSION['errors']['strasse_hausNr'])): ?>
                                <div class="error-box">
                                    <?php echo $_SESSION['errors']['strasse_hausNr']; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="input-group">
                            <label for="plz">Postleitzahl <span class="pflichtfeld">*</span></label>
                            <div class="input-field2">
                                <div class="icon-circle">
                                    <img src="/booking-checkout/src/public/img/Address.png" alt="Account-Icon">
                                </div>
                                <input type="text" id="plz" name="plz" placeholder="PLZ" value="<?php echo htmlspecialchars($_SESSION['checkout']['plz'] ?? ''); ?>">
                            </div>
                            <?php if (!empty($_SESSION['errors']['plz'])): ?>
                                <div class="error-box">
                                    <?php echo $_SESSION['errors']['plz']; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="input-group">
                            <label for="ort">Ort / Stadt <span class="pflichtfeld">*</span></label>
                            <div class="input-field2">
                                <div class="icon-circle">
                                    <img src="/booking-checkout/src/public/img/HomeAddress.png" alt="Account-Icon">
                                </div>
                                <input type="text" id="ort" name="ort" placeholder="Ort / Stadt" value="<?php echo htmlspecialchars($_SESSION['checkout']['ort'] ?? ''); ?>">
                            </div>
                            <?php if (!empty($_SESSION['errors']['ort'])): ?>
                                <div class="error-box">
                                    <?php echo $_SESSION['errors']['ort']; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <p class="legende"><span class="pflichtfeld">*</span> Pflichtfelder</p>
                </section>

                <div class="karten-container-upgrade">
                    <section class="upgrade-karte-navigation">
                        <div class="button-area-step3">
                            <button type="submit" class="btn-weiter-step3">
                                <span class="btn-prozent-step3">50%</span>
                                <span class="btn-text-step3">Weiter</span>
                                <span class="btn-pfeil-step3">→</span>
                            </button>
                        </div>
                    </section>
                </div>

            </div>
        </form>
    </div>

    <?php unset($_SESSION['errors']); ?>
</body>
</html>