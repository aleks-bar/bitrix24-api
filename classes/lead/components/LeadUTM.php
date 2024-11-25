<?php

namespace classes\lead\components;

interface ILeadUTM
{
    public function source(string $value);
    public function medium(string $value);
    public function campaign(string $value);
    public function content(string $value);
    public function term(string $value);
}
class LeadUTM
{
    private array $UTM_Values;
    public function setUTM($name, $value): void
    {
        $this->UTM_Values[$name] = $value;
    }
    public function addUTMHandler(): ILeadUTM
    {
        return new class($this) implements ILeadUTM {
            private LeadUTM $parent;

            public function __construct(LeadUTM $parent)
            {
                $this->parent = $parent;
            }

            public function source(string $value): void
            {
                $this->parent->setUTM('UTM_SOURCE', $value);
            }

            public function medium(string $value): void
            {
                $this->parent->setUTM('UTM_MEDIUM', $value);
            }

            public function campaign(string $value): void
            {
                $this->parent->setUTM('UTM_CAMPAIGN', $value);
            }

            public function content(string $value): void
            {
                $this->parent->setUTM('UTM_CONTENT', $value);
            }

            public function term(string $value): void
            {
                $this->parent->setUTM('UTM_TERM', $value);
            }
        };
    }

    public function __construct()
    {
        $this->UTM_Values = [];
    }

    public function getUTM(): array
    {
        return $this->UTM_Values;
    }
}
