<?php
return array(
    'HcfFeedback-Controller-Save' => array(
        'parameters' => array(
            'inputData' => 'HcfFeedback-Data-Save',
            'serviceCommand' => 'HcfFeedback-Service-Save',
            'jsonResponseModelFactory' =>
                'Zf2Libs\View\Model\Json\Specific\StatusMessageDataModelFactory'
        )
    ),

    'HcfFeedback-Service-Aggregate-Persister' => array(
        'injections' => array(
            'HcfFeedback-Service-Persister-Mail'
        )
    )
);
