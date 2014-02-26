<?php
return array(
    'routes' => array(
        'feedback' => array(
            'type' => 'literal',
            'options' => array(
                'route' => '/feedback'
            ),
            'may_terminate' => false,
            'child_routes' => array(
                'save' => array(
                    'type' => 'method',
                    'options' => array(
                        'verb' => 'post',
                        'defaults' => array(
                            'controller' => 'HcfFeedback-Controller-Create'
                        )
                    )
                )
            )
        )
    )
);
