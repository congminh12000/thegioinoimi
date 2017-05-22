<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../Connections/cnn_hoaly.php');
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);

$arrResp = [
    'isError' => true,
    'message' => 'Error',
    'data' => []
];

if ($_GET) {

    $orderId = (int) $_GET['orderId'];

    if (!$orderId) {
        echo json_encode($arrResp);
        die;
    }

    $strQuery = "SELECT * FROM order_item as oi LEFT JOIN product as p ON oi.ID_product = p.ID_product WHERE ID_order = {$orderId}";
    $query = mysql_query($strQuery);
    $table = '<table class="table table-hover">'
            . '<thead>'
                       .'                 <tr>'
                                            .'<th>Tên sản phẩm</th>'
                                            .'<th>Số lượng</th>'
                                            .'<th>Đơn giá</th>'
                                            .'<th>Thành tiền</th>'
                                        .'</tr>'
                                    .'</thead>'
                                    .'<tbody>';
    
    if (mysql_num_rows($query)) {
        
        while ($row = mysql_fetch_assoc($query)) {
            $table .= '<tr>'
                    . '<td>' . $row['productname'] . '</td>'
                    . '<td>' . $row['qty_ordered'] . '</td>'
                    . '<td>' . $row['price_access_level'] . '</td>'
                    . '<td>' . $row['grand_total'] . ' đ</td>'
                    . '</tr>';
        }
    } else {
        $table .= '<tr><td class="text-center" colspan="100">Không có sản phẩm nào !</td></tr>';
    }


    $table .= '</tbody>';
    $table .= '<table>';

    $arrResp = [
        'isError' => false,
        'message' => 'Success',
        'data' => [
            'detailHtml' => $table
        ]
    ];
}

echo json_encode($arrResp);
die;
