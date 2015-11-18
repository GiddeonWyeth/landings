<?php


class Route_interface_model extends Model
{

    public function get_redirects()
    {
        $query = $this->db->query("SELECT * FROM landings.redirects");
        return $query->fetchAll();
    }

    public function add_redirect($data)
    {
        $query = $this->db->prepare("INSERT INTO landings.redirects(`from`, `to`, active, device, gender, `type`) VALUES (?,?,?,?,?,?)");
        $query->execute($data);
    }

    public function update_redirect($data)
    {
        $query = $this->db->prepare("UPDATE landings.redirects SET `from`=?, `to`=?, active=?, device=?, gender=?, type=? WHERE id=?");
        $query->execute($data);
    }

    public function delete_redirect($data)
    {
        $query = $this->db->prepare("DELETE FROM landings.redirects WHERE id=?");
        $query->execute($data);
    }

}