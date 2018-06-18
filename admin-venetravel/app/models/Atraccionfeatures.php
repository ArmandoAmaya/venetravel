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
 * Modelo Atraccionfeatures
 */
class Atraccionfeatures extends Models implements IModels {
    use DBModel;

    /**
     * Realiza todas las validaciones correspondientes a las caracteristicas de las atracciones antes de guardarla
     * 
     * @param string $atraccion_feature: atraccion feature
     * @param bool|bool $editar: false - estamos en crear, true - estamos en editar
     * 
     * @throws ModelsException en caso de haber un error
     * 
     * @return void
     */

    private function checkAtraccionfeature($atraccion_feature, bool $editar = false){
        # Validar que no esté vacio
        if (Helper\Functions::emp($atraccion_feature)) {
            throw new ModelsException('No puedes enviar este elemento vacío.');
        }

        # Condición where
        $where = '';
        # solo aplica en editar
        if ($editar) {
            $where = "AND id_atraccion_feature <> '$this->id'";
        }

        # Validar que el plan no se repita
        if (false != $this->db->select('id_atraccion_feature', 'atracciones_features', null, "atraccion_feature = '$atraccion_feature' $where", 1)) {
            throw new ModelsException('Esta característica ya existe.');
        }
    }


    /**
     * Crear una caracteristica de una atraccion
     * 
     * @return array
    */ 
    public function crear() : array {
        try {
            global $http;
            $atraccion_feature = $http->request->get('atraccion_feature');

            # Validar caracerística
            $this->checkAtraccionfeature($atraccion_feature);

            # Insertamos los datos
            $this->db->insert('atracciones_features',array(
                'atraccion_feature' => $atraccion_feature
            ));

                    
            return array('success' => 1, 'message' => 'Operación realizada correctamente.');
        } catch(ModelsException $e) {
            return array('success' => 0, 'message' => $e->getMessage());
        }
    }

    /**
     * Edita una caracteristica de una atraccion
     * 
     * @return array
     */
    public function editar() : array {
        try {
            global $http;
            $atraccion_feature = $http->request->get('atraccion_feature');
            $this->id = $http->request->get('id');

            # Validar caracerística
            $this->checkAtraccionfeature($atraccion_feature,true);

            # Insertamos los datos
            $this->db->update('atracciones_features',array(
                'atraccion_feature' => $atraccion_feature
            ),"id_atraccion_feature = '$this->id'",1);

                    
            return array('success' => 1, 'message' => 'Operación realizada correctamente.');
        } catch(ModelsException $e) {
            return array('success' => 0, 'message' => $e->getMessage());
        }
    }

    /**
     * Obtiene todas las caracteristicas a incluir en las atracciones
     * 
     * @return array|false
     */
    public function get() {
        return $this->db->select('*', 'atracciones_features');
    }

    /**
     * Elimina una caracteristica de una atracción
     * 
     * @return void
     */
    public function eliminar() {
        global $config;

        $action = '&error=true';

        # Validamos que exista el plan a eliminar
        if (false != $this->db->select('id_atraccion_feature', 'atracciones_features', null, "id_atraccion_feature = '$this->id'", 1)) {
            # Eliminamos el elemento
            $this->db->delete('atracciones_features', "id_atraccion_feature = '$this->id'",1);
            # Cambiamos a una accion exitosa
            $action = '&success=true';
        }

        # Redireccionamos a la pantalla principal
        Helper\Functions::redir($config['build']['url'].'atraccionfeatures/'.$action);
    }


    /**
     * __construct()
    */
    public function __construct(IRouter $router = null) {
        parent::__construct($router);
		$this->startDBConexion();
    }
}