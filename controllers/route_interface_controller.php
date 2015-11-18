<?php
require_once __DIR__ . '/../core/model.php';
require_once __DIR__ . '/../core/controller.php';
require_once __DIR__ . '/../models/route_interface_model.php';

class Route_interface_controller extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->model = new Route_interface_model();
    }

    public function add_redirect($src, $dest, $active, $device, $gender, $type)
    {
        $data = [$src, $dest, $active, $device, $gender, $type];
        $this->model->add_redirect($data);
        $this->get_redirects();
    }

    public function get_redirects()
    {
        $redirects = $this->model->get_redirects();
        $table_redirs = '';
        foreach ($redirects as $redirect) {
            $table_redirs .= "<tr class=\"redirect\" data-id=\"{$redirect['id']}\">
                <td>{$redirect['from']}</td>
                <td>{$redirect['to']}</td>
                <td>{$redirect['active']}</td>
                <td>{$redirect['device']}</td>
                <td>{$redirect['gender']}</td>
                <td></td>
                <td><a class=\"del\" style=\"color: red\">DEL</a><a class=\"edit\">EDIT</a></td>
            </tr>";
        }
        echo $table_redirs;
    }

    public function update_redirect($src, $dest, $active, $device, $gender, $type, $id)
    {
        $data = [$src, $dest, $active, $device, $gender, $type, $id];
        $this->model->update_redirect($data);
        $this->get_redirects();
    }

    public function delete_redirect($id)
    {
        $data = [$id];
        $this->model->delete_redirect($data);
        $this->get_redirects();
    }
}

if (isset($_POST['action'])) {

    $controller = new Route_interface_controller();
    call_user_func_array(array($controller, $_POST['action']), $_GET);
    unset($controller);

} else {
    $db = new Route_interface_model();
    $redirects = $db->get_redirects();
}