<?php

namespace Library\Http;


use Library\Components\Response;

class Controller
{
    protected $response;

    public function __construct()
    {
        $this->response = new Response();
    }

    public function success($data = [])
    {
        $this->response->code('200')->msg('请求成功');
        if (!empty($data)) {
            $this->response->data($data);
        }
        return $this->response->send();
    }

    public function error($msg = "请求失败")
    {
        return $this->response->code(500)->msg($msg)->send();
    }
}
