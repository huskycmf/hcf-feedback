<?php
return array(
    'HcfFeedback-Controller-Create' =>
        'HcCore\Controller\Common\Rest\Collection\DataController',

    'HcfFeedback-Service-Create' =>
        'HcfFeedback\Service\CreateCommand',

    'HcfFeedback-Data-Create' =>
        'HcfFeedback\Data\Create',

    'HcfFeedback-Service-Aggregate-Persister' =>
        'HcfFeedback\Service\Persister\AggregatePersister',

    'HcfFeedback-Service-Persister-Database' =>
        'HcfFeedback\Service\Persister\DatabasePersister',

    'HcfFeedback-Service-Persister-Mail' =>
        'HcfFeedback\Service\Persister\MailPersister',

    'HcfFeedback-Service-Mail-Message-Common' =>
        'HcfFeedback\Service\Mail\Message\CommonFactory',
);
