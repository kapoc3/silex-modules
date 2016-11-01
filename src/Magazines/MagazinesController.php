<?php

namespace App\Magazines;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MagazinesController implements ControllerProviderInterface
{

  public function connect(Application $app)
  {
    // creates a new controller based on the default route
    $controller = $app['controllers_factory'];

    // la ruta "/users/list"
    $controller->get('/list', function() use($app) {

      // obtiene el nombre de usuario de la sesión
      $user = $app['session']->get('user');
      $magazines = $app['session']->get('magazines');
      
      // ya ingreso un usuario ?
      if ( isset( $user ) && $user != '' ) {
        // muestra la plantilla
        return $app['twig']->render('Magazines/magazines.list.html.twig', array(
          'user' => $user,
          'magazines' => $magazines
        ));

      } else {
        // redirige el navegador a "/login"
        return $app->redirect( $app['url_generator']->generate('login'));
      }

    // hace un bind
    })->bind('magazines-list');
    
    
    

    // la ruta "/users/edit"
    $controller->get('/edit', function() use($app) {

      // obtiene el nombre de usuario de la sesión
      $user = $app['session']->get('user');

      // ya ingreso un usuario ?
      if ( isset( $user ) && $user != '' ) {
        // muestra la plantilla
        return $app['twig']->render('Magazines/magazines.edit.html.twig', array(
          'user' => $user
        ));

      } else {
        // redirige el navegador a "/login"
        return $app->redirect( $app['url_generator']->generate('login'));
      }

    // hace un bind
    })->bind('magazines-edit');

    // la ruta "/users/edit"
    $controller->post('/edit', function(Request $request) use($app) {
    	
    	$magazines = $app['session']->get('magazines');
    	$magazines[] = array (
    			'nombre' => $request->get('nombre'),
    			'ano' => $request->get('apellido'),
    			'tema' => $request->get('direccion'),
    			'editorial' => $request->get('email')
    	);
    	
    	$app['session']->set('magazines',$magazines);
    	
    	// redirige el navegador a "/login"
    	return $app->redirect( $app['url_generator']->generate('magazines-list'));
    
    	// hace un bind
    })->bind('magazines-do-edit');
    
    
    
    return $controller;
  }

}