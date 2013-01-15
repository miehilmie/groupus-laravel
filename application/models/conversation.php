<?php

class Conversation extends Basemodel {
    public static $timestamps = false;

    public function messages() {
        return $this->has_many('Chatmessage');
    }

    public function sender_chat() {
        return Chat::where_sender_id_and_conversation_id(Auth::user()->id, $this->id)->first();
    }
    public function receiver_chat() {
        return Chat::where_receiver_id_and_conversation_id(Auth::user()->id, $this->id)->first();
    }
}