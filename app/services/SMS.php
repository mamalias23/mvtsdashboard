<?php

class SMS {

    public static function message($receiver, $announcement) {

        $sid = "AC147dceeb8ec57e4347457eb5ff74d3be"; // Your Account SID from www.twilio.com/user/account
        $token = "ffbc6aad8fee23fec4c46be732f98edc"; // Your Auth Token from www.twilio.com/user/account

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