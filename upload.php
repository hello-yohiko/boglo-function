<?php
function boglo_upload($file, $folder) {
    $img_src_chemin = $file['name'];
    $img_src_tmpchemin = $file['tmp_name'];

    $img_dst_chemin = uniqid()."- $img_src_chemin".".jpg";
    $img_dst_resource = uniqid()."- $img_src_chemin".".jpg";

    // Déterminer l'extension à partir du nom de fichier et Afin de simplifier les comparaisons, on met tout en minuscule
    $extension = strtolower(substr( $img_src_chemin, -3 ));

    switch ( $extension ) {

      case "jpg":
      case "peg": //pour le cas où l'extension est "jpeg"
          $img_src_resource = imagecreatefromjpeg( $img_src_tmpchemin );
          echo '.jpg';
          break;

      case "gif":
          $img_src_resource = imagecreatefromgif( $img_src_tmpchemin );
          echo '.gif';
          break;

      case "png":
          $img_src_resource = imagecreatefrompng( $img_src_tmpchemin );
          echo '.png';
          break;

      // On peut également ouvrir les formats wbmp, xbm et xpm (vérifier la configuration du serveur)

      default:
          echo "L'image n'est pas dans un format reconnu. Extensions autorisées : jpg/jpeg, gif, png";
          break;
    }

    $img_src_width = imagesx( $img_src_resource );
    $img_src_height = imagesy( $img_src_resource );

    $img_dst_resource = imagecreatetruecolor($img_src_width / 5, $img_src_height / 5);

    imagecopyresampled(
        $img_dst_resource,
        $img_src_resource,
        0,0,
        0,0,
        $img_src_width / 5, $img_src_height / 5,
        $img_src_width,
        $img_src_height
    );

    // Pour enregistrer au format wbmp
    imagegif( $img_dst_resource, $folder.$img_dst_chemin );

    return $img_dst_chemin;
}
?>