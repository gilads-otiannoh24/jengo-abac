<?php

namespace Jengo\Abac;

abstract class BasePolicy
{
    public function __construct(array|object $data = [])
    {
        $this->hydrate($data);
    }

    public function hydrate(array|object $data)
    {
        helper("inflector");
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $setter = 'set' . ucfirst(camelize($key));
                if (method_exists($this, $setter)) {
                    $this->$setter($value);
                }
            }
        } elseif (is_object($data)) {
            foreach (get_object_vars($data) as $key => $value) {
                $setter = 'set' . ucfirst(camelize($key));
                if (method_exists($this, $setter)) {
                    $this->$setter($value);
                }
            }
        }
    }
}
