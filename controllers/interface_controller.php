<?php
require_once __DIR__ . '/../core/model.php';
require_once __DIR__ . '/../core/controller.php';
require_once __DIR__ . '/../models/interface_model.php';


class Interface_controller extends Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->model = new Interface_model();
    }

    public function copyr($source, $dest)
    {
        // Check for symlinks
        if (is_link($source)) {
            return symlink(readlink($source), $dest);
        }

        // Simple copy for a file
        if (is_file($source)) {
            return copy($source, $dest);
        }

        // Make destination directory
        if (!is_dir($dest)) {
            mkdir($dest);
        }

        // Loop through the folder
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            // Deep copy directories
            $this->copyr("$source/$entry", "$dest/$entry");
        }

        // Clean up

        $dir->close();
        return true;
    }

    public function set_landing($data)
    {
        $this->model->set_landing($data);
    }

    public function add_domain($name, $ip)
    {
        $name = parse_url($name)['host'];
        $data = [$name, $ip];
        $this->model->add_domain($data);
        mkdir('../lands/' . $name);
        $this->get_domains();
    }

    public function get_domains()
    {
        $domains = $this->model->get_domains();

        $table_domain = '';
        foreach ($domains as $domain) {
            $table_domain .= "<tr class='domain' data-domain='{$domain['domain_name']}'><td>{$domain['domain_name']}</td><td>{$domain['ip']}</td><td><a class=\"delete\" style=\"color: red\">DEL</a> <a
                class=\"edit\">EDIT</a> </td></tr>";
        }
        $table_domain .= "<tr>
        <td colspan=\"3\" style=\"text-align: center\"><a class=\"add\" style=\"color: green\">ADD</a></td>
    </tr>";
        echo $table_domain;
    }

    public function update_domain($prev_name, $name, $ip)
    {
        $name = parse_url($name)['host'];
        $data = [$name, $ip, $prev_name];
        $this->model->update_domain($data);
        rename('../lands/' . $prev_name, '../lands/' . $name);
        $this->get_domains();
    }

    public function add_landing($name, $domain)
    {
        $data = [$name, $domain];
        $this->model->add_landing($data);
        mkdir('../lands/' . $domain . '/' . $name);
        $file = fopen('../lands/' . $domain . '/' . $name . '/index.php', 'w');
        fwrite($file, '<?include "index.html"; ?>');
        fclose($file);
        $this->get_landings($domain);
    }

    public function get_landings($domain)
    {
        $landings = $this->model->get_landings($domain);
        $table_land = '';
        foreach ($landings as $landing) {
            $table_land .= "<tr class='landing' data-domain='$domain' data-land='{$landing['name']}'><td><a href='lands/$domain/{$landing['name']}/'>{$landing['name']}</a></td><td> <a class=\"delete\" style=\"color: red\">DEL</a> <a
                class=\"edit\" href='/landings/controllers/parse_html_controller.php?src=$domain/{$landing['name']}/' target='_blank'>EDIT</a> <a class='clone'>CLONE</a> </td></tr>";
        }
        $table_land .= "<tr>
        <td colspan=\"2\" style=\"text-align: center\"><a class=\"add\" style=\"color: green\">ADD</a></td>
    </tr>";
        echo $table_land;
    }

    public function delete_landing($name, $domain)
    {
        $data = [$name, $domain];
        $this->model->delete_landing($data);
        $date = date('Y-m-d_H-i-s');
        rename('../lands/' . $domain . '/' . $name, '../deleted_lands/' . $name . '_' . $date . '_' . $domain);
        $this->get_landings($domain);
    }

    public function delete_domain($domain)
    {
        if (self::is_dir_empty('../lands/' . $domain)) {
            $data = [$domain];
            $this->model->delete_domain($data);
            rmdir('../lands/' . $domain);
            $this->get_domains();
        } else {
            echo 'false';
        }
    }

    private static function is_dir_empty($dir)
    {
        if (!is_readable($dir)) return NULL;
        $handle = opendir($dir);
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                return FALSE;
            }
        }
        return TRUE;
    }

    public function get_upload_files($uploads, $uploadDir)
    {
        $uploadDir = '/landings/lands/' . $uploadDir;
        // Split the string containing the list of file paths into an array
        $paths = explode("###", rtrim($_POST['paths'], "###"));

        // Loop through files sent
        foreach ($uploads as $key => $current) {
            // Stores full destination path of file on server
            $this->uploadFile = $uploadDir . rtrim($paths[$key], "/.");
            // Stores containing folder path to check if dir later
            $this->folder = substr($this->uploadFile, 0, strrpos($this->uploadFile, "/"));

            // Check whether the current entity is an actual file or a folder (With a . for a name)
            if (strlen($current['name']) != 1)
                // Upload current file
                if ($this->upload($current, $this->uploadFile))
                    echo "The file " . $paths[$key] . " has been uploadedn";
                else
                    echo "Error";
        }
    }

    private function upload($current, $uploadFile)
    {
        // Checks whether the current file's containing folder exists, if not, it will create it.
        if (!is_dir($this->folder)) {
            mkdir($this->folder, 0700, true);
        }
        // Moves current file to upload destination
        if (move_uploaded_file($current['tmp_name'], $uploadFile))
            return true;
        else
            return false;
    }


}

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    unset($_POST['action']);
    $controller = new Interface_controller();
    call_user_func_array(array($controller, $action), $_POST);
    if ($action == 'copyr') {
        $data = [explode('/', $_POST['dest'])[3], $_GET['domain']];
        $controller->set_landing($data);
        $controller->get_landings($_GET['domain']);
    }
    unset($controller);
} else {
    $db = new Interface_model();
    $domains = $db->get_domains();
}