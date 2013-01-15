<?php

class Chatmessage extends Basemodel {
    public static $timestamps = false;

    public function conversation() {
        return $this->belongs_to('Conversation');
    }

    public function sender() {
        return $this->belongs_to('User', 'sender_id');
    }

}