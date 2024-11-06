<?php
declare(strict_types=1);

namespace App\Shared\Infrastructure\Event;

use App\Shared\Event\DomainEventInterface;
use Symfony\Contracts\EventDispatcher\Event;

abstract class DefaultEvent extends Event implements DomainEventInterface {}
