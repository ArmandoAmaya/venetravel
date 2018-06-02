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
 * Modelo Features
 */
class Features extends Models implements IModels {
    use DBModel;

    /**
     * Realiza todas las validaciones correspondientes al feature antes de guardarlo
     * 
     * @param string $feature: Feature
     * @param bool|bool $editar: false - estamos en crear, true - estamos en editar
     * 
     * @throws ModelsException en caso de haber un error
     * 
     * @return void
     */

    private function checkFeature($feature, bool $editar = false){
        # Validar que no esté vacio
        if (Helper\Functions::emp($feature)) {
            throw new ModelsException('No puedes enviar este elemento vacío.');
        }

        # Condición where
        $where = '';
        # solo aplica en editar
        if ($editar) {
            $where = "AND id_feature <> '$this->id'";
        }

        # Validar que el plan no se repita
        if (false != $this->db->select('id_feature', 'features', null, "feature = '$feature' $where", 1)) {
            throw new ModelsException('Este Amenitie ya existe.');
        }
    }


    /**
     * Crear un Feature
     * 
     * @return array
    */ 
    public function crear() : array {
        try {
            global $http;
            $feature = $http->request->get('feature');

            # Validar feature
            $this->checkFeature($feature);

            # Insertamos los datos
            $this->db->insert('features',array(
                'feature' => $feature
            ));

                    
            return array('success' => 1, 'message' => 'Operación realizada correctamente.');
        } catch(ModelsException $e) {
            return array('success' => 0, 'message' => $e->getMessage());
        }
    }
    /**
     * Edita un Feature
     * 
     * @return array
     */
    public function editar() : array {
        try {
            global $http;
            $feature = $http->request->get('feature');
            $this->id = $http->request->get('id');

            # Validar feature
            $this->checkFeature($feature,true);

            # Insertamos los datos
            $this->db->update('features',array(
                'feature' => $feature
            ),"id_feature = '$this->id'",1);

                    
            return array('success' => 1, 'message' => 'Operación realizada correctamente.');
        } catch(ModelsException $e) {
            return array('success' => 0, 'message' => $e->getMessage());
        }
    }
    /**
     * Obtiene todos los features
     * 
     * @return array|false
     */
    public function get() {
        return $this->db->select('*', 'features');
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
        if (false != $this->db->select('id_feature', 'features', null, "id_feature = '$this->id'", 1)) {
            # Eliminamos el elemento
            $this->db->delete('features', "id_feature = '$this->id'",1);
            # Cambiamos a una accion exitosa
            $action = '&success=true';
        }

        # Redireccionamos a la pantalla principal
        Helper\Functions::redir($config['build']['url'].'features/'.$action);
    }



    /**
     * __construct()
    */
    public function __construct(IRouter $router = null) {
        parent::__construct($router);
		$this->startDBConexion();
    }
}