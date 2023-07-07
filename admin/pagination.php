<?php 
    $items = [];
    $pagSize = 4;
    validate('page', 'get', '', $pagOffset);

    if ($pagOffset == NULL) {
        $pagOffset = 0;
    }


    function getPagSize(){
        global $items, $pagSize;

        return count($items) / $pagSize;
    }

    function getPag() {
        global $items, $pagOffset, $pagSize;

        return array_slice($items, $pagOffset * $pagSize, $pagSize);
    }
?>