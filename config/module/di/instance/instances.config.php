<?php
return array(
    'HcfFeedback-Controller-Create' => array(
        'parameters' => array(
            'inputData' => 'HcfFeedback-Data-Create',
            'serviceCommand' => 'HcfFeedback-Service-Create',
            'jsonResponseModelFactory' =>
                'Zf2Libs\View\Model\Json\Specific\StatusMessageDataModelFactory'
        )
    ),

    'HcfFeedback-Service-Persister-Mail' => array(
        'parameters' => array(
            'mailService' => 'HcCore-Service-Mail'
        )
    ),

    'HcfFeedback-Service-Aggregate-Persister' => array(
        'injections' => array(
            'HcfFeedback-Service-Persister-Mail'
        )
    )
);
