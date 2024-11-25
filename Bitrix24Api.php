<?php

class Bitrix24Api
{
    private static Bitrix24Api $instance;
    private string $USER_ID;
    private string $URL_HASH;
    private string $SUBDOMAIN;

    public static function getInstance(): Bitrix24Api
    {
        return self::$instance ?? self::$instance = new self();
    }

    /**
     * @param string $user_id
     */
    public function setUser(string $user_id): void
    {
        $this->USER_ID = $user_id;
    }

    /**
     * @param string $hash
     */
    public function setHash(string $hash): void
    {
        $this->URL_HASH = $hash;
    }

    /**
     * @param string $subdomain
     */
    public function setSubdomain(string $subdomain): void
    {
        $this->SUBDOMAIN = $subdomain;
    }

    /**
     * @return string|null
     */
    private function url(): ?string
    {
        if (!empty($this->SUBDOMAIN) && !empty($this->USER_ID) && !empty($this->URL_HASH)) {
            return 'https://'.$this->SUBDOMAIN.'.bitrix24.ru/rest/'.$this->USER_ID.'/'.$this->URL_HASH;
        }
        return null;
    }

    public function addLead(array $lead_data): array
    {
        $add_lead_path = '/crm.lead.add.json';
        $default_url = $this->url();

        if (!empty($default_url) && !empty($lead_data)) {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_POST => 1,
                CURLOPT_HEADER => 0,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $default_url . $add_lead_path,
                CURLOPT_POSTFIELDS => http_build_query($lead_data),
            ]);

            $result = curl_exec($curl);
            curl_close($curl);

            return json_decode($result, true);
        }

        return ['message' => 'incorrect url or lead data'];
    }
}
