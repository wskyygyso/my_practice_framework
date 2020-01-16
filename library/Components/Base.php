<?php

namespace Library\Base;
class Base implements \ArrayAccess
{
    private $_container;

    public function __get($name)
    {
        //魔术方法 调用当前方法
        if (method_exists($this, $method = 'get' . ucfirst($name))) {
            return $this->$method;
        }
        return null;
    }

    public function __set($name, $value)
    {
        if (method_exists($this, $method = 'set' . ucfirst($name))) {
            return $this->$method($name, $value);
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->_container[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->_container[$offset]) ? $this->_container[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->_container[] = $value;
        } else {
            $this->_container[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->_container[$offset]);
    }

}
