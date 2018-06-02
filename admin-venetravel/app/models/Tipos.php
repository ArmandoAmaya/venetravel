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
 * Modelo Tipos
 */
class Tipos extends Models implements IModels {
    use DBModel;

    /**
     * Realiza todas las validaciones correspondientes al tipo de alojamiento antes de guardarlo
     * 
     * @param string $tipo_alojamiento: Plan de alojamiento
     * @param bool|bool $editar: false - estamos en crear, true - estamos en editar
     * 
     * @throws ModelsException en caso de haber un error
     * 
     * @return void
     */

    private function checkTipo($tipo_alojamiento, bool $editar = false){
        # Validar que no esté vacio
        if (Helper\Functions::emp($tipo_alojamiento)) {
            throw new ModelsException('No puedes enviar este elemento vacío.');
        }

        # Condición where
        $where = '';
        # solo aplica en editar
        if ($editar) {
            $where = "AND id_tipo_alojamiento <> '$this->id'";
        }

        # Validar que el tipo de alojamiento no se repita
        if (false != $this->db->select('id_tipo_alojamiento', 'tipos_alojamiento', null, "tipo_alojamiento = '$tipo_alojamiento' $where", 1)) {
            throw new ModelsException('Este tipo de alojamiento ya existe.');
        }
    }

    /**
     * Crea un elemento en la tabla de planes
     * 
     * @return array
    */ 
    public function crear() : array {
        try {
            global $http;
            $tipo_alojamiento = $http->request->get('tipo_alojamiento');

            # Validar tipo de alojamiento
            $this->checkTipo($tipo_alojamiento);

            # Insertamos los datos
            $this->db->insert('tipos_alojamiento',array(
                'tipo_alojamiento' => $tipo_alojamiento
            ));
                    
            return array('success' => 1, 'message' => 'Operación realizada correctamente.');
        } catch(ModelsException $e) {
            return array('success' => 0, 'message' => $e->getMessage());
        }
    }
    /**
     * Edita un elemento en la tabla de planes
     * 
     * @return array
     */
    public function editar() : array {
        try {
            global $http;
            $tipo_alojamiento = $http->request->get('tipo_alojamiento');
            $this->id = $http->request->get('id');

            # Validar tipo de alojamiento
            $this->checkTipo($tipo_alojamiento,true);
            
            # Insertamos los datos
            $this->db->update('tipos_alojamiento',array(
                'tipo_alojamiento' => $tipo_alojamiento
            ), "id_tipo_alojamiento = '$this->id'", 1);
                    
            return array('success' => 1, 'message' => 'Operación realizada correctamente.');
        } catch(ModelsException $e) {
            return array('success' => 0, 'message' => $e->getMessage());
        }
    }

    /**
     * Obtiene todos los tipos de alojamiento
     * 
     * @return array con los tipos de alojamiento, false en caso de no haber tipos de alojamiento guardados
     */
    public function get() {
        return $this->db->select('*', 'tipos_alojamiento');
    }

    /**
     * Elimina un plan
     * @return void
     */
    public function eliminar() {
        global $config;

        $action = '&error=true';

        # Validamos que exista el plan a eliminar
        if (false != $this->db->select('id_tipo_alojamiento', 'tipos_alojamiento', null, "id_tipo_alojamiento = '$this->id'", 1)) {
            # Eliminamos el elemento
            $this->db->delete('tipos_alojamiento', "id_tipo_alojamiento = '$this->id'",1);
            # Cambiamos a una accion exitosa
            $action = '&success=true';
        }

        # Redireccionamos a la pantalla principal
        Helper\Functions::redir($config['build']['url'].'tipos/'.$action);
    }



    /**
     * __construct()
    */
    public function __construct(IRouter $router = null) {
        parent::__construct($router);
		$this->startDBConexion();
    }
}