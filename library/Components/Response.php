<?php

namespace Library\Components;


class Response extends Base
{
    protected $code = 0;
    protected $msg = 'success';
    protected $data = [];

    public function code(int $code)
    {
        $this->code = (int)$code;
        return $this;
    }

    public function msg(string $msg)
    {
        $this->msg = (string)$msg;
        return $this;
    }

    public function data($data = [])
    {
        $this->data = array_merge($this->data, $data);
        return $this;
    }

    public function send()
    {
        header("Content-Type:application/json;charset=utf-8");
        $returnData = [
            'code' => $this->code,
            'msg' => $this->msg,
            'data' => $this->data,
        ];
        echo json_encode($returnData);
    }


}
