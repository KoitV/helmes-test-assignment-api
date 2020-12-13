<?php


namespace App\EventListeners;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;

/**
 * Class JsonRequestTransformerListener
 * @package App\EventListener
 *
 * https://github.com/symfony-bundles/json-request-bundle/blob/master/EventListener/RequestTransformerListener.php
 */
class JsonRequestTransformerListener implements RequestListenerInterface
{


    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (false === $this->isAvailable($request)) {
            return;
        }

        if (false === $this->transform($request)) {
            $response = new Response('Unable to parse request.', Response::HTTP_BAD_REQUEST);

            $event->setResponse($response);
        }
    }

    private function isAvailable(Request $request): bool
    {
        return 'json' === $request->getContentType() && $request->getContent();
    }

    private function transform(Request $request): bool
    {
        $data = \json_decode($request->getContent(), true);

        if (\json_last_error() !== \JSON_ERROR_NONE) {
            return false;
        }

        if (\is_array($data)) {
            $request->request->replace($data);
        }

        return true;
    }
}