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
 * Modelo Admins
 */
class Admins extends Models implements IModels {
    use DBModel;
    /**
     * Valida que el administrador a guardar, no se encuentre ya registrado en la db
     * 
     * @param string $email: Email del administrador 
     * @param bool|bool $edit: true - Editar , false - Agregadr
     * 
     * @throws ModelsException en caso de haber un error
     * 
     * @return void
     */
    private function checkAdmin($email, bool $edit = false) {
        # Validar que el email sea un email
        if (!Helper\Strings::is_email($email)) {
            throw new ModelsException('El email debe tener un formato válido.');
        }

        # Escapamos el email
        $email = $this->db->scape($email);

        # Condicion para editar y agregar
        $where = $edit ? "AND id_user <> '$this->id'" : '';

        # Validar que el usuario no este registrado
        if (false != $this->db->select('id_user', 'users', null, "email = '$email' $where", 1)) {
            throw new ModelsException('Este administrador ya está registrado.');
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
            $email = $http->request->get('email');
            $pass = $http->request->get('pass');

            # Validar campos obligatorios
            if (!Helper\Functions::all_full($http->request->all())) {
                throw new ModelsException('Todos los campos con * son obligatorios.');
            }

            # Validar usuario
            $this->checkAdmin($email);

            # Insertar administrador
            $this->db->insert('users', [
                'email' => $email,
                'pass' => Helper\Strings::hash($pass),
                'type' => '4'
            ]);
            return array('success' => 1, 'message' => 'Administrador registrado.');
        } catch(ModelsException $e) {
            return array('success' => 0, 'message' => $e->getMessage());
        }
    }

    /**
     * Respuesta generada por defecto para el endpoint
     * 
     * @return array
    */ 
    public function editar() : array {
        try {
            global $http;
            $this->id = $http->request->get('id_user');
            $email = $http->request->get('email');
            $pass = $http->request->get('pass');

            # Validar campos obligatorios
            if (Helper\Functions::emp($email)) {
                throw new ModelsException('Todos los campos con * son obligatorios.');
            }

            # Validar usuario
            $this->checkAdmin($email, true);

            # Datos a insertar
            $data = array(
                'email' => $email
            );

            # En caso de cambio de contraseña
            if (!Helper\Functions::emp($pass)) {
                $data['pass'] = Helper\Strings::hash($pass);
            }

            # Actualizar datos
            $this->db->update('users', $data, "id_user = '$this->id'", 1);

            return array('success' => 1, 'message' => 'Administrador editado.');
        } catch(ModelsException $e) {
            return array('success' => 0, 'message' => $e->getMessage());
        }
    }

    /**
     * Obtiene uno o más administradores
     * 
     * @param bool $multi: true - trae todos los administradores, false - trae 1 administrador
     * 
     * @return array|false
     */
    public function get(bool $multi = true) {
        if ($multi) {
            return $this->db->select('*', 'users', null, "type = '4'");
        }
        return $this->db->select('*', 'users', null, "id_user = '$this->id'", 1);
    }
    /**
     * Elimina una administrador
     * 
     * @return void
     */
    public function eliminar() {
        global $config;

        $action = '&error=true';

        # Validamos que exista el administrador a eliminar
        if (false != $this->db->select('id_user', 'users', null, "id_user = '$this->id'", 1)) {
            # Eliminamos al admin
            $this->db->delete('users', "id_user = '$this->id'",1);
            # Cambiamos a una accion exitosa
            $action = '&success=true';
        }

        # Redireccionamos a la pantalla principal
        Helper\Functions::redir($config['build']['url'].'admins/'.$action);
    }


    /**
     * __construct()
    */
    public function __construct(IRouter $router = null) {
        parent::__construct($router);
		$this->startDBConexion();
    }
}