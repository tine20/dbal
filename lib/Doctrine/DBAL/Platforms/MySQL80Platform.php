<?php

namespace Doctrine\DBAL\Platforms;

use Doctrine\DBAL\Types\BlobType;
use Doctrine\DBAL\Types\JsonType;
use Doctrine\DBAL\Types\TextType;

/**
 * Provides the behavior, features and SQL dialect of the MySQL 8.0 (8.0 GA) database platform.
 */
class MySQL80Platform extends MySQL57Platform
{
    /**
     * {@inheritdoc}
     */
    protected function getReservedKeywordsClass()
    {
        return Keywords\MySQL80Keywords::class;
    }

    public function getDefaultValueDeclarationSQL($column)
    {
        if (isset($column['default']) && ($column['type'] instanceof TextType || $column['type'] instanceof BlobType || $column['type'] instanceof JsonType)) {
            // mysql requires text defaults to be written as expressions
            return ' DEFAULT (' . $this->quoteStringLiteral($column['default']) . ')';
        }

        return parent::getDefaultValueDeclarationSQL($column);
    }
}
