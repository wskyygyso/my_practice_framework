<?php

namespace Library\Exceptions;
class CommonExceptions extends \Exception
{
    //定义错误码 及对应内容
    const CODE_MAPPING = [
        //1xx (临时响应)表示临时响应并需要请求者继续执行操作的状态代码。
        // 服务器返回此代码表示已收到请求的第一部分,正在等待其余部分。
        100 => 'Continue',
        //请求者已要求服务器切换协议,服务器已确认并准备切换
        101 => 'Switching Protocols',
        //由WebDAV(RFC 2518)扩展的状态码,代表处理将被继续执行
        102 => 'Processing',
        //2xx (成功)表示成功处理了请求的状态代码
        //服务器已成功处理了请求
        200 => 'OK',
        //请求成功并且服务器创建了新的资源
        201 => 'Created',
        //服务器已接受请求,但尚未处理
        202 => 'Accepted',
        // 服务器已成功处理了请求,但返回的信息可能来自另一来源
        203 => 'Non-Authoritative Information',
        //服务器成功处理了请求,但没有返回任何内容
        204 => 'No Content',
        //服务器成功处理了请求,但没有返回任何内容。
        205 => 'Reset Content',
        //服务器成功处理了部分 GET 请求
        206 => 'Partial Content',
        //代表之后的消息体将是一个XML消息,并且可能依照之前子请求数量的不同,包含一系列独立的响应代码
        207 => 'Multi-Status',
        226 => 'IM Used',
        //3xx (重定向) 表示要完成请求,需要进一步操作。 通常,这些状态代码用来重定向
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Reserved',
        307 => 'Temporary Redirect',
        //4xx (请求错误) 这些状态代码表示请求可能出错,妨碍了服务器的处理
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        426 => 'Upgrade Required',
        429 => 'Too Many Request',
        //5xx (服务器错误)这些状态代码表示服务器在尝试处理请求时发生内部错误
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        510 => 'Not Extended',
    ];

    /**
     * 返回数据
     * @param int $code
     * @param $data
     */
    public function response(int $code, $data): void
    {
        $code = array_key_exists($code, self::CODE_MAPPING) ? $code : 500;
        $desc = self::CODE_MAPPING[$code];
        $protocol = $_SERVER['SERVER_PROTOCOL'];
        if ('HTTP/1.1' != $protocol && 'HTTP/1.0' != $protocol)
            $protocol = 'HTTP/1.0';
        $header = "$protocol $code $desc";
        header($header);
        printText($data);
    }

}
