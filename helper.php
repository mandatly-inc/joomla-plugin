<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Installer\Installer;
use Joomla\CMS\Filesystem\File;

class ModInstallerHelper
{
    public static function installPlugin()
    {
        $app = Factory::getApplication();

        $remoteUrl = 'https://raw.githubusercontent.com/mandatly-inc/joomla-plugin/refs/heads/main/plg_system_mandatly-v1.1.1.zip'; 
        $localPath = JPATH_SITE . '/tmp/plg_system_mandatly-v1.1.1.zip';

        try {
            // Download the ZIP file from the remote URL
            $http = Factory::getHttpFactory()->getHttp();
            $response = $http->get($remoteUrl);

            if ($response->code !== 200) {
                throw new RuntimeException('Failed to download plugin. HTTP Status: ' . $response->code);
            }

            // Save to local file
            File::write($localPath, $response->body);

            // Install using Joomla Installer
            $installer = Installer::getInstance();
            $result = $installer->install($localPath);

            if ($result) {
                $app->enqueueMessage('Plugin installed successfully.', 'message');
            } else {
                $app->enqueueMessage('Plugin installation failed.', 'error');
            }

        } catch (Exception $e) {
            $app->enqueueMessage('Error: ' . $e->getMessage(), 'error');
        }
    }
}
