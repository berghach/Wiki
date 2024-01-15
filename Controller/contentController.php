<?php

require_once('Model\categoryModel.php');
require_once('Model/tagModel.php');
require_once('Model/wikiModel.php');
require_once('Model/userModel.php');

class ContentController{
    function getContent(){
        $categoryDAO = new categoryDAO();
        $categories = $categoryDAO->getCategories();

        $tagDAO = new tagDAO();
        $tags = $tagDAO->getTags();

        $wikiDAO = new wikiDAO();
        $wikis = $wikiDAO->get_activeWikies();

        $userDAO = new userDAO();
        $authors = $userDAO->getAuthors();


        include('View\home.php');
    }
    
}
