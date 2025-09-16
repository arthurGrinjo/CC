<?php

namespace App\Entity\Identifier;

use ApiPlatform\Metadata\IriConverterInterface;
use App\Entity\Article;

readonly class EntityUri implements IdentifierInterface
{
    public function __construct(
        private IriConverterInterface $iriConverter,
    ) {}

    public function getClass(): string
    {
        /** todo: match against CommentableEntities  */
        return Article::class;
    }

    public function getObject(): string
    {
        return $this->iriConverter->getResourceFromIri($this);
    }
}
