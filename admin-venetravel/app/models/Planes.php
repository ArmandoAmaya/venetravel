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
 * Modelo Planes
 */
class Planes extends Models implements IModels {
     /**
      * Característica para establecer conexión con base de datos. 
    */
    use DBModel;


    /**
     * Realiza todas las validaciones correspondientes al plan de alojamiento antes de guardarlo
     * 
     * @param string $plan: Plan de alojamiento
     * @param bool|bool $editar: false - estamos en crear, true - estamos en editar
     * 
     * @throws ModelsException en caso de haber un error
     * 
     * @return void
     */

    private function checkPlan($plan, bool $editar = false){
        # Validar que no esté vacio
        if (Helper\Functions::emp($plan)) {
            throw new ModelsException('No puedes enviar este elemento vacío.');
        }

        # Condición where
        $where = '';
        # solo aplica en editar
        if ($editar) {
            $where = "AND id_plan <> '$this->id'";
        }

        # Validar que el plan no se repita
        if (false != $this->db->select('id_plan', 'planes', null, "plan = '$plan' $where", 1)) {
            throw new ModelsException('Este plan de alojamiento ya existe.');
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
            $plan = $http->request->get('el');

            # Validar plan
            $this->checkPlan($plan);

            # Insertamos los datos
            $this->db->insert('planes',array(
                'plan' => $plan
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
            $plan = $http->request->get('el');
            $this->id = $http->request->get('id');

            # Validar plan
            $this->checkPlan($plan,true);

            # Insertamos los datos
            $this->db->update('planes',array(
                'plan' => $plan
            ), "id_plan = '$this->id'", 1);
                    
            return array('success' => 1, 'message' => 'Operación realizada correctamente.');
        } catch(ModelsException $e) {
            return array('success' => 0, 'message' => $e->getMessage());
        }
    }

    /**
     * Obtiene todos los planes de alojamiento
     * 
     * @return array con los planes, false en caso de no haber planes guardados
     */
    public function get() {
        return $this->db->select('*', 'planes');
    }

    /**
     * Elimina un plan
     * @return void
     */
    public function eliminar() {
        global $config;

        $action = '&error=true';

        # Validamos que exista el plan a eliminar
        if (false != $this->db->select('id_plan', 'planes', null, "id_plan = '$this->id'", 1)) {
            # Eliminamos el elemento
            $this->db->delete('planes', "id_plan = '$this->id'",1);
            # Cambiamos a una accion exitosa
            $action = '&success=true';
        }

        # Redireccionamos a la pantalla principal
        Helper\Functions::redir($config['build']['url'].'planes/'.$action);
    }


    /**
     * __construct()
    */
    public function __construct(IRouter $router = null) {
        parent::__construct($router);
        $this->startDBConexion();
    }
}