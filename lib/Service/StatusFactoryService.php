<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\UserRegistrationBundle\Service;

use DawBed\ContextBundle\Service\AbstractContextFactory;
use DawBed\ContextBundle\Service\CreateServiceInterface;
use DawBed\ContextBundle\Service\FactoryCollection;
use DawBed\PHPStatus\Status;
use DawBed\StatusBundle\Service\CreateService;
use DawBed\StatusBundle\Service\EntityService;


class StatusFactoryService extends AbstractContextFactory
{
    const REGISTRATION_ID = 1;

    private $entityService;
    private $createService;

    public function __construct(CreateService $createService, EntityService $entityService)
    {
        $this->entityService = $entityService;
        $this->createService = $createService;
    }

    protected function getCreateService(): CreateServiceInterface
    {
        return $this->createService;
    }

    protected function getFactories(): FactoryCollection
    {
        $factoryCollection = new FactoryCollection();
        $factoryCollection->append(self::REGISTRATION_ID, $this->registration());
        return $factoryCollection;
    }

    private function registration(): \Closure
    {
        return \Closure::bind(function (): Status {
            return (new $this->entityService->Status)
                ->setType(self::REGISTRATION_ID)
                ->setName('User Registration');
        }, $this);
    }
}