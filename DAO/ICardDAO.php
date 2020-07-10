<?php

    namespace DAO;

    interface ICardDAO 
    {
        function add(Card $card);
        function getCard($id);
        function remove($id);
    }

?>