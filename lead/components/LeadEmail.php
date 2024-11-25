<?php

namespace lead\components;

interface ILeadEmail
{
    public function work(string $email);
    public function home(string $email);
    public function mailing(string $email);
    public function other(string $email);
}

class LeadEmail
{
    private array $emails = [];
    public function addValue($email, $type): void
    {
        $this->emails[] = ["VALUE" => $email, "VALUE_TYPE" => $type];
    }
    public function getEmails(): array
    {
        return $this->emails;
    }
    public function addEmailHandler(): ILeadEmail
    {
        return new class($this) implements ILeadEmail {
            private LeadEmail $parent;
            public function __construct(LeadEmail $parent)
            {
                $this->parent = $parent;
            }

            public function work($email): void
            {
                $this->parent->addValue($email, "WORK");
            }

            public function home($email): void
            {
                $this->parent->addValue($email, "HOME");
            }

            public function mailing($email): void
            {
                $this->parent->addValue($email, "MAILING");
            }

            public function other($email): void
            {
                $this->parent->addValue($email, "OTHER");
            }
        };
    }
}
