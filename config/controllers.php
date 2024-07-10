<?php

/*------------------------------------------------------
 | Register controllers and inject services            |
 ------------------------------------------------------*/
require_once __DIR__ . '/../vendor/autoload.php';

$namespace = 'Rowles\\Controllers';

$controllers = [];

// TODO not this...
$dir = __DIR__ . '/../src/Controllers';
$files = array_diff(scandir($dir), ['.', '..']);
foreach ($files as $file) {
    if (is_file($dir.'/'.$file)) {
        require_once $dir.'/'.$file;
    }
}

// Get all classes under the specified namespace
foreach (get_declared_classes() as $class) {
    if (strpos($class, $namespace) === 0) {
        $controllers[] = $class;
    }
}

foreach ($controllers as $controller) {
    $reflector = new ReflectionClass($controller);

    // Check if class can be instantiated (i.e. not abstract)
    if ($reflector->isInstantiable()) {
        // Get the constructor
        $constructor = $reflector->getConstructor();

        if ($constructor) {
            $params = $constructor->getParameters();
            // Resolve dependencies for constructor parameters
            $dependencies = [];
            foreach ($params as $param) {
                $paramClass = $param->getClass();

                if ($paramClass) {
                    // Dependency is a class
                    $dependency = $app[$paramClass->getName()];
                } else {
                    // Dependency is nota class (e.g. scalar type or no typehint)
                    continue;
                }

                $dependencies[] = $dependency;
            }

            // Instantiate the controller with the resolved dependencies
            // and store the controller instance in the service container
            $app[$controller] = $reflector->newInstanceArgs($dependencies);
        } else {
            // Controller has no constructor or constructor with no params
            $app[$controller] = $reflector->newInstance();
        }
    }
}