<?php
return array(
    'router' => include __DIR__ . '/module/router.config.php',
    'di' => include __DIR__ . '/module/di.config.php',

    'doctrine' => array(
        'driver' => array(
            'app_driver' => array(
                'paths' => array(__DIR__ . '/../src/HcfFeedback/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'HcfFeedback\Entity' => 'app_driver'
                )
            )
        )
    )
);
