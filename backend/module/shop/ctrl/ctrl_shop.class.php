<?php
    class ctrl_shop {

        function list_products() {
            echo json_encode(common::load_model('shop_model', 'get_list_products'));
        }

        function list_filtersHome_products() {
            echo json_encode(common::load_model('shop_model', 'get_list_filtersHome_products', $_POST['filters']));
        }

        function list_filtersShop_products() {
            echo json_encode(common::load_model('shop_model', 'get_list_filtersShop_products', $_POST['filters']));
        }

        function list_filtersSearch_products() {
            echo json_encode(common::load_model('shop_model', 'get_list_filtersSearch_products', $_POST['filters']));
        }

        function pagination() {
            echo json_encode(common::load_model('shop_model', 'get_pagination'));
        }

        function pagination_filters() {
            echo json_encode(common::load_model('shop_model', 'get_pagination_filters', [$_POST['brand'], $_POST['kilometros'], $_POST['type'], 
                                                                                        $_POST['setting'], $_POST['category'], $_POST['order']]));
        }

        function details() {
            echo json_encode(common::load_model('shop_model', 'get_details', $_POST['id']));
        }

        function count_more_related() {
            echo json_encode(common::load_model('shop_model', 'get_count_more_related', [$_POST['id'], $_POST['category']]));
        }

        function more_related() {
            echo json_encode(common::load_model('shop_model', 'get_more_related', [$_POST['id'], $_POST['category']]));
        }

        function load_like() {
            echo json_encode(common::load_model('shop_model', 'get_load_like', $_POST['token']));
        }

        function click_like() {
            echo json_encode(common::load_model('shop_model', 'get_click_like', [$_POST['id'], $_POST['token']]));
        }

        function count_search_Menu() {
            echo json_encode(common::load_model('shop_model','get_count_search_menu',[$_POST['brand_search'],$_POST['category_search'], $_POST['autocom_search']]));
        }
    }
?>