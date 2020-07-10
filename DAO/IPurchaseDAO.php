<?php

    namespace DAO;

    use Models\Purchase as Purchase;

    interface IPurchaseDAO 
    {
        function add(Purchase $purchase);
        function getAll();
        function remove($id);
        function getAllOrderByOldest();
        function getAllOrderByNewest();
        function getByGenre($idGenre);
    }

?>