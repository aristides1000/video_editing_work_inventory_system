<?php
function convertirAPng($archivoEntrada, $archivoSalida) {
  // Obtener la extensión del archivo de entrada
  $extension = strtolower(pathinfo($archivoEntrada, PATHINFO_EXTENSION));

  // Cargar la imagen según su formato
  switch($extension) {
    case 'jpg':
    case 'jpeg':
      $imagen = imagecreatefromjpeg($archivoEntrada);
      break;
    case 'gif':
      $imagen = imagecreatefromgif($archivoEntrada);
      break;
    default:
      throw new Exception("Formato de archivo no soportado");
  }

  // Guardar como PNG
  imagepng($imagen, $archivoSalida);

  // Liberar memoria
  imagedestroy($imagen);

  return file_exists($archivoSalida);
}

// Ejemplo de uso:
try {
  $resultado = convertirAPng('./equipment_image/equipment-image-7.jpg', './equipment_image/equipment-image-7.png');
  if($resultado) {
    echo "Conversión exitosa!";
  } else {
    echo "Error en la conversión";
  }
} catch(Exception $e) {
  echo "Error: " . $e->getMessage();
}
?>