<?php

namespace App\Dto\Event\Response;

use App\Dto\Response;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

class EventCollectionResponse implements Response
{
    public function __construct(
        #[SerializedName('id'), Assert\NotBlank]
        public Uuid $uuid,

        #[SerializedName('name'), Assert\NotBlank]
        public string $name,
    ) {}
}