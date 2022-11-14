<?php
require_once './app/models/muralsModels.php';
require_once './app/views/apiView.php';

class MuralsApiController
{
    private $model;
    private $view;
    private $data;

    public function __construct()
    {
        $this->model = new MuralsModel();
        $this->view = new ApiView();

        // lee el body del request
        $this->data = file_get_contents("php://input");
    }

    private function getData()
    {
        return json_decode($this->data);
    }


    public function gets()
    {

        //order y sort  con sus distintas opciones
        if (isset($_GET['sort']) && isset($_GET['order']) && !isset($_GET['linkTo']) && !isset($_GET['equalTo'])) {
            if (strtoupper($_GET['order']) == "ASC" || strtoupper($_GET['order']) == "DESC") {
                $murals = $this->model->getAllmurals($_GET['sort'], $_GET['order'], null, null);
                $this->view->response($murals, 200);
            } else {
                $this->view->response("Error, order acepta asc o desc", 400);;
            }
            
        } else if (isset($_GET['sort']) && !isset($_GET['order']) && !isset($_GET['linkTo']) && !isset($_GET['equalTo'])) {
            $murals = $this->model->getAllmurals($_GET['sort'], null, null, null);
            $this->view->response($murals, 200);

        } else if (isset($_GET['order']) && !isset($_GET['sort']) && !isset($_GET['linkTo']) && !isset($_GET['equalTo'])) {

            if (strtoupper($_GET['order']) == "ASC" || strtoupper($_GET['order']) == "DESC") {
                $murals = $this->model->getAllmurals(null, $_GET['order'], null, null);
                $this->view->response($murals, 200);
            } else {
                $this->view->response("Error, order acepta asc o desc", 400);;
            }

        } else if (isset($_GET['sort']) && isset($_GET['order']) && isset($_GET['linkTo']) && isset($_GET['equalTo'])) {

            if (strtoupper($_GET['order']) == "ASC" || strtoupper($_GET['order']) == "DESC") {
                $murals = $this->model->filterMurales($_GET['sort'], $_GET['order'], $_GET['linkTo'], $_GET['equalTo']);
                $this->view->response($murals, 200);
            } else {
                $this->view->response("Error, order acepta asc o desc", 400);;
            }

        } else if (!isset($_GET['sort']) && !isset($_GET['order']) && isset($_GET['linkTo']) && isset($_GET['equalTo'])) {

            $murals = $this->model->filterMurales(null, null, $_GET['linkTo'], $_GET['equalTo']);
            $this->view->response($murals, 200);

        } else if (isset($_GET['sort']) && !isset($_GET['order']) && isset($_GET['linkTo']) && isset($_GET['equalTo'])) {

            $murals = $this->model->filterMurales($_GET['sort'], null, $_GET['linkTo'], $_GET['equalTo']);
            $this->view->response($murals, 200);

        } else {
            $murals = $this->model->getAllmurals(null, null, null, null);
            $this->view->response($murals, 200);
        }
    }




    public function get($params = null)
    {
        // traigo el id del arreglo de params
        $id = $params[':ID'];
        $murals = $this->model->get($id);

        //si no me lo trae me devuelve un 404
        if ($murals) {
            $this->view->response($murals);
        } else {
            $this->view->response("400 error, el mural con el id = $id no existe", 404);
        }
    }

    public function delete($params = null)
    {
        $id = $params[':ID'];
        $mural = $this->model->getOne($id);
        if ($mural) {
            $this->model->delete($id);
            $this->view->response("El mural con el id = $mural->id_mural fue eliminado exitosamente", 200);
            $this->view->response($mural);
        } else
            $this->view->response("El mural con el id = $id no existe", 404);
    }

    public function insert($params = null)
    {
        $murals = $this->getData();
        /*
        * Mural defecto para agregar   
         * {
            "id_tipo": "1",
            "nombre": "mural",
            "descripcion":"hola",
            "ubicacion": "hola",
            "lugar": "hola",
            "anuario": 777,
            "imagen": "hola"
            }
         */
        if (empty($murals->id_tipo) || empty($murals->nombre) || empty($murals->descripcion) || empty($murals->ubicacion) || empty($murals->lugar) || empty($murals->anuario) || empty($murals->imagen)) {
            $this->view->response("Complete todos los datos", 400);
        } else {
            $id = $this->model->insert($murals->id_tipo, $murals->nombre, $murals->descripcion, $murals->ubicacion, $murals->lugar, $murals->anuario, $murals->imagen);
            $murals = $this->model->getOne($id);
            $this->view->response("Mural con el id = $murals->id_mural fue creado exitosamente", 201);
        }
    }
}
