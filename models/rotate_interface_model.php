<?php

class Rotate_interface_model extends Model
{

    public function get_rotators()
    {
        $query = $this->db->query("SELECT rotator.alias, GROUP_CONCAT(CONCAT(landings.domain_name, '/', landings.name)) AS landing, GROUP_CONCAT(rotator.procent) AS procent FROM landings.rotator LEFT JOIN landings.landings ON(landings.rotator.landing = landings.landings.id) GROUP BY rotator.alias");
        return $query->fetchAll();
    }

    public function add_rotator($name, $landings, $procents)
    {
        $sql_query = '';
        foreach ($landings as $key => $landing) {
            $sql_query .= "INSERT INTO landings.rotator(alias, landing, procent) VALUES ('$name', '$landing', '$procents[$key]');";
        }
        $query = $this->db->prepare($sql_query);
        $query->execute();
    }

    public function delete_rotator($data)
    {
        $query = $this->db->prepare("DELETE FROM landings.rotator WHERE alias=?");
        $query->execute($data);
    }

}