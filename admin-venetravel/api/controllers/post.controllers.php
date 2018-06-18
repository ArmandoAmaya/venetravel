<?php

/*
 * This file is part of the Ocrend Framewok 3 package.
 *
 * (c) Ocrend Software <info@ocrend.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/

use app\models as Model;

/**
    * Inicio de sesión
    *
    * @return json
*/  
$app->post('/login', function() use($app) {
    $u = new Model\Users;   

    return $app->json($u->login());   
});



/**
    * Recuperar contraseña perdida
    *
    * @return json
*/
$app->post('/lostpass', function() use($app) {
    $u = new Model\Users; 

    return $app->json($u->lostpass());   
});
/**
 * Endpoint para crear planes
 *
 * @return json
*/
$app->post('/planes/crear', function() use($app) {
    $p = new Model\Planes; 

    return $app->json($p->crear());   
});

/**
 * Endpoint para editar planes
 *
 * @return json
*/
$app->post('/planes/editar', function() use($app) {
    $p = new Model\Planes; 

    return $app->json($p->editar());   
});
/**
 * Endpoint para crear categorias
 *
 * @return json
*/
$app->post('/categorias/crear', function() use($app) {
    $c = new Model\Categorias; 

    return $app->json($c->crear());   
});

/**
 * Endpoint para editar categorias
 *
 * @return json
*/
$app->post('/categorias/editar', function() use($app) {
    $c = new Model\Categorias; 

    return $app->json($c->editar());   
});
/**
 * Endpoint para crear features
 *
 * @return json
*/
$app->post('/features/crear', function() use($app) {
    $f = new Model\Features; 

    return $app->json($f->crear());   
});

/**
 * Endpoint para editar features
 *
 * @return json
*/
$app->post('/features/editar', function() use($app) {
    $f = new Model\Features; 

    return $app->json($f->editar());   
});
/**
 * Endpoint para crear habextras
 *
 * @return json
*/
$app->post('/habextras/crear', function() use($app) {
    $h = new Model\Habextras; 

    return $app->json($h->crear());   
});

/**
 * Endpoint para editar habextras
 *
 * @return json
*/
$app->post('/habextras/editar', function() use($app) {
    $h = new Model\Habextras; 

    return $app->json($h->editar());   
});
/**
 * Endpoint para crea tipos de alojamiento
 *
 * @return json
*/
$app->post('/tipos/crear', function() use($app) {
    $t = new Model\Tipos; 

    return $app->json($t->crear());   
});

/**
 * Endpoint para editar tipos de alojamiento
 *
 * @return json
*/
$app->post('/tipos/editar', function() use($app) {
    $t = new Model\Tipos; 

    return $app->json($t->editar());   
});
/**
 * Endpoint para crear caracteristicas de las atracciones
 *
 * @return json
*/
$app->post('/atraccionfeatures/crear', function() use($app) {
    $a = new Model\Atraccionfeatures; 

    return $app->json($a->crear());   
});

/**
 * Endpoint para editar caracteristicas de las atracciones
 *
 * @return json
*/
$app->post('/atraccionfeatures/editar', function() use($app) {
    $a = new Model\Atraccionfeatures; 

    return $app->json($a->editar());   
});
/**
 * Endpoint para crear un tipo de atracción
 *
 * @return json
*/
$app->post('/atracciontipos/crear', function() use($app) {
    $a = new Model\Atracciontipos; 

    return $app->json($a->crear());   
});

/**
 * Endpoint para editar un tipo de atracción
 *
 * @return json
*/
$app->post('/atracciontipos/editar', function() use($app) {
    $a = new Model\Atracciontipos; 

    return $app->json($a->editar());   
});

/**
 * Endpoint para crear un selectivo de atracción
 *
 * @return json
*/
$app->post('/atraccionselectivos/crear', function() use($app) {
    $a = new Model\Atraccionselectivos; 

    return $app->json($a->crear());   
});

/**
 * Endpoint para editar un selectivo de atracción
 *
 * @return json
*/
$app->post('/atraccionselectivos/editar', function() use($app) {
    $a = new Model\Atraccionselectivos; 

    return $app->json($a->editar());   
});
/**
 * Endpoint para crear la duración de una atracción
 *
 * @return json
*/
$app->post('/atraccionesduraciones/crear', function() use($app) {
    $a = new Model\Atraccionesduraciones; 

    return $app->json($a->crear());   
});

/**
 * Endpoint para editar la duración de una atracción
 *
 * @return json
*/
$app->post('/atraccionesduraciones/editar', function() use($app) {
    $a = new Model\Atraccionesduraciones; 

    return $app->json($a->editar());   
});
/**
 * Endpoint para crear admins
 *
 * @return json
*/
$app->post('/admins/crear', function() use($app) {
    $a = new Model\Admins; 

    return $app->json($a->crear());   
});

/**
 * Endpoint para editar admins
 *
 * @return json
*/
$app->post('/admins/editar', function() use($app) {
    $a = new Model\Admins; 

    return $app->json($a->editar());   
});