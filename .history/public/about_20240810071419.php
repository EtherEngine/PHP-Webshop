<?php
session_start();
require __DIR__ . '/../config/db_connect.php';
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Über uns</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <?php
    include '../src/View/templates/header.php';
    include '../src/View/templates/navigation.php';
    ?>

    <div class="container">
        <h1 class="text-center">Über uns</h1>
        <div class="content">
            <p>Willkommen bei Visionary Minds, einem innovativen Unternehmen, das sich der Entwicklung und Vermarktung
                modernster Produkte mit Künstlicher Intelligenz (KI) widmet. Unsere Mission ist es, durch den Einsatz
                fortschrittlicher Technologien das Leben unserer Kunden zu verbessern und gleichzeitig den höchsten
                Qualitätsstandards treu zu bleiben, für die Deutschland weltweit bekannt ist. Unser Engagement für
                Innovation, Präzision und Nachhaltigkeit prägt unsere tägliche Arbeit und spiegelt sich in jedem unserer
                Produkte wider.</p>
            <h2>Geschichte und Werte</h2>
            <p>Gegründet im Jahr 2020 von einer Gruppe passionierter Ingenieure, Wissenschaftler und Unternehmer, hat
                sich Visionary Minds schnell zu einem führenden Unternehmen im Bereich KI-gestützter Produkte
                entwickelt. Unser Hauptsitz befindet sich in München, einem Zentrum für Technologie und Innovation in
                Europa. Unsere Werte basieren auf Exzellenz, Integrität und sozialer Verantwortung. Wir glauben fest
                daran, dass Technologie nur dann wirklich sinnvoll ist, wenn sie das Leben der Menschen verbessert und
                gleichzeitig die Umwelt schont.</p>
            <h2>Produkte und Dienstleistungen</h2>
            <p>Visionary Minds bietet eine breite Palette von Produkten an, die alle von KI-Technologien profitieren.
                Unsere Hauptproduktkategorien umfassen:</p>
            <ul>
                <li><strong>Smart Home Geräte:</strong> Unsere intelligenten Haushaltsgeräte, wie z.B. der AI-Assisted
                    Home Hub, revolutionieren das Wohnen. Mit Sprachsteuerung, lernfähigen Algorithmen und nahtloser
                    Integration in bestehende Systeme bieten wir Lösungen, die den Alltag erleichtern und sicherer
                    machen.</li>
                <li><strong>Gesundheitstechnologien:</strong> In der Gesundheitsbranche setzen wir auf personalisierte
                    Medizinprodukte. Unser AI-Health Monitor analysiert kontinuierlich Vitaldaten und liefert präzise
                    Gesundheitsprognosen, die auf individuellen Mustern basieren. Diese Technologien helfen, Krankheiten
                    frühzeitig zu erkennen und personalisierte Behandlungspläne zu erstellen.</li>
                <li><strong>Mobilitätslösungen:</strong> Unsere autonomen Fahrzeuge und intelligenten Verkehrssysteme
                    nutzen fortschrittliche KI, um den Verkehr zu optimieren und die Sicherheit zu erhöhen. Das
                    AI-Driven Car von Visionary Minds bietet eine Kombination aus autonomem Fahren und intelligentem
                    Energiemanagement, um eine umweltfreundliche und effiziente Mobilität zu gewährleisten.</li>
                <li><strong>Industrielle Anwendungen:</strong> Im Bereich der Industrieautomation bieten wir Lösungen
                    wie den AI-Optimized Manufacturing Assistant, der Produktionsprozesse überwacht und optimiert, um
                    Effizienz und Qualität zu maximieren. Unsere KI-gestützten Roboter sind in der Lage, komplexe
                    Aufgaben auszuführen und gleichzeitig die Sicherheit der Arbeiter zu erhöhen.</li>
            </ul>
            <h2>Forschung und Entwicklung</h2>
            <p>Unsere Abteilung für Forschung und Entwicklung (F&E) ist das Herzstück von Visionary Minds. Hier arbeiten
                einige der besten Köpfe aus den Bereichen KI, Ingenieurwesen und Design zusammen, um die Technologien
                von morgen zu entwickeln. Wir investieren jährlich einen erheblichen Teil unseres Umsatzes in F&E, um
                sicherzustellen, dass wir stets an der Spitze der technologischen Entwicklung stehen. Unsere
                Partnerschaften mit führenden Universitäten und Forschungseinrichtungen weltweit ermöglichen es uns,
                neueste wissenschaftliche Erkenntnisse schnell in marktfähige Produkte umzusetzen.</p>
            <h2>Nachhaltigkeit und Verantwortung</h2>
            <p>Nachhaltigkeit ist ein zentraler Bestandteil unserer Unternehmensstrategie. Wir setzen auf
                umweltfreundliche Materialien und Produktionsprozesse, um unseren ökologischen Fußabdruck zu minimieren.
                Unser Ziel ist es, durch innovative Technologien zur Lösung globaler Umweltprobleme beizutragen. Darüber
                hinaus engagieren wir uns in verschiedenen sozialen Projekten und unterstützen Bildungsinitiativen, um
                die nächste Generation von Wissenschaftlern und Ingenieuren zu fördern.</p>
            <h2>Kundenservice und Qualitätssicherung</h2>
            <p>Bei Visionary Minds steht der Kunde im Mittelpunkt. Wir bieten einen umfassenden Kundenservice, der weit
                über den Kauf hinausgeht. Unser Support-Team ist rund um die Uhr verfügbar, um bei Fragen und Problemen
                zu helfen. Unsere Produkte durchlaufen strenge Qualitätskontrollen und Tests, um sicherzustellen, dass
                sie den höchsten Standards entsprechen. Wir bieten zudem umfangreiche Garantie- und Rückgaberegelungen,
                um unseren Kunden maximale Sicherheit und Zufriedenheit zu gewährleisten.</p>
            <h2>Zukunftsvision</h2>
            <p>Unsere Vision ist es, durch die Integration von KI in alltägliche Produkte und Dienstleistungen eine
                smartere und nachhaltigere Zukunft zu gestalten. Wir streben danach, in allen unseren Tätigkeitsfeldern
                Pionierarbeit zu leisten und dabei stets die Bedürfnisse unserer Kunden und die Anforderungen der Umwelt
                im Blick zu behalten. Mit einem klaren Fokus auf Innovation, Qualität und Nachhaltigkeit wollen wir
                weiterhin die Entwicklung neuer Technologien vorantreiben und gleichzeitig unseren Beitrag zu einer
                besseren Welt leisten.</p>
            <h2>Kontakt</h2>
            <p>Wir freuen uns darauf, von Ihnen zu hören! Wenn Sie Fragen haben oder mehr über unsere Produkte und
                Dienstleistungen erfahren möchten, können Sie uns jederzeit kontaktieren. Unser Team steht Ihnen mit Rat
                und Tat zur Seite. Besuchen Sie uns in unserem Hauptsitz in München oder erreichen Sie uns über unsere
                Website und sozialen Medien.</p>
            <p>Vielen Dank für Ihr Interesse an Visionary Minds. Wir sind stolz darauf, innovative Lösungen "Made in
                Germany" zu liefern, die das Leben unserer Kunden bereichern und die Welt ein Stück besser machen.</p>
            <p><strong>Adresse:</strong><br> Visionary Minds GmbH<br> Innovationsstraße 1<br> 80333 München<br>
                Deutschland</p>
            <p><strong>Telefon:</strong> +49 89 1234567<br> <strong>E-Mail:</strong> info@visionaryminds.de<br>
                <strong>Website:</strong> www.visionaryminds.de
            </p>
        </div>
    </div>

    <?php include '../src/View/templates/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>