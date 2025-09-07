<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Article;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Article>
 */
final class ArticleFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Article::class;
    }

    /**
     * @return string[]
     */
    protected function defaults(): array
    {
        $article = self::faker()->paragraphs(5);
        return [
            'title' => 'Article-' . self::faker()->text(20),
            'text' => 'Text-' . (is_array($article) ? implode('<br /><br />', $article) : $article),
        ];
    }
}
