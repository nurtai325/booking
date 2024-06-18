<?php

namespace App\Booking\Messaging;

class MessagePromptResponse
{
    public string $message;
    public string $action;
    public string $phone;
    public string $name;
    public string $additional_info;
    public int $booking_id;

    public function __construct(string $message, string $action,
                                string $phone = "", string $name = "",
                                string $additional_info = "",
                                int $booking_id = 0)
    {
        $this->message = $message;
        $this->action = $action;
        $this->phone = $phone;
        $this->name = $name;
        $this->additional_info = $additional_info;
        $this->booking_id = $booking_id;
    }
}
