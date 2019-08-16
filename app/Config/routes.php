<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 */

//Frontpage displays list of all known events
Router::connect('/', array('controller'=>'Event', 'action'=>'redirectToLatest'));
Router::connect('/frontNews/*', array('controller'=>'frontNews'));
Router::connect('/Login/*', array('controller'=>'Login', 'action'=>'index'));
Router::connect('/About/*', array('controller'=>'About'));
Router::parseExtensions('json', 'xml');
$rest_resources = array('Api.users', 'Api.picture');
$resourceMap = array(
    array('action' => 'index',	'method' => 'GET',		'id' => false),
    array('action' => 'view',	'method' => 'GET',		'id' => true),
    array('action' => 'add',	'method' => 'POST',		'id' => false),
    array('action' => 'edit',	'method' => 'PUT', 		'id' => true),
    array('action' => 'delete',	'method' => 'DELETE',	'id' => true),
    array('action' => 'edit',	'method' => 'POST', 	'id' => true)
);

//Load events to cache
$events = Cache::read('events');
if (empty($events)) {
	App::import('Model', 'Event');
	$Event = new Event();
	$events = $Event->find('all');
	Cache::write('events', $events);
}

//Generate routes for each event
foreach ($events as $event) {
	$event = $event['Event']['reference'];
	$params = array('eventPrefix' => $event);
	$indexParams = $params + array('action' => 'index');
	$homeParams = $params + array('controller'=>'Home', 'action'=>'index');
	$wikiParams = $params + array('controller'=>'Wiki','action'=>'index');
    foreach($rest_resources as $name) {
        $options = array(
            'prefix' => '/',
            'id' => Router::ID . '|' . Router::UUID
        );
        list($plugin, $name) = pluginSplit($name);
        $urlName = Inflector::underscore($name);
        $plugin = Inflector::underscore($plugin);
        if ($plugin) {
            $prefix = '/' . $event . '/' . $plugin . '/';
        } else {
            $prefix = '/' . $event . '/';
        }

        foreach ($resourceMap as $resourceParams) {
            $url = $prefix . $urlName . (($resourceParams['id']) ? '/:id' : '');

            Router::connect($url,
                array(
                    'eventPrefix' => $event,
                    'plugin' => $plugin,
                    'controller' => $urlName,
                    'action' => $resourceParams['action'],
                    '[method]' => $resourceParams['method']
                ),
                array('id' => $options['id'], 'pass' => array('id'))
            );
        }
    }
	Router::connect("/{$event}", $homeParams);
	Router::connect("/{$event}/wiki/*", $wikiParams);
	Router::connect("/{$event}/Wiki/*", $wikiParams);
    if ($plugins = CakePlugin::loaded()) {
        App::uses('PluginShortRoute', 'Routing/Route');
        foreach ($plugins as $key => $value) {
            $plugins[$key] = Inflector::camelize($value);
            $plugins[count($plugins)+1] = strtolower($plugins[$key]);
        }
        $pluginPattern = implode('|', $plugins);
        $match = array('plugin' => $pluginPattern);
        $shortParams = array('routeClass' => 'PluginShortRoute', 'plugin' => $pluginPattern);
        Router::connect("/{$event}/:plugin", $indexParams, $shortParams);
        Router::connect("/{$event}/:plugin/:controller", $indexParams, $match);
        Router::connect("/{$event}/:plugin/:controller/:action/*", $params, $match);
    }
	Router::connect("/{$event}/:controller", $indexParams);
	Router::connect("/{$event}/:controller/:action/*", $params);
}

$namedConfig = Router::namedConfig();
if ($namedConfig['rules'] === false) {
	Router::connectNamed(true);
}
unset($namedConfig, $params, $indexParams, $event, $events, $homeParams, $Event, $wikiParams);
