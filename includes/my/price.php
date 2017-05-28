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

        //prepare data product in session
        $arrProdPrepare = [];

        foreach ($arrProd as $productId => $arrItem) {

            foreach ($arrItem as $typeId => $item) {
                $_key = $productId . '-' . $typeId;

                $arrProdPrepare[$_key]['sl'] = $item['sl'];
            }
        }

        //get list product
        $strQuery = "SELECT * FROM product as p WHERE p.ID_product IN (" . implode(',', $arrProdId) . ")";
        $query = mysql_query($strQuery);

        if (!mysql_num_rows($query)) {
            return false;
        }

        while ($row = mysql_fetch_assoc($query)) {
            $listProd[$row['ID_product']] = $row;
        }
//        echo '<pre>';print_r($arrProdPrepare);die;
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
//        foreach ($listProd as &$item) {
//            $priceAccessLevel = isset($arrPrice[$item['ID_product']]) ? $arrPrice[$item['ID_product']] : $item['productprice'];
//
//            $item['price_access_level'] = $priceAccessLevel;
//            $item['qty_cart'] = (int) $arrProd[$item['ID_product']][$item['ID_type_menubar2']]['sl'];
//        }

        $arrDataCart = [];
        foreach ($arrProdPrepare as $key => $item) {
            list($_productId, $_typeId) = explode('-', $key);
            $_item = $listProd[$_productId];

            $priceAccessLevel = isset($arrPrice[$_item['ID_product']]) ? $arrPrice[$_item['ID_product']] : $_item['productprice'];

            $_item['price_access_level'] = $priceAccessLevel;
            $_item['qty_cart'] = (int) $item['sl'];
            $_item['ID_type_menubar2'] = $_typeId;

            $arrDataCart[] = $_item;
        }
//echo '<pre>';print_r($arrDataCart);die;
        return $arrDataCart;
    }

    public function priceMultiAccessLevel($arrProdId) {
        if (empty($arrProdId)) {
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

        $strQuery = 'SELECT * FROM price WHERE product_id IN (' . implode(',', $arrProdId) . ') AND accesslevel_id = ' . $accesslevel . ' AND status = 1 AND deleted = 0';
        $query = mysql_query($strQuery);

        while ($row = mysql_fetch_assoc($query)) {
            $arrPrice[$row['product_id']] = $row['price'];
        }

        return $arrPrice;
    }

    public function p($p) {
        echo '<pre>';
        print_r($p);
        die;
    }

}
