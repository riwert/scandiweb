<?php

namespace RAPI\config;

use RAPI\config\Response;

class Router
{
    private $baseUrl;
    private $requestPath;
    private $requestMethod;
    private $routes = [];

    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->requestPath = $_SERVER['REQUEST_URI'];

        // Strip the base URL from the request URL to get the route path
        // $this->requestPath = parse_url($this->requestPath, PHP_URL_PATH);
        $this->requestPath = str_replace($this->baseUrl, '', $this->requestPath);
    }

    public function addRoute($method, $path, $handler)
    {
        $this->routes[$method][$path] = $handler;
    }

    public function handleRequest()
    {
        if (isset($this->routes[$this->requestMethod])) {
            foreach ($this->routes[$this->requestMethod] as $routePath => $handler) {
                // Check if the route path matches the requested path
                if ($this->isPathMatch($routePath, $this->requestPath)) {
                    // If it's a match, extract the dynamic field(s)
                    $params = $this->extractParams($routePath, $this->requestPath);

                    // Pass the dynamic field(s) to the handler function
                    $response = call_user_func($handler, $params);

                    if ($response !== false) {
                        return Response::handle($response, 200);
                    }
                }
            }
        }

        return Response::handle(['error' => 'Not Found'], 404);
    }

    private function isPathMatch($routePath, $requestedPath)
    {
        // Remove query parameters from the requested path
        $requestedPath = strtok($requestedPath, '?');

        // Check if the route path matches the requested path
        return rtrim($routePath, '/') === rtrim($requestedPath, '/');
    }

    private function extractParams($routePath, $requestedPath)
    {
        $params = [];

        // Extract the query string from the requested path
        $queryString = parse_url($requestedPath, PHP_URL_QUERY);

        // Parse the query string and extract the parameters
        if ($queryString) {
            parse_str($queryString, $params);
        }

        return $params;
    }
}
