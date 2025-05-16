<?php

namespace YourVendor\FakeInbox\Services\SpamAnalysis;

/**
 * Repository for managing spam analysis rules
 */
class SpamRuleRepository
{
    private array $rules;

    public function __construct(array $rules = [])
    {
        $this->rules = $rules;
    }

    /**
     * Get all spam rules
     *
     * @return array
     */
    public function all(): array
    {
        return $this->rules;
    }

    /**
     * Get a specific spam rule
     *
     * @param string $ruleName
     * @return array|null
     */
    public function get(string $ruleName): ?array
    {
        return $this->rules[$ruleName] ?? null;
    }
}