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
 * Modelo Atraccionesduraciones
 */
class Atraccionesduraciones extends Models implements IModels {
    use DBModel;

    /**
     * Realiza todas las validaciones correspondientes a las duraciones de las atracciones antes de guardarla
     * 
     * @param string $atraccion_duracion: atraccion duración
     * @param bool|bool $editar: false - estamos en crear, true - estamos en editar
     * 
     * @throws ModelsException en caso de haber un error
     * 
     * @return void
     */

    private function check($atraccion_duracion, bool $editar = false){
        # Validar que no esté vacio
        if (Helper\Functions::emp($atraccion_duracion)) {
            throw new ModelsException('No puedes enviar este elemento vacío.');
        }

        # Condición where
        $where = '';
        # solo aplica en editar
        if ($editar) {
            $where = "AND id_atraccion_duracion <> '$this->id'";
        }

        # Validar que el plan no se repita
        if (false != $this->db->select('id_atraccion_duracion', 'atracciones_duraciones', null, "atraccion_duracion = '$atraccion_duracion' $where", 1)) {
            throw new ModelsException('Esta duración ya existe.');
        }
    }


    /**
     * Crear una duración de atracción
     * 
     * @return array
    */ 
    public function crear() : array {
        try {
            global $http;
            $atraccion_duracion = $http->request->get('atraccion_duracion');

            # Validar caracerística
            $this->check($atraccion_duracion);

            # Insertamos los datos
            $this->db->insert('atracciones_duraciones',array(
                'atraccion_duracion' => $atraccion_duracion
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
            $atraccion_duracion = $http->request->get('atraccion_duracion');
            $this->id = $http->request->get('id');

            # Validar caracerística
            $this->check($atraccion_duracion,true);

            # Insertamos los datos
            $this->db->update('atracciones_duraciones',array(
                'atraccion_duracion' => $atraccion_duracion
            ),"id_atraccion_duracion = '$this->id'",1);

                    
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
        return $this->db->select('*', 'atracciones_duraciones');
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
        if (false != $this->db->select('id_atraccion_duracion', 'atracciones_duraciones', null, "id_atraccion_duracion = '$this->id'", 1)) {
            # Eliminamos el elemento
            $this->db->delete('atracciones_duraciones', "id_atraccion_duracion = '$this->id'",1);
            # Cambiamos a una accion exitosa
            $action = '&success=true';
        }

        # Redireccionamos a la pantalla principal
        Helper\Functions::redir($config['build']['url'].'atraccionesduraciones/'.$action);
    }


    /**
     * __construct()
    */
    public function __construct(IRouter $router = null) {
        parent::__construct($router);
		$this->startDBConexion();
    }
}