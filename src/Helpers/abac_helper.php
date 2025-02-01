<?php

use Jengo\Abac\BasePolicy;
use Jengo\Repositories\UserRepository;
use PhpAbac\Abac;

if (!function_exists('abac')) {
    /**
     * Shorthand for accessing the AbacLibrary
     *
     * @return Abac
     */
    function abac(): Abac
    {
        return service('abac');
    }
}

if (!function_exists('enforce')) {

    /**
     *  Shorthand for enforcing an rule on a user and a resource
     *
     * @param string $rule Rule to be checked
     * @param BasePolicy $user User to use
     * @param ?object $resource Resource to check
     *
     * @return bool
     */
    function enforce(string $rule, BasePolicy $user, ?object $resource = null): bool
    {
        return abac()->enforce($rule, $user, $resource);
    }
}


if (!function_exists('policy')) {
    /**
     * Shorthand for loading an Abac policy
     *
     * @param string $policyName Name of the policy to load
     * @param array $params Parameters to pass to the policy
     *
     * @return BasePolicy
     */
    function policy(string $policyName, array $params = []): BasePolicy
    {
        $config = config('JengoAbac');

        if ($config->policyNamespace === "") {
            throw new \Exception("Policy namespace is not set in the config");
        }

        $fullPolicyName = "$config->policyNamespace\\" . ucfirst($policyName) . 'Policy';

        if (!class_exists($fullPolicyName)) {
            throw new \Exception("Policy '$policyName' does not exist");
        }
        return new $fullPolicyName($params);
    }
}

if (!function_exists('mapAbacFiles')) {
    /**
     * Recursively scans a directory and returns an array of file paths relative to a base path.
     *
     * @param string $basePath The base path to scan.
     * @param string $extension The file extension to filter (e.g., 'yml').
     * @return array An array of file paths relative to the base path.
     */

    function mapAbacFiles(string $basePath, string $extension = 'yml'): array
    {
        $files = [];

        // Ensure the path ends with a directory separator
        $basePath = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        // Use RecursiveDirectoryIterator to traverse directories
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($basePath, \FilesystemIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            // Check for the desired extension
            if ($file->getExtension() === $extension) {
                // Get the relative path by subtracting the base path
                $relativePath = str_replace($basePath, '', $file->getPathname());
                $files[] = $relativePath;
            }
        }

        return $files;
    }
}
