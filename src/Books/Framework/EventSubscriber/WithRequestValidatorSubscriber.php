<?php

namespace Task\Books\Framework\EventSubscriber;

use ReflectionMethod;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Task\Books\Application\Book\Validator\RequestDataValidator;
use Task\Books\Framework\Annotations\WithRequestValidator;

readonly class WithRequestValidatorSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private RequestDataValidator $requestDataValidator,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => ['onKernelController', -3],
        ];
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $request = $event->getRequest();

        /** @var ?WithRequestValidator $attribute */
        $attribute = $this->fromMethod($request);

        if (null === $attribute) {
            return;
        }

        $data = $request->toArray();
        $this->requestDataValidator->validate($data, $attribute->validatorDefinition);
    }

    private function fromMethod(Request $request): ?object
    {
        try {
            $method = new ReflectionMethod($request->attributes->get('_controller'));

            $attributes = $method->getAttributes(WithRequestValidator::class);

            if ([] === $attributes) {
                return null;
            }

            return $attributes[0]->newInstance();
        } catch (\Throwable) {
            return null;
        }
    }
}