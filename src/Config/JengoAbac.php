<?php

namespace Jengo\Abac\Config;

use CodeIgniter\Config\BaseConfig;

class JengoAbac extends BaseConfig
{
    public array $files;

    public string $files_base_path = "";

    public string $policyNamespace = "";

    public function __construct()
    {
        $this->files = mapAbacFiles($this->files_base_path);
    }
}
