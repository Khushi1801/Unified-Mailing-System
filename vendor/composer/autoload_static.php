<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd3761bc3d2e8c2dde4df64f078423e43
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Twilio\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Twilio\\' => 
        array (
            0 => __DIR__ . '/..' . '/twilio/sdk/src/Twilio',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd3761bc3d2e8c2dde4df64f078423e43::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd3761bc3d2e8c2dde4df64f078423e43::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd3761bc3d2e8c2dde4df64f078423e43::$classMap;

        }, null, ClassLoader::class);
    }
}
