<?php
    class ctrl_search {
        function categoria() {
            echo json_encode(common::load_model('search_model', 'get_categoria'));
        }

        function brand() {
            echo json_encode(common::load_model('search_model', 'get_brand', $_POST['category']));
        }
        
        function autocomplete() {
            echo json_encode(common::load_model('search_model', 'get_autocomplete', [$_POST['category'], $_POST['brand'], $_POST['autocomplete']]));
        }
    }
?>
