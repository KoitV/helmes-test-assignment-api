<?php


namespace App\EventListeners;


use Symfony\Component\HttpKernel\Event\RequestEvent;

/**
 * Interface RequestListenerInterface
 * @package App\EventListener
 *
 * https://github.com/symfony-bundles/json-request-bundle/blob/master/EventListener/RequestListenerInterface.php
 */
interface RequestListenerInterface
{
    public function onKernelRequest(RequestEvent $event): void;
}