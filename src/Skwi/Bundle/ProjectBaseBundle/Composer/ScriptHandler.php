<?php

namespace Skwi\Bundle\ProjectBaseBundle\Composer;

use Composer\Script\CommandEvent;

class ScriptHandler extends \Sensio\Bundle\DistributionBundle\Composer\ScriptHandler
{
    /**
     * Clears the Symfony cache for prod environnement.
     *
     * @param $event CommandEvent A instance
     */
    public static function clearCacheProd(CommandEvent $event)
    {
        $options = self::getOptions($event);
        $appDir = $options['symfony-app-dir'];

        if (!is_dir($appDir)) {
            echo 'The symfony-app-dir ('.$appDir.') specified in composer.json was not found in '.getcwd().', can not clear the cache.'.PHP_EOL;

            return;
        }

        static::executeCommand($event, $appDir, 'cache:clear --no-warmup --env=prod ', $options['process-timeout']);
    }

    /**
     * Installs the assets under the web root directory, as symlinks.
     *
     * @param $event CommandEvent A instance
     */
    public static function installAssetsSymlink(CommandEvent $event)
    {
        $options = self::getOptions($event);
        $appDir = $options['symfony-app-dir'];
        $webDir = $options['symfony-web-dir'];

        if (!is_dir($webDir)) {
            echo 'The symfony-web-dir ('.$webDir.') specified in composer.json was not found in '.getcwd().', can not install assets.'.PHP_EOL;

            return;
        }

        static::executeCommand($event, $appDir, 'assets:install --symlink '.escapeshellarg($webDir));
    }
}
