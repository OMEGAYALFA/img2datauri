<?php
$retour = '';

// Basé sur http://phpcodeur.net/articles/php/upload
if (isset($_POST['upload'])) {
    $selecteur = '.maclass';
    if (isset($_POST['selecteur']) && !empty($_POST['selecteur'])) {
        $selecteur = strip_tags($_POST['selecteur']);
    }

    $tmp_file = $_FILES['fichier']['tmp_name'];
    if (!is_uploaded_file($tmp_file)) {
        exit("Le fichier est introuvable");
    }

    // on vérifie maintenant l'extension
    $type_file = $_FILES['fichier']['type'];
    if (!strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'png') && !strstr($type_file, 'gif')) {
        exit("Le fichier n'est pas une image");
    }

    // on copie le fichier dans le dossier de destination
    $name_file = $_FILES['fichier']['name'];

    if (!move_uploaded_file($tmp_file, $content_dir . $name_file)) {
        exit("Impossible de copier le fichier dans $content_dir");
    }


    $retour = '<pre>' . $selecteur . ' {' . "\n";
    $retour .= 'background-image:url(data:' . $type_file . ';base64,' . base64_encode(file_get_contents($content_dir . $name_file)) . ');' . "\n";
    $retour .= '}' . "\n";
    $retour .= '.lt_ie8 ' . $selecteur . ' {' . "\n";
    $retour .= 'background-image:url(../images/' . $name_file . ');' . "\n";
    $retour .= '}</pre>';

    @unlink($content_dir . $name_file);
}