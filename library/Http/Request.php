<?php
declare(strict_types=1);

namespace Libray\Request;

use Library\Base\Base;

class Request extends Base
{
    protected $method;
    protected $queryParams = [];
    protected $bodyParams = [];

    private $controllerNameSpace = "App\\Http\\Controllers";
    private $baseController = "Library\\Controller";
    private $pathUrl;

    /**
     * 获取请求方式
     * @return string
     */
    public function getMethod(): string
    {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            return $this->method = strtoupper($_SERVER['REQUEST_METHOD']);
        }
        $this->method = "GET";
        return $this->method;
    }

    /**
     * 获取请求头
     * @param string $name
     * @param null $defaultValue
     * @return mixed|null
     */
    public function getHeader(string $name, $defaultValue = null)
    {
        $name = ucfirst($name);
        if (function_exists('apache_request_headers')) {
            $header = apache_request_headers();
            return $header[$name] ?? $defaultValue;
        }
        $name = strtoupper($name);
        return $_SERVER[$name] ?? $defaultValue;
    }

    /**
     * 获取get内容
     * @param $name
     * @param null $defaultValue
     * @return mixed|null
     */
    public function get($name, $defaultValue = null)
    {
        if (is_null($name)) {
            return $this->getQueryParams();
        }
        return $this->getQueryParam($name, $defaultValue);
    }

    /**
     * 获取get请求name
     * @param string $name
     * @param null $defaultValue
     * @return mixed|null
     */
    public function getQueryParam(string $name, $defaultValue = null)
    {
        $params = $this->getQueryParams();
        return isset($params[$name]) ? $params[$name] : $defaultValue;
    }

    /**
     * 获取get数据
     * @return mixed
     */
    public function getQueryParams()
    {
        if (empty($this->queryParams)) {
            $this->queryParams = $_GET;
        }
        return $this->queryParams;
    }

    /**
     * 获取post
     * @param $name
     * @param null $defaultValue
     * @return array|mixed|null
     */
    public function post($name, $defaultValue = null)
    {
        if (is_null($name)) {
            return $this->getBodyParams();
        } else {
            return $this->getBodyParam($name, $defaultValue);
        }
    }

    /**
     * 获取post name
     * @param $name
     * @param null $defaultValue
     * @return mixed|null
     */
    public function getBodyParam($name, $defaultValue = null)
    {
        $params = $this->getBodyParams();
        if (is_object($name)) {
            try {
                $params->{$name};
            } catch (\Exception $exception) {
                return $defaultValue;
            }
        }
        return isset($params[$name]) ? $params[$name] : $defaultValue;
    }

    /**
     * 获取post
     * @return array|mixed
     */
    public function getBodyParams()
    {
        if (!empty($this->bodyParams)) {
            return $this->bodyParams;
        }
        $contentType = strtolower($this->getHeader('Content-type'));
        if ($contentType == 'multipart/form-data') {
            $params = $_POST;
        } else {
            $params = json_decode(file_get_contents("php://input"), true);
        }
        $this->bodyParams = $params;
        return $this->bodyParams ?? [];
    }

    /**
     * 创建方法
     * @param $match
     * @return mixed
     * @throws \Exception
     */
    public function createController($match)
    {
        //生成控制器对应路径
        $controller = $this->controllerNameSpace;
        foreach ($match as $value) {
            $controller .= ucfirst($value) . '\\';
        }
        $controllerName = trim($controller, '\\') . 'Controller';
        if (!class_exists($controller)) {
            //判断是否 index
            if ($controllerName == $this->controllerNameSpace . '\\IndexController') {
                return new $this->baseController;
            }
            throw new \Exception("controller not found :" . $controllerName);
        }
        //返回控制器实例
        return new $controllerName;
    }

    public function runAction($route)
    {
        $route = explode('/', $route);
        //剔除空元素
        $route = array_diff($route);
        if (empty($route)) {
            $match = ['index'];
            $controller = $this->createController($match);
            $action = "index";
        } elseif (count($route) < 2) {
            $controller = $this->createController($route);
            $action = "index";
        } else {
            //获取最后的方法名
            $action = array_pop($route);
            $controller = $this->createController($route);
            //判断当前类是否 存在方法
            if (!method_exists($controller, $action)) {
                throw new \Exception("method not found :" . $action);
            }
        }
        return $controller->$action(array_merge($this->queryParams, $this->bodyParams));
    }

    /**
     * 获取当前请求路径
     * @return bool|string
     */
    public function resolve()
    {
        return $this->getPathUrl();
    }

    /**
     * 获取当前请求url
     * @return bool|string
     */
    public function getPathUrl()
    {
        if (is_null($this->pathUrl)) {
            $url = trim($_SERVER['REQUEST_URI'], '/');
            $index = strpos($url, '?');
            $this->pathUrl = ($index > -1) ? substr($url, 0, $index) : $url;
        }
        return $this->pathUrl;
    }


}
