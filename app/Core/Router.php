<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $routes = [

        'GET' => [],

        'POST' => [],

        'PUT' => [],

        'DELETE' => [],

    ];


    /*
    |--------------------------------------------------------------------------
    | Register GET Route
    |--------------------------------------------------------------------------
    */

    public function get(
        string $uri,
        array $action
    ): void {

        $this->routes['GET'][] = [

            'uri'    => $this->normalize($uri),

            'action' => $action

        ];

    }


    /*
    |--------------------------------------------------------------------------
    | Register POST Route
    |--------------------------------------------------------------------------
    */

    public function post(
        string $uri,
        array $action
    ): void {

        $this->routes['POST'][] = [

            'uri'    => $this->normalize($uri),

            'action' => $action

        ];

    }


    /*
    |--------------------------------------------------------------------------
    | Register PUT Route
    |--------------------------------------------------------------------------
    */

    public function put(
        string $uri,
        array $action
    ): void {

        $this->routes['PUT'][] = [

            'uri'    => $this->normalize($uri),

            'action' => $action

        ];

    }


    /*
    |--------------------------------------------------------------------------
    | Register DELETE Route
    |--------------------------------------------------------------------------
    */

    public function delete(
        string $uri,
        array $action
    ): void {

        $this->routes['DELETE'][] = [

            'uri'    => $this->normalize($uri),

            'action' => $action

        ];

    }


    /*
    |--------------------------------------------------------------------------
    | Dispatch Request
    |--------------------------------------------------------------------------
    */

    public function dispatch(
        string $uri,
        string $method
    ): void {

        $uri = $this->normalize($uri);

        $method = strtoupper($method);


        if (!isset($this->routes[$method])) {

            $this->notFound();

        }


        foreach ($this->routes[$method] as $route) {


            $pattern = $this->convertToRegex(
                $route['uri']
            );


            if (
                preg_match(
                    $pattern,
                    $uri,
                    $matches
                )
            ) {


                array_shift($matches);


                [$controller, $action] =
                    $route['action'];


                $instance =
                    new $controller();


                call_user_func_array(

                    [$instance, $action],

                    array_map(

                        'intval',

                        $matches

                    )

                );


                return;

            }

        }


        $this->notFound();

    }


    /*
    |--------------------------------------------------------------------------
    | Convert Dynamic Route to Regex
    |--------------------------------------------------------------------------
    */

    private function convertToRegex(
        string $uri
    ): string {


        $pattern = preg_replace(

            '/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/',

            '([^/]+)',

            $uri

        );


        return '#^' . $pattern . '$#';

    }


    /*
    |--------------------------------------------------------------------------
    | Normalize URI
    |--------------------------------------------------------------------------
    */

    private function normalize(
        string $uri
    ): string {


        $uri =
            parse_url(
                $uri,
                PHP_URL_PATH
            );


        $base =
            '/cashflow-management/public';


        if (
            str_starts_with(
                $uri,
                $base
            )
        ) {

            $uri =
                substr(
                    $uri,
                    strlen($base)
                );

        }


        $uri =
            '/' .
            trim(
                $uri,
                '/'
            );


        return $uri === '//'
            ? '/'
            : $uri;

    }


    /*
    |--------------------------------------------------------------------------
    | 404
    |--------------------------------------------------------------------------
    */

    private function notFound(): void
    {

        http_response_code(404);


        echo '<h1>404 - Page Not Found</h1>';


        exit;

    }

}