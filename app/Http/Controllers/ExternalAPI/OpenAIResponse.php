<?php

namespace App\Http\Controllers\ExternalAPI;

class OpenAIResponse
{
    public string $action;
    public string $text;
    public string $name;
    public string $phone;
    public string $additional_info;
    public int $id;

    /**
     * @param string $phone
     * @param string $action
     * @param string $text
     * @param string $name
     * @param string $additional_info
     * @param int $id
     */
    public function __construct(string $phone, string $action,
                                string $text, string $name,
                                string $additional_info, int $id)
    {
        $this->id = $id;
        $this->phone = $phone;
        $this->action = $action;
        $this->text = $text;
        $this->name = $name;
        $this->additional_info = $additional_info;
    }
}
