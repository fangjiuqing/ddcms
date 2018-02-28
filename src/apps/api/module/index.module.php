<?php
namespace com\admin_api;
use \re\rgx as R;

class index_module extends R\module {

    public function index_action () {
        $this->display('index.tpl');
    }

}