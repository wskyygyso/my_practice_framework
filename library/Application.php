<?php

namespace Library;

use Library\Components\Response;
use Library\Exceptions\CommonExceptions;
use Library\Http\Request;

class Application
{
    private $config;
    private $request;

    public function __construct(Request $request, $config = [])
    {
        $this->request = $request;
        $this->config = $config;
    }

    public function handleRequest(Request $request)
    {

        $route = $request->resolve($this->config['route'] ?? []);
        $response = $request->runAction($route);
        if (!($response instanceof Response)) {
            throw new CommonExceptions("返回数据不规范");
        }
        return $response->send();
    }

    public function run()
    {
        $response = new Response();
        try {
            $returnData = $this->handleRequest($this->request);
            //TODO  返回数据
        } catch (\Exception $exception) {
            $errorData = [
                'code' => $exception->getCode() ?? 500,
                'msg' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine()
            ];
            return $response->data($errorData)->send();
        }
    }
}
