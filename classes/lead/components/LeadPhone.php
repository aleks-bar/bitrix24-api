<?php

namespace classes\lead\components;

interface ILeadPhone
{
    public function mobile(string $phone);
    public function work(string $phone);
    public function fax(string $phone);
    public function home(string $phone);
    public function pager(string $phone);
    public function mailing(string $phone);
    public function other(string $phone);
}

class LeadPhone
{
    private array $phones = [];
    public function addValue($phone, $type): void
    {
        $this->phones[] = ["VALUE" => $phone, "VALUE_TYPE" => $type];
    }
    public function getPhones(): array
    {
        return $this->phones;
    }
    public function addPhoneHandler(): ILeadPhone
    {
        return new class($this) implements ILeadPhone {
            private LeadPhone $parent;
            public function __construct(LeadPhone $parent)
            {
                $this->parent = $parent;
            }

            public function mobile($phone): void
            {
                $this->parent->addValue($phone, "MOBILE");
            }

            public function work($phone): void
            {
                $this->parent->addValue($phone, "WORK");
            }

            public function fax($phone): void
            {
                $this->parent->addValue($phone, "FAX");
            }

            public function home($phone): void
            {
                $this->parent->addValue($phone, "HOME");
            }

            public function pager($phone): void
            {
                $this->parent->addValue($phone, "PAGER");
            }

            public function mailing($phone): void
            {
                $this->parent->addValue($phone, "MAILING");
            }

            public function other($phone): void
            {
                $this->parent->addValue($phone, "OTHER");
            }
        };
    }
}
