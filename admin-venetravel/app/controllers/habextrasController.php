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
 * Controlador habextras/
*/
class habextrasController extends Controllers implements IControllers {

    public function __construct(IRouter $router) {
        parent::__construct($router,array(
        	'users_logged' => true
        ));
        $h = new Model\Habextras($router);

        if ($this->method == 'eliminar' && $this->isset_id) {
        	$h->eliminar();
        }else{
        	$this->template->display('habextras/habextras',array(
                'data' => $h->get()
            ));
        }
		
    }
}