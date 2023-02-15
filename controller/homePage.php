<?php

class HomePageController extends Controller {
    function defaultAction() {

        $dbh = DatabaseConnection::getInstance();
        $dbc = $dbh->getConnection();

        $pageObj = new Page($dbc);
        $pageObj->findById(1);

        $variables['pageObj'] = $pageObj;

        
        $template = new Template('default');
        
        $template->view('static-page', $variables);
    }
}