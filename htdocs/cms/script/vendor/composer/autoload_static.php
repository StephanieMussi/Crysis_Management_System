<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8a5c029c56a5dfdbffb9ee2f91d25e14
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Abraham\\TwitterOAuth\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Abraham\\TwitterOAuth\\' => 
        array (
            0 => __DIR__ . '/..' . '/abraham/twitteroauth/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8a5c029c56a5dfdbffb9ee2f91d25e14::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8a5c029c56a5dfdbffb9ee2f91d25e14::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
