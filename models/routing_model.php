<?php

require_once __DIR__ . '/../core/model.php';

class Routing_model extends Model
{
    public function get_rotate_landings($alias)
    {
        $query = $this->db->prepare("SELECT rotator.procent, landings.name, landings.domain_name FROM landings.rotator LEFT JOIN landings.landings ON (landings.rotator.landing = landings.landings.id) WHERE landings.rotator.alias=?");
        $query->execute([$alias]);
        return $query->fetchAll();
    }

    public function set_user_session_data($data)
    {
        $query = $this->db->prepare("INSERT INTO landings.visits(uid, ip, country, os, brouser, devices, referer) VALUES (?,?,?,?,?,?,?)");
        $query->execute($data);
    }

    public function get_redirect_info($url)
    {
        $query = $this->db->prepare("SELECT * FROM landings.redirects WHERE redirects.`from` = ?");
        $query->execute([$url]);
        return $query->fetchAll();
    }
}