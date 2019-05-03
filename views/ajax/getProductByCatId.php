<?php

require '../../../../config/config.inc.php';
require '../../../../init.php';
require '../../classes/getProductByCatId.php';

$getCatId = filter_var($_POST['catId'], FILTER_SANITIZE_NUMBER_INT);

$getProductByCatId = new getProductByCatId($getCatId, 1);

if(is_numeric($getCatId) && $getCatId > 0) {
    foreach($getProductByCatId->productCategory as $product) {
        ?>
        <div>
             <a href="<?php echo $product['link']; ?>">
                <img src="<?php echo $product['coverProduct']['url']; ?>" alt="<?php echo $product['coverProduct']['legend']; ?>" />
            </a>

            <h2 itemprop="name">
                <a href="<?php echo $product['link']; ?>">
                    <?php echo $product['name']; ?>
                </a>
            </h2>

            <div itemprop="description">
                <?php echo $product['description']; ?>
            </div>

            <div>
                <?php echo $product["price"]; ?>
            </div>
        </div>
        <?php
    }

}
else{
    ?>
    <div>No hay productos para esa categoría</div>
    <?php 

}























