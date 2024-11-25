<?php

namespace classes\lead;

use classes\lead\components\ILeadEmail;
use classes\lead\components\ILeadPhone;
use classes\lead\components\ILeadUTM;
use classes\lead\components\LeadEmail;
use classes\lead\components\LeadPhone;
use classes\lead\components\LeadUTM;

class Bitrix24Lead
{
    private string $name;
    private string $last_name;
    private string $second_name;
    private string $title;
    private string $comments;
    private string $sonet_event;
    private int $assigned_user;
    private LeadPhone $phone;
    private LeadEmail $email;
    private LeadUTM $utm;

    private array $other_fields;

    public function __construct()
    {
        $this->phone = new LeadPhone();
        $this->email = new LeadEmail();
        $this->utm = new LeadUTM();
        $this->other_fields = [];
        $this->assigned_user = 1;
        $this->name = '';
        $this->second_name = '';
        $this->last_name = '';
        $this->comments = '';
        $this->sonet_event = 'Y';
    }

    public function disableSonetEvent(): void
    {
        $this->sonet_event = "N";
    }

    public function setAssignedUser(int $user_id): void
    {
        $this->assigned_user = $user_id;
    }

    public function setName($name): void
    {
        $this->name = $name;

        if (empty($this->title)) {
            $this->title = "Новый лид: $this->name";
        }
    }

    public function setLastName($last_name): void
    {
        $this->last_name = $last_name;
    }

    public function setSecondName($second_name): void
    {
        $this->second_name = $second_name;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function setComments($comments): void
    {
        $this->comments = $comments;
    }

    public function addPhone(): ILeadPhone
    {
        return $this->phone->addPhoneHandler();
    }

    public function addEmail(): ILeadEmail
    {
        return $this->email->addEmailHandler();
    }

    public function addUTM(): ILeadUTM
    {
        return $this->utm->addUTMHandler();
    }

    private function getPhones(): array
    {
        return $this->phone->getPhones();
    }

    private function getEmails(): array
    {
        return $this->email->getEmails();
    }

    private function getUTM(): array
    {
        return $this->utm->getUTM();
    }

    public function getData(): array
    {
        return [
            'fields' => array_merge(
                [
                    'TITLE' => $this->title,
                    'ASSIGNED_BY_ID' => $this->assigned_user,
                    'NAME' => $this->name,
                    'LAST_NAME' => $this->last_name,
                    'SECOND_NAME' => $this->second_name,
                    'COMMENTS' => $this->comments,
                    'EMAIL' => $this->email->getEmails(),
                    'PHONE' => $this->phone->getPhones(),
                ],
                $this->other_fields,
                $this->utm->getUTM()
            ),
            'params' => [
                'REGISTER_SONET_EVENT' => $this->sonet_event,
            ],
        ];
    }
}