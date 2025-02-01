<?php

namespace Jengo\Abac;

use PhpAbac\Abac;
use PhpAbac\AbacFactory;

class AbacLibrary
{
    public function init(): Abac
    {
        $config = config('JengoAbac');
        helper('inflector');

        return AbacFactory::getAbac($config->files, $config->files_base_path, [
            'getter_name_transformation_function' => 'camelize',
        ]);
    }
}
