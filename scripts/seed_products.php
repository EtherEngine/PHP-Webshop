<?php

require __DIR__ . '/../config/db_connect.php';

$products = [
    ['name' => 'Produkt A', 'description' => 'Ein fantastisches Produkt für den täglichen Gebrauch.', 'price' => 49.99, 'image' => 'product_a.png'],
    ['name' => 'Produkt B', 'description' => 'Dieses Produkt bietet eine hervorragende Leistung.', 'price' => 59.99, 'image' => 'product_b.png'],
    ['name' => 'Produkt C', 'description' => 'Hochwertige Materialien für eine lange Lebensdauer.', 'price' => 69.99, 'image' => 'product_c.png'],
    ['name' => 'Produkt D', 'description' => 'Ergonomisches Design für maximalen Komfort.', 'price' => 79.99, 'image' => 'product_d.png'],
    ['name' => 'Produkt E', 'description' => 'Modernste Technologie in einem eleganten Gehäuse.', 'price' => 89.99, 'image' => 'product_e.png'],
    ['name' => 'Produkt F', 'description' => 'Zuverlässig und effizient für den täglichen Einsatz.', 'price' => 99.99, 'image' => 'product_f.png'],
    ['name' => 'Produkt G', 'description' => 'Ein vielseitiges Produkt für alle Situationen.', 'price' => 109.99, 'image' => 'product_g.png'],
    ['name' => 'Produkt H', 'description' => 'Kompakt und leicht, ideal für unterwegs.', 'price' => 119.99, 'image' => 'product_h.png'],
    ['name' => 'Produkt I', 'description' => 'Ausgezeichnetes Preis-Leistungs-Verhältnis.', 'price' => 129.99, 'image' => 'product_i.png'],
    ['name' => 'Produkt J', 'description' => 'Innovatives Design und erstklassige Qualität.', 'price' => 139.99, 'image' => 'product_j.png'],
    ['name' => 'Produkt K', 'description' => 'Hohe Leistung und geringer Energieverbrauch.', 'price' => 149.99, 'image' => 'product_k.png'],
    ['name' => 'Produkt L', 'description' => 'Perfekt für den Einsatz zu Hause oder im Büro.', 'price' => 159.99, 'image' => 'product_l.png'],
    ['name' => 'Produkt M', 'description' => 'Einfache Bedienung und hohe Zuverlässigkeit.', 'price' => 169.99, 'image' => 'product_m.png'],
    ['name' => 'Produkt N', 'description' => 'Hervorragende Funktionalität und Benutzerfreundlichkeit.', 'price' => 179.99, 'image' => 'product_n.png'],
    ['name' => 'Produkt O', 'description' => 'Robust und langlebig für den intensiven Gebrauch.', 'price' => 189.99, 'image' => 'product_o.png'],
    ['name' => 'Produkt P', 'description' => 'Kompaktes Design mit großartiger Leistung.', 'price' => 199.99, 'image' => 'product_p.png'],
    ['name' => 'Produkt Q', 'description' => 'Ideal für professionelle Anwendungen.', 'price' => 209.99, 'image' => 'product_q.png'],
    ['name' => 'Produkt R', 'description' => 'Hohe Präzision und exzellente Verarbeitung.', 'price' => 219.99, 'image' => 'product_r.png'],
    ['name' => 'Produkt S', 'description' => 'Leistungsstark und einfach zu bedienen.', 'price' => 229.99, 'image' => 'product_s.png'],
    ['name' => 'Produkt T', 'description' => 'Modernes Design und innovative Technik.', 'price' => 239.99, 'image' => 'product_t.png'],
    ['name' => 'Produkt U', 'description' => 'Hochwertige Materialien für eine lange Lebensdauer.', 'price' => 249.99, 'image' => 'product_u.png'],
    ['name' => 'Produkt V', 'description' => 'Ein Muss für jeden Haushalt.', 'price' => 259.99, 'image' => 'product_v.png'],
    ['name' => 'Produkt W', 'description' => 'Kompakt und leistungsstark zugleich.', 'price' => 269.99, 'image' => 'product_w.png'],
    ['name' => 'Produkt X', 'description' => 'Erstklassige Qualität zum fairen Preis.', 'price' => 279.99, 'image' => 'product_x.png'],
    ['name' => 'Produkt Y', 'description' => 'Ein zuverlässiges Produkt für den täglichen Gebrauch.', 'price' => 289.99, 'image' => 'product_y.png'],
    ['name' => 'Produkt Z', 'description' => 'Modernes Design und robuste Bauweise.', 'price' => 299.99, 'image' => 'product_z.png'],
    ['name' => 'Produkt AA', 'description' => 'Ein vielseitiges Produkt für jeden Bedarf.', 'price' => 309.99, 'image' => 'product_aa.png'],
    ['name' => 'Produkt BB', 'description' => 'Leicht und einfach zu handhaben.', 'price' => 319.99, 'image' => 'product_bb.png'],
    ['name' => 'Produkt CC', 'description' => 'Ideal für den Einsatz unterwegs.', 'price' => 329.99, 'image' => 'product_cc.png'],
    ['name' => 'Produkt DD', 'description' => 'Hohe Leistung und Effizienz.', 'price' => 339.99, 'image' => 'product_dd.png'],
    ['name' => 'Produkt EE', 'description' => 'Einfaches und benutzerfreundliches Design.', 'price' => 349.99, 'image' => 'product_ee.png'],
    ['name' => 'Produkt FF', 'description' => 'Perfekt für den Einsatz im Büro.', 'price' => 359.99, 'image' => 'product_ff.png'],
    ['name' => 'Produkt GG', 'description' => 'Langlebig und zuverlässig.', 'price' => 369.99, 'image' => 'product_gg.png'],
    ['name' => 'Produkt HH', 'description' => 'Ein großartiges Produkt zu einem großartigen Preis.', 'price' => 379.99, 'image' => 'product_hh.png'],
    ['name' => 'Produkt II', 'description' => 'Hohe Qualität und modernes Design.', 'price' => 389.99, 'image' => 'product_ii.png'],
    ['name' => 'Produkt JJ', 'description' => 'Ein vielseitiges Produkt für den täglichen Gebrauch.', 'price' => 399.99, 'image' => 'product_jj.png'],
    ['name' => 'Produkt KK', 'description' => 'Ein Muss für jeden Haushalt.', 'price' => 409.99, 'image' => 'product_kk.png'],
    ['name' => 'Produkt LL', 'description' => 'Zuverlässig und effizient.', 'price' => 419.99, 'image' => 'product_ll.png'],
    ['name' => 'Produkt MM', 'description' => 'Ideal für den intensiven Einsatz.', 'price' => 429.99, 'image' => 'product_mm.png'],
    ['name' => 'Produkt NN', 'description' => 'Hochwertige Verarbeitung und langlebig.', 'price' => 439.99, 'image' => 'product_nn.png'],
    ['name' => 'Produkt OO', 'description' => 'Ein Produkt, das hält, was es verspricht.', 'price' => 449.99, 'image' => 'product_oo.png'],
    ['name' => 'Produkt PP', 'description' => 'Modern und leistungsstark.', 'price' => 459.99, 'image' => 'product_pp.png'],
    ['name' => 'Produkt QQ', 'description' => 'Ein großartiges Produkt für den täglichen Gebrauch.', 'price' => 469.99, 'image' => 'product_qq.png'],
    ['name' => 'Produkt RR', 'description' => 'Ergonomisches Design und hohe Leistung.', 'price' => 479.99, 'image' => 'product_rr.png'],
    ['name' => 'Produkt SS', 'description' => 'Hohe Qualität und hervorragende Leistung.', 'price' => 489.99, 'image' => 'product_ss.png'],
    ['name' => 'Produkt TT', 'description' => 'Ein vielseitiges und zuverlässiges Produkt.', 'price' => 499.99, 'image' => 'product_tt.png'],
];

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare('INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)');

    foreach ($products as $product) {
        $stmt->execute([$product['name'], $product['description'], $product['price'], $product['image']]);
    }

    $pdo->commit();
    echo "50 Produkte erfolgreich hinzugefügt.";
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Fehler beim Hinzufügen der Produkte: " . $e->getMessage();
}
?>