<?php

namespace Delos\Dgp\Http\Controllers;

trait ResourceNamesTrait
{
    protected function getAbility()
    {
        $actionName = $this->getActionName();
        $currentController = $this->getRouteObject()->getController();

        $mappedAbilities = $currentController->getMappedAbilities();
        $slugPrefix = $mappedAbilities[$actionName] ?? $actionName;
        $slugSufix = str_singular($this->camelCaseToSlug($this->getControllerNameWithoutSufix()));
        return $slugPrefix . '-' . $slugSufix;
    }

    protected function getActionName() : string
    {
        $action = strstr($this->getRouteObject()->getActionName(), '@');
        $action = substr($action, 1);

        return $this->camelCaseToSlug($action);
    }

    protected function getCollectionName() : string
    {
        return lcfirst($this->getControllerNameWithoutSufix());
    }

    protected function getEntityName() : string
    {
        return str_singular($this->getCollectionName());
    }

    protected function getControllerNameWithoutSufix() : string
    {
        $controller = $this->getRouteObject()->getController();
        $controller = (new \ReflectionClass($controller))->getShortName();
        $controller = strstr($controller, 'Controller', true);
        return $controller;
    }

    protected function getRouteAliasForIndexAction() : string
    {
        $sufix = strstr($this->getRouteObject()->getName(), '.', true);
        return $sufix . '.index';
    }

    protected function getViewNamespace()
    {
        return $this->camelCaseToSlug($this->getControllerNameWithoutSufix());
    }
    private function camelCaseToSlug($string) : string
    {
        $slug = '';

        for($i = 0; $i < strlen($string); $i++) {
            if(ctype_upper($string[$i]) && $i > 0) {
                $slug .= '-';
            }

            $slug .= $string[$i];
        }

        return strtolower($slug);
    }

    private function getRouteObject()
    {
        return app('request')->route();
    }
}