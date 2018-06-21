<?php
namespace re\rgx;

class designer_help_case_iface extends ubase_iface {
    
    public function list_action () {
        $key = filter::text($this->data['key']);
        $tab = OBJ('case_table')->where([
            'case_title'  => function ($k) use ($key) {
                return "{$k} like '{$key}%'";
            }
        ]);
        $tab->fields('case_id, case_title, case_cover')->order('case_id desc')->limit(10);
        $this->success('', [
            'list'  => $tab->get_all()
        ]);
    }
}