<?php

declare(strict_types=1);

namespace App\Entity\Enum;

enum ParticipantRole: string
{
    case COOK = 'cook';
    case ORGANIZER = 'organizer';
    case CONTACT = 'contact';
}