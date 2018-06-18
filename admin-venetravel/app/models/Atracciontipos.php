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
 * Modelo Atracciontipos
 */
class Atracciontipos extends Models implements IModels {
    use DBModel;

    /**
     * Realiza todas las validaciones correspondientes a los tipos de atracciones antes de guardarlos
     * 
     * @param string $atraccion_tipo: Tipo de atraccion
     * @param bool|bool $editar: false - estamos en crear, true - estamos en editar
     * 
     * @throws ModelsException en caso de haber un error
     * 
     * @return void
     */

    private function checkAtraccionfeature($atraccion_tipo, bool $editar = false){
        # Validar que no esté vacio
        if (Helper\Functions::emp($atraccion_tipo)) {
            throw new ModelsException('No puedes enviar este elemento vacío.');
        }

        # Condición where
        $where = '';
        # solo aplica en editar
        if ($editar) {
            $where = "AND id_atraccion_tipo <> '$this->id'";
        }

        # Validar que el plan no se repita
        if (false != $this->db->select('id_atraccion_tipo', 'atracciones_tipos', null, "atraccion_tipo = '$atraccion_tipo' $where", 1)) {
            throw new ModelsException('Este tipo de atracción ya existe.');
        }
    }


    /**
     * Crear un tipo de atraccion
     * 
     * @return array
    */ 
    public function crear() : array {
        try {
            global $http;
            $atraccion_tipo = $http->request->get('atraccion_tipo');

            # Validar caracerística
            $this->checkAtraccionfeature($atraccion_tipo);

            # Insertamos los datos
            $this->db->insert('atracciones_tipos',array(
                'atraccion_tipo' => $atraccion_tipo
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
            $atraccion_tipo = $http->request->get('atraccion_tipo');
            $this->id = $http->request->get('id');

            # Validar caracerística
            $this->checkAtraccionfeature($atraccion_tipo,true);

            # Insertamos los datos
            $this->db->update('atracciones_tipos',array(
                'atraccion_tipo' => $atraccion_tipo
            ),"id_atraccion_tipo = '$this->id'",1);

                    
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
        return $this->db->select('*', 'atracciones_tipos');
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
        if (false != $this->db->select('id_atraccion_tipo', 'atracciones_tipos', null, "id_atraccion_tipo = '$this->id'", 1)) {
            # Eliminamos el elemento
            $this->db->delete('atracciones_tipos', "id_atraccion_tipo = '$this->id'",1);
            # Cambiamos a una accion exitosa
            $action = '&success=true';
        }

        # Redireccionamos a la pantalla principal
        Helper\Functions::redir($config['build']['url'].'atracciontipos/'.$action);
    }


    /**
     * __construct()
    */
    public function __construct(IRouter $router = null) {
        parent::__construct($router);
		$this->startDBConexion();
    }
}