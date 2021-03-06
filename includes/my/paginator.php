<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Paginator {

    private $_limit;
    private $_page;
    private $_query;
    private $_total;

    public function __construct($query) {

        $this->_query = $query;

        $rs = mysql_query($this->_query);
        $this->_total = mysql_num_rows($rs);
    }

    public function getData($limit = 10, $page = 1) {

        $this->_limit = $limit;
        $this->_page = $page;

        if ($this->_limit == 'all') {
            $query = $this->_query;
        } else {
            $query = $this->_query . " LIMIT " . ( ( $this->_page - 1 ) * $this->_limit ) . ", $this->_limit";
        }
//        echo $query;die;
        $rs = mysql_query($query);

        while ($row = mysql_fetch_assoc($rs)) {
            $results[] = $row;
        }

        $result = new stdClass();
        $result->page = $this->_page;
        $result->limit = $this->_limit;
        $result->total = $this->_total;
        $result->data = $results;

        return $result;
    }

    public function createLinks($links, $list_class) {
        if ($this->_limit == 'all') {
            return '';
        }

        list($a, $location, $c) = explode('/', $_SERVER['SCRIPT_NAME']);

        if ($location == 'admincp') {

            $isSearch = $_GET['isSearch'];
            $url = '?';

            if ($isSearch) {
                $url = $_SERVER['REQUEST_URI'] . '&';
            }
        } else if ($location == 'product.php' && isset($_GET['cat'])) {

            $url = $_SERVER['REQUEST_URI'] . '&';
        } else {
            
            $url = '?';
        }

        $last = ceil($this->_total / $this->_limit);

        $start = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;
        $end = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;

        $html = '<ul class="' . $list_class . '">';

        $class = ( $this->_page == 1 ) ? "disabled" : "";
        $html .= '<li class="' . $class . '"><a href="' . $url . 'limit=' . $this->_limit . '&page=' . ( $this->_page - 1 ) . '">&laquo;</a></li>';

        if ($start > 1) {
            $html .= '<li><a href="' . $url . 'limit=' . $this->_limit . '&page=1">1</a></li>';
            $html .= '<li class="disabled"><span>...</span></li>';
        }

        for ($i = $start; $i <= $end; $i++) {
            $class = ( $this->_page == $i ) ? "active" : "";
            $html .= '<li class="' . $class . '"><a href="' . $url . 'limit=' . $this->_limit . '&page=' . $i . '">' . $i . '</a></li>';
        }

        if ($end < $last) {
            $html .= '<li class="disabled"><span>...</span></li>';
            $html .= '<li><a href="' . $url . 'limit=' . $this->_limit . '&page=' . $last . '">' . $last . '</a></li>';
        }

        $class = ( $this->_page == $last ) ? "disabled" : "";
        $html .= '<li class="' . $class . '"><a href="?limit=' . $this->_limit . '&page=' . ( $this->_page + 1 ) . '">&raquo;</a></li>';

        $html .= '</ul>';

        return $html;
    }

}
