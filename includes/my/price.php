<?php

class Price {

    public function __construct() {
        return $this;
    }

    public function priceDetailToAccessLevel($productId) {
        if (!$productId) {
            return false;
        }

        session_start();

        $user = $_SESSION['user'];

        if (empty($user)) {
            return false;
        }

        $accesslevel = (int) $user['accesslevel'];

        if (!$accesslevel) {
            return false;
        }

        $strQuery = 'SELECT * FROM price WHERE product_id = ' . $productId . ' AND accesslevel_id = ' . $accesslevel . ' AND status = 1 AND deleted = 0';
        $query = mysql_query($strQuery);

        $row = mysql_fetch_assoc($query);

        if (empty($row)) {
            return false;
        }

        return $row['price'];
    }

    public function priceCatToAccessLevel($cat_id) {
        if (!$cat_id) {
            return false;
        }

        session_start();

        $user = $_SESSION['user'];

        if (empty($user)) {
            return false;
        }

        $accesslevel = (int) $user['accesslevel'];

        if (!$accesslevel) {
            return false;
        }

        //product by cat
        $strQuery = "SELECT * FROM product WHERE ID_danhmuc2 = {$cat_id}";
        $query = mysql_query($strQuery);

        if (!mysql_num_rows($query)) {
            return false;
        }

        while ($row = mysql_fetch_assoc($query)) {
            $arrProd[] = $row;
        }

        if (empty($arrProd)) {
            return false;
        }

        $arrProdId = array_column($arrProd, 'ID_product');

        $strQuery = 'SELECT * FROM price WHERE product_id IN (' . implode(',', $arrProdId) . ') AND accesslevel_id = ' . $accesslevel . ' AND status = 1 AND deleted = 0';
        $query = mysql_query($strQuery);

        while ($row = mysql_fetch_assoc($query)) {
            $arrPrice[$row['product_id']] = $row['price'];
        }

        return $arrPrice;
    }

    public function productCartToAccessLevel() {
        session_start();

        $user = $_SESSION['user'];
        $cart = $_SESSION['cart'][$user['ID_account']];

        if (empty($user) || empty($cart)) {
            return false;
        }

        $accesslevel = (int) $user['accesslevel'];
        $arrProd = $cart['arrProd'];

        if (!$accesslevel || empty($arrProd)) {
            return false;
        }
        
        $arrProdId = array_keys($arrProd);

        //get list product
        $strQuery = "SELECT * FROM product WHERE ID_product IN (" . implode(',', $arrProdId) . ")";
        $query = mysql_query($strQuery);

        if (!mysql_num_rows($query)) {
            return false;
        }

        while ($row = mysql_fetch_assoc($query)) {
            $listProd[] = $row;
        }

        if (empty($listProd)) {
            return false;
        }

        //get list price
        $strQuery = 'SELECT * FROM price WHERE product_id IN (' . implode(',', $arrProdId) . ') AND accesslevel_id = ' . $accesslevel . ' AND status = 1 AND deleted = 0';
        $query = mysql_query($strQuery);

        while ($row = mysql_fetch_assoc($query)) {
            $arrPrice[$row['product_id']] = $row['price'];
        }

        //prepare data
        foreach($listProd as &$item){
            $priceAccessLevel = isset($arrPrice[$item['ID_product']]) ? $arrPrice[$item['ID_product']] : $item['productprice'];
            
            $item['price_access_level'] = $priceAccessLevel;
        }
        
        return $listProd;
    }
    
    public function p($p){
        echo '<pre>';
        print_r($p);die;
    }

}
