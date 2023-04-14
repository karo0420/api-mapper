<?php

namespace Karo0420\ApiMapper;

use Karo0420\ApiMapper\Exceptions\VisitNonRouteInstance;

class Loader
{
    private BaseMap $map;
    private array|Route $mapRoutes = [];

    public function setMap(BaseMap $map)
    {
        $this->map = $map;
        $this->mapRoutes = $map->preparedRoutes;
    }

    public function __call(string $name, array $arguments): self
    {
        $args = [];
        if (isset($arguments[0]))
            $args = is_array($arguments[0])?$arguments[0]:[$arguments[0]];

        $params = [];
        foreach ($args as $key=>$val) {
            if (is_numeric($key))
                $tempParam = [$name => $val];
            else
                $tempParam = [$key => $val];
            $params = array_merge($params, $tempParam);
        }

        $this->mapRoutes = $this->mapRoutes[$name];
        if ($this->mapRoutes instanceof Route) {
            $route = $this->mapRoutes;
            //$route->withHeader($this->map->getHeaders());
            //$route->params($params);

            $route->addParam($params);

            return $this;
        }

        if (count($params))
            foreach ($this->mapRoutes as $route) {
                //$route->withHeader($this->map->getHeaders());
                //$route->params($params);

                $route->addParam($params);
            }

        return clone $this;
    }

    public function __get(string $name)
    {
        $this->mapRoutes = $this->mapRoutes[$name];
            return $this;
    }

    /**
     * @throws VisitNonRouteInstance
     */
    public function visit(Mapper $mapper = null): ItemInterface|null
    {
        if (! $this->mapRoutes instanceof Route)
            throw new VisitNonRouteInstance('Trying to visit non-route instance , This route has sub routes');
        $mapperModel = $mapper!=null?$mapper:$this->mapRoutes->getMapper();
        $route = $this->mapRoutes->setBaseUrl($this->map->baseUrl());
        $route->withHeader($this->map->getHeaders());
        $route->addParam($this->map->getParams());
        //print_r($route->getParams());
        if ($parsed = $mapperModel->parse($route->visit())) {
            $parsed->additional([
                'map_name' => $this->map->mapName,
                'map_id'   => $this->map->mapId
            ]);
        }
        $this->mapRoutes->reset();
        $this->mapRoutes = $this->map->preparedRoutes;
        return $parsed;
    }


}