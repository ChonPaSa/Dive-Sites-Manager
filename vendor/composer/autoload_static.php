<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf95ad4aa884796d22e448759b91e37fb
{
    public static $prefixLengthsPsr4 = array (
        'c' => 
        array (
            'cfishDSMInc\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'cfishDSMInc\\' => 
        array (
            0 => __DIR__ . '/../..' . '/cfish-dsm-inc',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf95ad4aa884796d22e448759b91e37fb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf95ad4aa884796d22e448759b91e37fb::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
