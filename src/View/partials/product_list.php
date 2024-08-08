<?php
$products_per_page = 10;
$total_products = count($products);
$total_pages = ceil($total_products / $products_per_page);

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $products_per_page;

$products_to_display = array_slice($products, $start, $products_per_page);

foreach ($products_to_display as $product) {
    echo '<div class="product">';
    echo '<h2>' . $product['name'] . '</h2>';
    echo '<p>' . $product['description'] . '</p>';
    echo '<p>' . $product['price'] . ' €</p>';
    echo '<img src="assets/images/' . $product['image'] . '" alt="' . $product['name'] . '">';
    echo '</div>';
}
?>

<div class="pagination">
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>
</div>