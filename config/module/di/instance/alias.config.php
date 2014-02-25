<?php
return array(
    'HcfFeedback-Controller-Save' =>
        'HcCore\Controller\Common\Rest\Collection\DataController',

    'HcfFeedback-Service-Save' =>
        'HcfFeedback\Service\SaveService',

    'HcfFeedback-Data-Save' =>
        'HcfFeedback\Data\Save',

    'HcfFeedback-Service-Aggregate-Persister' =>
        'HcfFeedback\Service\Persister\AggregatePersister',

    'HcfFeedback-Service-Persister-Database' =>
        'HcfFeedback\Service\Persister\DatabasePersister',

    'HcfFeedback-Service-Persister-Mail' =>
        'HcfFeedback\Service\Persister\MailPersister',

    'HcfFeedback-Service-Mail-Message-Common' =>
        'HcfFeedback\Service\Mail\Message\CommonFactory',
);
