<?php
class MuralsModel
{
  private $db;

  function __construct()
  {
    $this->db = new PDO('mysql:host=localhost;' . 'dbname=muralismo;charset=utf8', 'root', '');
  }

  function getAllMurals($sort = "id_mural", $order = "ASC")
  {
    if ($sort == null) {
      $sort = "id_mural";
    }
    if ($order == null) {
      $order = "ASC";
    }
    $queryGeneral = "SELECT * FROM murales ORDER BY ";
    // arreglo con los items de la tabla
    $columns = array(
      'id_tipo' => 'id_tipo',
      'id_mural' => 'id_mural',
      'nombre' => 'nombre',
      'descripcion' => 'descripcion',
      'ubicacion' => 'ubicacion',
      'lugar' => 'lugar',
      'anuario' => 'anuario',
      'imagen' => 'imagen'
    );

    if (isset($columns[$sort])) {
      $queryGeneral .= $columns[$sort] . " ";
    } else {
      return null;
    }

    if (strtoupper($order) == "ASC") {
      $queryGeneral .= "ASC";
    } else {
      $queryGeneral .= "DESC";
    }

    $query = $this->db->prepare($queryGeneral);
    $query->execute();
    $murals = $query->fetchAll(PDO::FETCH_OBJ);
    return $murals;
  }

  //FUNCION QUE ME TRAE  INFORMACION EXTRA DEL MURAL
  function get($id)
  {
    $query = $this->db->prepare('SELECT * FROM murales JOIN tipos ON tipos.id_tipo = murales.id_tipo WHERE id_mural = ?');
    $query->execute([$id]);
    $mural = $query->fetch(PDO::FETCH_OBJ);
    return $mural;
  }

  //funcion que trae murales por tipos 
  function getMuralsByTypes($id)
  {
    $query = $this->db->prepare('SELECT * FROM murales WHERE id_tipo = ?');
    $query->execute([$id]);
    $muralByCategories = $query->fetchAll(PDO::FETCH_OBJ);
    return $muralByCategories;
  }


  function delete($id_mural)
  {
    $query = $this->db->prepare('DELETE FROM murales WHERE id_mural = ?');
    $query->execute([$id_mural]);
  }


  function insert($nameCategories, $murals, $description, $location, $place, $year, $img)
  {
    $query = $this->db->prepare('INSERT INTO `murales`(`id_tipo`,`nombre`,`descripcion`,`ubicacion`, `lugar`, `anuario`, `imagen`) VALUES (?,?,?,?,?,?,?)');
    $query->execute([$nameCategories, $murals, $description, $location, $place, $year, $img]);
    return $this->db->lastInsertId();
  }



  private function uploadImage($img)
  {
    $target = 'images/murals/' . uniqid() . '.jpg'; //  le da un nombre unico a la imagen
    move_uploaded_file($img, $target); /// mueve  los archivos temporales a la carpeta de las imagenes
    return $target;
  }


  function getOne($id_mural)
  {
    $query = $this->db->prepare('SELECT * FROM murales where id_mural = ?');
    $query->execute(array($id_mural));

    $mural = $query->fetch(PDO::FETCH_OBJ);
    return $mural;
  }


  function update($id_mural, $id_tipo, $nameMural, $description, $location, $place, $year, $img = null)
  {
    $pathImg = null;
    if ($img) {
      $pathImg = $this->uploadImage($img);
      $query = $this->db->prepare('UPDATE murales SET id_tipo=?, nombre=?, descripcion=?,ubicacion=?, lugar=?, anuario=?, imagen=? WHERE id_mural=?');
      $query->execute(array($id_tipo, $nameMural, $description, $location, $place, $year, $pathImg, $id_mural));
    } else {
      $query = $this->db->prepare('UPDATE murales SET id_tipo=?, nombre=?, descripcion=?,ubicacion=?, lugar=?, anuario=?  WHERE id_mural=?');
      $query->execute(array($id_tipo, $nameMural, $description, $location, $place, $year, $id_mural));
    }
  }
}
