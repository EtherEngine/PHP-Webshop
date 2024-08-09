Webshop

Projektbeschreibung

Ein einfacher Webshop mit PHP, MySQL, HTML, CSS und JavaScript. Das Projekt nutzt das MVC-Entwurfsmuster und beinhaltet eine benutzerfreundliche Oberfläche für die Verwaltung von Produkten und Benutzern.
Inhaltsverzeichnis:

    1.Einführung
    2.Features
    3.Installation
    4.Verwendung
    5.Technologien
    6.Autoren

1. Einführung

Dieses Projekt ist ein Beispiel für einen einfachen Webshop. Es zeigt, wie man mit PHP und MySQL eine E-Commerce-Website erstellen kann. Das Projekt enthält grundlegende Funktionen wie Produktanzeige, Suche, Warenkorb und Benutzerverwaltung. 2. Features

    Produktanzeige mit Bildern und Beschreibungen
    Suchfunktion für Produkte
    Warenkorb mit der Möglichkeit, Produkte hinzuzufügen und zu entfernen
    Benutzerregistrierung und -anmeldung
    Benutzerprofilseite
    Admin-Bereich zur Verwaltung von Produkten und Benutzern
    Zahlungssystemintegration (PayPal, Kreditkarte, Banküberweisung)

3.  Installation
    Voraussetzungen:

        XAMPP oder ein ähnlicher Webserver mit PHP und MySQL
        Webbrowser

Schritte:

    Repository klonen:

    sh

    git clone https://github.com/EtherEngine/Webshop.git

In das Projektverzeichnis wechseln:

    sh

    cd path/to/your/webshop

Projektdateien in das XAMPP-htdocs-Verzeichnis (oder ein ähnliches Verzeichnis deines Webservers) kopieren.

Apache- und MySQL-Server über das XAMPP-Kontrollpanel starten.

Datenbank erstellen und Schema importieren:

    Öffne phpMyAdmin.
    Erstelle eine neue Datenbank namens webshop.
    Importiere die mitgelieferte SQL-Datei db_schema.sql, um die benötigten Tabellen und Daten zu erstellen:
        Kommandozeile:

        sh

        mysql -u [username] -p webshop < db_schema.sql

        phpMyAdmin:
            Wähle die neu erstellte webshop-Datenbank aus.
            Navigiere zum Tab "Import" und lade die db_schema.sql-Datei hoch.

Datenbankverbindung konfigurieren:

    Bearbeite die Datei config/db_connect.php und passe die Datenbankzugangsdaten an:

    php

        <?php
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=webshop', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            die('Verbindung zur Datenbank fehlgeschlagen: ' . $e->getMessage());
        }
        ?>

4. Verwendung

   Webshop Startseite:
   Öffne deinen Webbrowser und navigiere zu http://localhost/webshop/public/index.php.

   Benutzerregistrierung:
   Klicke auf "Registrieren" und fülle das Formular aus, um ein neues Benutzerkonto zu erstellen.

   Produkte durchsuchen:
   Verwende die Suchleiste auf der Startseite, um nach Produkten zu suchen.
   Klicke auf ein Produktbild, um die Produktdetails anzuzeigen.

   Produkte zum Warenkorb hinzufügen:
   Klicke auf das Plus-Symbol (+) auf einem Produkt, um es deinem Warenkorb hinzuzufügen.
   Verwende das Popup-Fenster, um die Anzahl der Produkte anzugeben.

   Warenkorb anzeigen und bearbeiten:
   Klicke auf das Warenkorb-Symbol in der Navigation, um deinen Warenkorb anzuzeigen.
   Ändere die Produktmengen oder entferne Produkte aus dem Warenkorb.

   Checkout:
   Klicke auf "Zur Kasse", um zur Zahlungsseite zu gelangen.
   Wähle eine Zahlungsmethode aus und folge den Anweisungen zur Zahlung.

5. Technologien

   PHP
   MySQL
   HTML
   CSS (Bootstrap)
   JavaScript (jQuery)
   FontAwesome

6. Autoren

   Alex F.
