<?php
namespace HcfFeedback;

use HcfFeedback\Options\ModuleOptions;
use Zend\Mvc\MvcEvent;

class Module
{
    /**
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        /* @var $sm \Zend\ServiceManager\ServiceManager */
        $sm = $e->getApplication()->getServiceManager();

        /* @var $di \Zend\Di\Di */
        $di = $sm->get('di');

        $config = $sm->get('config');

        $options = new ModuleOptions(isset($config['hcf-feedback']) ?
                                     $config['hcf-feedback'] :
                                     array());
        $di->instanceManager()
           ->addSharedInstance($options, 'HcfFeedback\Options\ModuleOptions');
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                )
            )
        );
    }
}
