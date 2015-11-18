<?php

require_once __DIR__ . '/../core/model.php';
require_once __DIR__ . '/../core/controller.php';
require_once __DIR__ . '/../models/rotate_interface_model.php';

class Rotate_interface_controller extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->model = new Rotate_interface_model();
    }

    public function add_rotator($prev_name, $name, $landings, $procents)
    {
        $this->model->add_rotator($name, $landings, $procents);
        $this->get_rotators();
    }

    public function get_rotators()
    {
        $rotators = $this->model->get_rotators();
        $table_rotators = '';
        foreach ($rotators as $rotator) {
            $table_rotators .= "<tr class=\"rotator\">
            <td>{$rotator['alias']}</td>
            <td>{$rotator['landing']}</td>
            <td>{$rotator['procent']}</td>
            <td><a class=\"delete\" style=\"color: red\">DEL</a> <a
                    class=\"edit\">EDIT</a></td>
        </tr>";
        }
        $table_rotators .= "    <tr>
        <td colspan=\"3\" style=\"text-align: center\"><a class=\"add\" style=\"color: green\">ADD</a></td>
    </tr>";
        echo $table_rotators;
    }

    public function update_rotator($prev_name, $name, $landings, $procents)
    {
        $data = [$prev_name];
        $this->model->delete_rotator($data);
        $this->model->add_rotator($name, $landings, $procents);
        $this->get_rotators();
    }

    public function delete_rotator($name)
    {
        $data = [$name];
        $this->model->delete_rotator($data);
        $this->get_rotators();
    }

}

if (isset($_POST['action'])) {
    $controller = new Rotate_interface_controller();
    call_user_func_array(array($controller, $_POST['action']), $_GET);
    unset($controller);

} else {
    $db = new Rotate_interface_model();
    $rotators = $db->get_rotators();
}