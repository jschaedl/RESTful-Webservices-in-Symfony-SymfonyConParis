<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Negotiation\ContentNegotiator;
use App\Negotiation\MimeType;
use App\Negotiation\RequestFormat;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

#[AsEventListener(event: KernelEvents::REQUEST, method: 'onKernelRequest', priority: 8)]
class RequestFormatListener
{
    private array $formats = [
        RequestFormat::JSON => MimeType::JSON,
        RequestFormat::JSON_HAL => MimeType::JSON_HAL,
        RequestFormat::XML => MimeType::XML,
    ];

    public function __construct(
        private ContentNegotiator $contentNegotiator
    ) {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        $this->addRequestFormats($request, $this->formats);

        $request->setRequestFormat(
            $this->contentNegotiator->getNegotiatedRequestFormat()
        );
    }

    /**
     * Adds the supported formats to the request.
     *
     * This is necessary for {@see Request::getMimeType} to work.
     */
    private function addRequestFormats(Request $request, array $formats): void
    {
        foreach ($formats as $format => $mimeType) {
            $request->setFormat($format, $mimeType);
        }
    }
}
