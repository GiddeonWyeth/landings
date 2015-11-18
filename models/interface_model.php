<?php

class Interface_model extends Model
{

    public function get_domains()
    {
        $query = $this->db->query("SELECT * FROM landings.domains");
        self::__destructor();
        return $query->fetchAll();
    }

    public function get_landings($domain)
    {
        $query = $this->db->prepare("SELECT landings.landings.name FROM landings.landings WHERE landings.domain_name=?");
        $query->execute([$domain]);
        return $query->fetchAll();
    }

    public function set_landing($data)
    {
        $query = $this->db->prepare("INSERT INTO landings.landings(name, domain_name) VALUES (?,?)");
        $query->execute($data);
    }

    public function add_domain($data)
    {
        $query = $this->db->prepare("INSERT INTO landings.domains(domain_name, ip) VALUES (?,?)");
        $query->execute($data);
    }

    public function add_landing($data)
    {
        $query = $this->db->prepare("INSERT INTO landings.landings(name, domain_name) VALUES (?,?)");
        $query->execute($data);
    }

    public function delete_landing($data)
    {
        $query = $this->db->prepare("DELETE FROM landings.landings WHERE name=? AND domain_name=?");
        $query->execute($data);
    }

    public function update_domain($data)
    {
        $query = $this->db->prepare("UPDATE landings.domains SET domain_name=?, ip=? WHERE domain_name=?");
        $query->execute($data);
    }

    public function delete_domain($data)
    {
        $query = $this->db->prepare("DELETE FROM landings.domains WHERE domain_name=?");
        $query->execute($data);
    }


}

