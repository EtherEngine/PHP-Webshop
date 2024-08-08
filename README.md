Webshop - Startseite

Ein vollständiger Webshop mit PHP, MySQL, HTML, CSS und JavaScript. Das Projekt nutzt das MVC-Entwurfsmuster und beinhaltet eine benutzerfreundliche Oberfläche für die Verwaltung von Produkten und Benutzern.
Inhaltsverzeichnis

    Einführung
    Features
    Installation
    Verwendung
    Ordnerstruktur
    Datenbankstruktur
    Technologien
    Autoren

Einführung

Dieses Projekt ist ein Beispiel für einen einfachen Webshop. Es zeigt, wie man mit PHP und MySQL eine E-Commerce-Website erstellen kann. Das Projekt enthält grundlegende Funktionen wie Produktanzeige, Suche, Warenkorb und Benutzerverwaltung.
Features

    Produktanzeige mit Bildern und Beschreibungen
    Suchfunktion für Produkte
    Warenkorb mit der Möglichkeit, Produkte hinzuzufügen und zu entfernen
    Benutzerregistrierung und -anmeldung
    Benutzerprofilseite
    Admin-Bereich zur Verwaltung von Produkten und Benutzern
    Zahlungssystemintegration (PayPal, Kreditkarte, Banküberweisung)

Installation

    Voraussetzungen:
        XAMPP oder ein ähnlicher Webserver mit PHP und MySQL
        Webbrowser

    Schritte:
        Klone das Repository:

        bash

git clone https://github.com/dein-benutzername/webshop.git

Navigiere in das Projektverzeichnis:

bash

        cd webshop

        Kopiere die Projektdateien in das XAMPP-htdocs-Verzeichnis (oder ein ähnliches Verzeichnis deines Webservers).
        Starte den Apache- und MySQL-Server über das XAMPP-Kontrollpanel.
        Erstelle eine Datenbank in phpMyAdmin und importiere die db_schema.sql Datei, um die benötigten Tabellen und Daten zu erstellen.
        Konfiguriere die Datenbankverbindung in config/db_connect.php.

Verwendung

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

#Ordnerstruktur

webshop/
│
├── assets/
│   ├── css/
│   ├── images/
│   └── js/
│
├── config/
│   └── db_connect.php
│
├── public/
│   ├── index.php
│   ├── login.php
│   ├── register.php
│   ├── cart.php
│   └── payment_integration.php
│
├── src/
│   ├── Controller/
│   ├── Model/
│   └── View/
│       └── templates/
│           ├── header.php
│           ├── navigation.php
│           └── footer.php
│
└── db_schema.sql

Datenbankstruktur

    users
        id (INT)
        username (VARCHAR)
        email (VARCHAR)
        password (VARCHAR)
        created_at (TIMESTAMP)

    products
        id (INT)
        name (VARCHAR)
        description (TEXT)
        price (DECIMAL)
        image (VARCHAR)
        created_at (TIMESTAMP)

    cart
        id (INT)
        user_id (INT)
        product_id (INT)
        quantity (INT)

Technologien

    PHP
    MySQL
    HTML
    CSS (Bootstrap)
    JavaScript (jQuery)
    FontAwesome

Autoren

    Alexander Fleischmann
