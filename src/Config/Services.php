<?php

namespace Jengo\Abac\Config;

use Jengo\Abac\AbacLibrary;
use CodeIgniter\Config\BaseService;

class Services extends BaseService
{
    public static function abac($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('abac');
        }

        return (new AbacLibrary())->init();
    }
}
