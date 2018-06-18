<?php

/*
 * This file is part of the Ocrend Framewok 3 package.
 *
 * (c) Ocrend Software <info@ocrend.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/

namespace app\controllers;

use app\models as Model;
use Ocrend\Kernel\Helpers as Helper;
use Ocrend\Kernel\Controllers\Controllers;
use Ocrend\Kernel\Controllers\IControllers;
use Ocrend\Kernel\Router\IRouter;

/**
 * Controlador atraccionfeatures/
*/
class atraccionfeaturesController extends Controllers implements IControllers {

    public function __construct(IRouter $router) {
        parent::__construct($router,array(
            'users_logged' => true
        ));
        $a = new Model\Atraccionfeatures($router);
        if ($this->method == 'eliminar' && $this->isset_id) {
        	$a->eliminar();
        }else{
        	$this->template->display('atraccionfeatures/atraccionfeatures',array(
				'data' => $a->get()
			));
        }
    }
}