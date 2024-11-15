<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit48e4532c9e84a759a9a2ac3d6d2e1e9b
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit48e4532c9e84a759a9a2ac3d6d2e1e9b', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit48e4532c9e84a759a9a2ac3d6d2e1e9b', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit48e4532c9e84a759a9a2ac3d6d2e1e9b::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
