<?php
header("Content-type: text/html; charset=utf-8");

include '../vendor/simple_html_dom.php';
include '../vendor/htmLawed.php';

$url = __DIR__ . '/../lands/' . $_GET['src'];
$html = file_get_html($url . 'index.html');
$content = file_get_contents($url . 'index.html');
preg_match_all('#<script(.*?)</script>#is', $content, $matches);
preg_match_all('#<noscript(.*?)</noscript>#is', $content, $matches_noscr);

if (isset($_POST['data'])) {

    foreach ($html->find('p') as $key => $text) {
        $html->find('p', $key)->innertext = $_POST['data'][$key];
    }
    $html->find('body', 0)->innertext = htmLawed($html->find('body', 0)->innertext, array('tidy' => 4));
    //$html->find('head', 0)->innertext = htmLawed($html->find('head',0)->innertext, array('tidy'=>4));
    file_put_contents($url . 'index.html', $html);

} elseif (isset($_POST['imgs'])) {
    foreach ($_FILES['new_imgs']['tmp_name'] as $key => $value) {
        if (!empty($value)) {
            $target_file = $url . $_POST['imgs'][$key];
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
            $dirs = explode('/', $_POST['imgs'][$key]);
            unset($dirs[count($dirs) - 1]);
            $dirs = implode('/', $dirs);

            if (!is_dir($url . $dirs)) {
                mkdir($url . $dirs, 0777, true);
            }

            $check = getimagesize($value);
            if ($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }

// Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            ) {
                echo "Sorry, only JPG, JPEG, PNG files are allowed.";
                $uploadOk = 0;
            }
// Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
            } else {
                if (copy($value, $target_file)) {
                    echo "The file " . basename($_POST['imgs'][$key]) . " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
    }
} elseif (isset($_POST['data_scripts'])) {
    foreach ($_POST['data_scripts'] as $key => $scripts) {
        $content = str_replace($matches[0][$key], $scripts, $content);
    }

    foreach ($_POST['data_noscripts'] as $key => $noscripts) {
        $content = str_replace($matches_noscr[0][$key], $noscripts, $content);
    }
    file_put_contents($url . 'index.html', $content);
    preg_match_all('#<script(.*?)</script>#is', $content, $matches);
    preg_match_all('#<noscript(.*?)</noscript>#is', $content, $matches_noscr);
}

$landing = explode('/', $_GET['src']);
unset($landing[count($landing) - 1]);
$landing = implode('/', $landing);
echo "<h1 style='text-align: center'>Редактировать контент лэндинга <a href='/landings/lands/$landing'>$landing</a></h1>";

/*
 *
 * Тесты
 *
 */
echo '<form method="post" style="float: left"><h2 style="text-align: center">Тексты</h2>';
foreach ($html->find('p, span') as $key => $text) {
    echo "<label>Тэг {$text->tag}:  </label><textarea style='width:450px;height: 100px;' name='data[]'>{$text->innertext}</textarea><br>";
}
echo '<input type="submit">';
echo '</form>';
/*
 *
 * Скрипты
 *
 */
echo '<form method="post" style="float: left; margin-left: 65px; "><h2 style="text-align: center">Скрипты</h2>';
foreach ($matches[0] as $value) {
    echo "<label>script:  </label><textarea style='width:500px;height: 100px;' name='data_scripts[]'>$value</textarea><br>";
}

foreach ($matches_noscr[0] as $value) {
    echo "<label>noscript:</label><textarea style='width:500px;height: 100px;' name='data_noscripts[]'>$value</textarea><br>";
}
echo '<input type="submit">';
echo '</form>';
/*
 *
 * Картинки
 *
 */
echo '<form method="post" style="float: right" enctype="multipart/form-data"><h2 style="text-align: center">Картинки</h2>';
foreach ($html->find('img') as $key => $img) {
    echo "<input name='imgs[]' type='text' value='{$img->src}' style='width: 200px'><span>Заменить:   </span><input type='file' name='new_imgs[]'>     <img width='200px' height='200px' src='/landings/lands/{$_GET['src']}{$img->src}' alt=''><br>";
}
echo '<input type="submit">';
echo '</form>';
?>



