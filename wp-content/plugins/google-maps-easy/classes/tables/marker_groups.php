<?php
class tableMarker_groupsGmp extends tableGmp{
    public function __construct() {

        $this->_table = '@__marker_groups';
        $this->_id = 'id';
        $this->_alias = 'gmp_mrgr';
        $this->_addField('id', 'int', 'int', '11', __('Map ID', GMP_LANG_CODE))
                ->_addField('title', 'varchar', 'varchar', '255', __('File name', GMP_LANG_CODE))
                ->_addField('description', 'text', 'text', '', __('Description Of Map', GMP_LANG_CODE));
    }
}

