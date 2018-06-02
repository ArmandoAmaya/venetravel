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
 * Modelo Habextras
 */
class Habextras extends Models implements IModels {
    use DBModel;

    /**
     * Realiza todas las validaciones correspondientes a los extras de las habilitaciones antes de guardarlo
     * 
     * @param string $categoria: Extra de la habitacion
     * @param bool|bool $editar: false - estamos en crear, true - estamos en editar
     * 
     * @throws ModelsException en caso de haber un error
     * 
     * @return void
     */

    private function checkExtra($habextra, bool $editar = false){
        # Validar que no esté vacio
        if (Helper\Functions::emp($habextra)) {
            throw new ModelsException('No puedes enviar este elemento vacío.');
        }

        # Condición where
        $where = '';
        # solo aplica en editar
        if ($editar) {
            $where = "AND id_habextra <> '$this->id'";
        }

        # Validar que el plan no se repita
        if (false != $this->db->select('id_habextra', 'habextras', null, "habextra = '$habextra' $where", 1)) {
            throw new ModelsException('Este Extra de habitación ya existe.');
        }
    }

    /**
     * Respuesta generada por defecto para el endpoint
     * 
     * @return array
    */ 
    public function crear() : array {
        try {
            global $http;
            $habextra = $http->request->get('habextra');

            # Validar Extra de habitación
            $this->checkExtra($habextra);

            # Insertamos los datos
            $this->db->insert('habextras',array(
                'habextra' => $habextra
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
            $habextra = $http->request->get('habextra');
            $this->id = $http->request->get('id');

            # Validar Extra de habitación
            $this->checkExtra($habextra,true);

            # Insertamos los datos
            $this->db->update('habextras',array(
                'habextra' => $habextra
            ),"id_habextra = '$this->id'",1);

                    
            return array('success' => 1, 'message' => 'Operación realizada correctamente.');
        } catch(ModelsException $e) {
            return array('success' => 0, 'message' => $e->getMessage());
        }
    }
    /**
     * Obtiene todos los extras de las habitaciones
     * 
     * @return array|false
     */
    public function get() {
        return $this->db->select('*', 'habextras');
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
        if (false != $this->db->select('id_habextra', 'habextras', null, "id_habextra = '$this->id'", 1)) {
            # Eliminamos el elemento
            $this->db->delete('habextras', "id_habextra = '$this->id'",1);
            # Cambiamos a una accion exitosa
            $action = '&success=true';
        }

        # Redireccionamos a la pantalla principal
        Helper\Functions::redir($config['build']['url'].'habextras/'.$action);
    }


    /**
     * __construct()
    */
    public function __construct(IRouter $router = null) {
        parent::__construct($router);
		$this->startDBConexion();
    }
}