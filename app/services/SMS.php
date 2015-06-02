<?php

class SMS {

    public static function message($receiver, $announcement) {

        $sid = $_ENV['TWILIO_SID']; // Your Account SID from www.twilio.com/user/account
        $token = $_ENV['TWILIO_TOKEN']; // Your Auth Token from www.twilio.com/user/account

        $sender = User::find($announcement->sender_id);

        $client = new Services_Twilio($sid, $token);
        $message = $client->account->messages->sendMessage(
            '+13344685575', // From a valid Twilio number
            $receiver->mobile_number, // Text this number
            $announcement->title
            . "\n\n"
            .$announcement->body
            . "\nBy: "
            . $sender->first_name . " " . $sender->middle_initial . ". " . $sender->last_name
        );

        return $message;
    }

}