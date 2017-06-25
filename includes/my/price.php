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

        if ($row) {
            return $row['price'];
        }

        //if not get price accesslevel => get price public
        $strQuery = 'SELECT * FROM product WHERE ID_product = ' . $productId;
        $query = mysql_query($strQuery);

        $row = mysql_fetch_assoc($query);

        if (empty($row)) {
            return false;
        }

        return $row['productprice'];
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
            $arrProd[$row['ID_product']] = $row;
        }

        if (empty($arrProd)) {
            return false;
        }

        $arrProdId = array_column($arrProd, 'ID_product');

        $strQuery = 'SELECT * FROM price WHERE product_id IN (' . implode(',', $arrProdId) . ') AND accesslevel_id = ' . $accesslevel . ' AND status = 1 AND deleted = 0';
        $query = mysql_query($strQuery);

        //if not get price accesslevel => get price public
        if (mysql_num_rows($query) == 0) {

            foreach ($arrProd as $ID_product => $prod) {
                $arrPrice[$ID_product] = $prod['productprice'];
            }

            return $arrPrice;
        }

        while ($row = mysql_fetch_assoc($query)) {
            $arrProdPrice[$row['product_id']] = $row;
        }

        foreach ($arrProd as $ID_product => $prod) {
            $price = isset($arrProdPrice[$ID_product]) ? $arrProdPrice[$ID_product]['price'] : $prod['productprice'];

            $arrPrice[$ID_product] = $price;
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

        foreach ($arrProd as $productId => $strType) {

            foreach ($strType as $_strType => $item) {
                $_key = $productId . '-' . $_strType;

                $arrProdPrepare[$_key]['sl'] = $item['sl'];
            }
        }
//echo '<pre>';print_r($arrProdPrepare);die;
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
            $__arr = explode('-', $key);
            $_productId = array_shift($__arr);
            $_item = $listProd[$_productId];

            $priceAccessLevel = isset($arrPrice[$_item['ID_product']]) ? $arrPrice[$_item['ID_product']] : $_item['productprice'];
//            $priceAccessLevel = $arrPrice[$_item['ID_product']];

            $_item['price_access_level'] = $priceAccessLevel;
            $_item['qty_cart'] = (int) $item['sl'];
            $_item['arr_ID_type_menubar2'] = $__arr;

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

        $strQuery = 'SELECT * FROM product WHERE ID_product IN (' . implode(',', $arrProdId) . ')';
        $query = mysql_query($strQuery);

        if (!mysql_num_rows($query)) {
            return false;
        }

        while ($row = mysql_fetch_assoc($query)) {
            $arrProd[$row['ID_product']] = $row;
        }

        $strQuery = 'SELECT * FROM price WHERE product_id IN (' . implode(',', $arrProdId) . ') AND accesslevel_id = ' . $accesslevel . ' AND status = 1 AND deleted = 0';
        $query = mysql_query($strQuery);

        //if not get price accesslevel => get price public
        if (mysql_num_rows($query) == 0) {

            foreach ($arrProd as $ID_product => $prod) {
                $arrPrice[$ID_product] = $prod['productprice'];
            }

            return $arrPrice;
        }
        
        while ($row = mysql_fetch_assoc($query)) {
            $arrProdPrice[$row['product_id']] = $row;
        }

        foreach ($arrProd as $ID_product => $prod) {
            $price = isset($arrProdPrice[$ID_product]) ? $arrProdPrice[$ID_product]['price'] : $prod['productprice'];

            $arrPrice[$ID_product] = $price;
        }

        return $arrPrice;
    }

    public function p($p) {
        echo '<pre>';
        print_r($p);
        die;
    }

}
