<?php


class getProductByCatId {
    
    public $productCategory;
    
    public function __construct($_catId, $_numProducts) {
        $this->productCategory = $this->getLastProductByCatId($_catId, $_numProducts);
        
    }
    
    private function getLastProductByCatId($_catId, $_numProducts) {
        $getProducts = null;
        if(is_numeric($_catId) && $_catId > 0) {
            $languageId = (int)Context::getContext()->language->id;
            $category = new Category($_catId);
            $getProducts = $category->getProducts($languageId, 1, $_numProducts);
            foreach($getProducts as $key => $val) {
                $singleProduct = new ProductCore($val['id_product'], true, $languageId);
                $currency = new Currency(Context::getContext()->cookie->id_currency, $languageId);
                $getProducts[$key]['price'] = Tools::convertPrice($val['price'], Context::getContext()->currency,
                    true, Context::getContext()) . ' ' . $currency->sign;
                $cover =  $singleProduct->getCover($val['id_product']);
                if (sizeof($cover["id_image"]) && $cover["id_image"] > 0) { 
                    $image = new Image($cover['id_image']);
                    $getProducts[$key]['coverProduct']['legend'] = isset($image->lengend[1]) 
                        && !empty($image->lengend[1]) ? $image->legend[1] : $val['name'];
                    $getProducts[$key]['coverProduct']['url'] = _PS_BASE_URL_._THEME_PROD_DIR_
                        .$image->getExistingImgPath().'.'.$image->image_format;
                                 
                }
               
            }  
        }
        
        return $getProducts;

    }
}
