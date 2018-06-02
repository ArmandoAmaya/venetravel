<?php

/*
 * This file is part of the Ocrend Framewok 3 package.
 *
 * (c) Ocrend Software <info@ocrend.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\models;

use app\models as Model;
use Ocrend\Kernel\Helpers as Helper;
use Ocrend\Kernel\Models\Models;
use Ocrend\Kernel\Models\IModels;
use Ocrend\Kernel\Models\ModelsException;
use Ocrend\Kernel\Models\Traits\DBModel;
use Ocrend\Kernel\Router\IRouter;

/**
 * Modelo Categorias
 */
class Categorias extends Models implements IModels {
    use DBModel;

    /**
     * Realiza todas las validaciones correspondientes a la categoría antes de guardarla
     * 
     * @param string $categoria: Categoría
     * @param bool|bool $editar: false - estamos en crear, true - estamos en editar
     * 
     * @throws ModelsException en caso de haber un error
     * 
     * @return void
     */

    private function checkCategoria($categoria, bool $editar = false){
        # Validar que no esté vacio
        if (Helper\Functions::emp($categoria)) {
            throw new ModelsException('No puedes enviar este elemento vacío.');
        }

        # Condición where
        $where = '';
        # solo aplica en editar
        if ($editar) {
            $where = "AND id_categoria <> '$this->id'";
        }

        # Validar que el plan no se repita
        if (false != $this->db->select('id_categoria', 'categorias', null, "categoria = '$categoria' $where", 1)) {
            throw new ModelsException('Esta categoría ya existe.');
        }
    }


    /**
     * Crear una categoría
     * 
     * @return array
    */ 
    public function crear() : array {
        try {
            global $http;
            $categoria = $http->request->get('categoria');

            # Validar categoría
            $this->checkCategoria($categoria);

            # Insertamos los datos
            $this->db->insert('categorias',array(
                'categoria' => $categoria
            ));

                    
            return array('success' => 1, 'message' => 'Operación realizada correctamente.');
        } catch(ModelsException $e) {
            return array('success' => 0, 'message' => $e->getMessage());
        }
    }
    /**
     * Edita una categoría
     * 
     * @return array
     */
    public function editar() : array {
        try {
            global $http;
            $categoria = $http->request->get('categoria');
            $this->id = $http->request->get('id');

            # Validar categoría
            $this->checkCategoria($categoria,true);

            # Insertamos los datos
            $this->db->update('categorias',array(
                'categoria' => $categoria
            ),"id_categoria = '$this->id'",1);

                    
            return array('success' => 1, 'message' => 'Operación realizada correctamente.');
        } catch(ModelsException $e) {
            return array('success' => 0, 'message' => $e->getMessage());
        }
    }
    /**
     * Obtiene todas las categorías
     * 
     * @return array|false
     */
    public function get() {
        return $this->db->select('*', 'categorias');
    }

    /**
     * Elimina una categoría
     * 
     * @return void
     */
    public function eliminar() {
        global $config;

        $action = '&error=true';

        # Validamos que exista el plan a eliminar
        if (false != $this->db->select('id_categoria', 'categorias', null, "id_categoria = '$this->id'", 1)) {
            # Eliminamos el elemento
            $this->db->delete('categorias', "id_categoria = '$this->id'",1);
            # Cambiamos a una accion exitosa
            $action = '&success=true';
        }

        # Redireccionamos a la pantalla principal
        Helper\Functions::redir($config['build']['url'].'categorias/'.$action);
    }


    /**
     * __construct()
    */
    public function __construct(IRouter $router = null) {
        parent::__construct($router);
		$this->startDBConexion();
    }
}