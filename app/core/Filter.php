<?php

namespace App\Core;

class Filter
{
    private static ?Filter $instance = null;
    private array $filters = [];
    private array $params = [];

    private function __construct() {}

    public static function getInstance(): Filter
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function addStringFilter(string $field, string $value, string $operator = '=', string $tableAlias = ''): self
    {
        $prefix = $tableAlias ? "{$tableAlias}." : "";
        $paramName = ":{$field}_" . count($this->params);
        
        $this->filters[] = "{$prefix}{$field} {$operator} {$paramName}";
        $this->params[$paramName] = $value;
        
        return $this;
    }

    public function addLikeFilter(string $field, string $value, string $tableAlias = '', bool $caseInsensitive = true): self
    {
        $prefix = $tableAlias ? "{$tableAlias}." : "";
        $paramName = ":{$field}_" . count($this->params);
        
        $fieldRef = $caseInsensitive ? "LOWER({$prefix}{$field})" : "{$prefix}{$field}";
        $this->filters[] = "{$fieldRef} LIKE {$paramName}";
        $this->params[$paramName] = '%' . strtolower($value) . '%';
        
        return $this;
    }

    public function addDateFilter(string $field, string $value, string $tableAlias = ''): self
    {
        $prefix = $tableAlias ? "{$tableAlias}." : "";
        $paramName = ":{$field}_" . count($this->params);
        
        $this->filters[] = "DATE({$prefix}{$field}) = {$paramName}";
        $this->params[$paramName] = $value;
        
        return $this;
    }

    public function getWhereClause(): string
    {
        return !empty($this->filters) ? ' AND ' . implode(' AND ', $this->filters) : '';
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function reset(): void
    {
        $this->filters = [];
        $this->params = [];
    }
}