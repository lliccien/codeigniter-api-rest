<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_create_table_users
 */
class Migration_create_table_users extends CI_Migration {


    protected $table = 'users';


    public function up()
    {
        $fields = array(
            'id'         => [
                'type'           => 'INT(11)',
                'auto_increment' => TRUE,
                'unsigned'       => TRUE,
            ],
            'email'      => [
                'type'   => 'VARCHAR(255)',
                'unique' => TRUE,
            ],
            'password'   => [
                'type' => 'VARCHAR(64)',
            ],
            'name'  => [
                'type' => 'VARCHAR(32)',
            ],
            'image'   => [
                'type' => 'VARCHAR(512)',
            ]
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table($this->table, TRUE);

    }


    public function down()
    {
        if ($this->db->table_exists($this->table))
        {
            $this->dbforge->drop_table($this->table);
        }
    }

}
