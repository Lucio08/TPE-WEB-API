<?php
class MuralsModel
{
  private $db;

  function __construct()
  {
    $this->db = new PDO('mysql:host=localhost;' . 'dbname=muralismo;charset=utf8', 'root', '');
  }

  function getAllMurals($sort = "id_mural", $order = "ASC", $linkTo = null, $equalTo = null)
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

    $query = $this->db->prepare($queryGeneral);
    $query->execute();
    $murals = $query->fetchAll(PDO::FETCH_OBJ);
    return $murals;
  }


  function filterMurales($sort = null, $order = null, $linkTo, $equalTo)
  {
    if ($sort == null && $order == null && $linkTo != null && $equalTo != null) {
    $query = $this->db->prepare("SELECT id_tipo, id_mural, anuario, nombre FROM murales WHERE  $linkTo = :$linkTo");
    $query->bindParam(":" . $linkTo, $equalTo, PDO::PARAM_STR); // une parametros
    $query->execute();
    }
   else if ($sort != null && $order != null && $linkTo != null && $equalTo != null) {
      $query = $this->db->prepare("SELECT id_tipo, id_mural, anuario, nombre FROM murales WHERE  $linkTo = :$linkTo ORDER BY $sort $order");
      $query->bindParam(":" . $linkTo, $equalTo, PDO::PARAM_STR); // une parametros
      $query->execute();
    }
   else if ($sort != null && $order == null && $linkTo != null && $equalTo != null) {
      $query = $this->db->prepare("SELECT id_tipo, id_mural, anuario, nombre FROM murales WHERE  $linkTo = :$linkTo ORDER BY $sort");
      $query->bindParam(":" . $linkTo, $equalTo, PDO::PARAM_STR); // une parametros
      $query->execute();
    }
    $murals =  $query->fetchAll(PDO::FETCH_OBJ);
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


  function getOne($id_mural)
  {
    $query = $this->db->prepare('SELECT * FROM murales where id_mural = ?');
    $query->execute(array($id_mural));

    $mural = $query->fetch(PDO::FETCH_OBJ);
    return $mural;
  }
}
