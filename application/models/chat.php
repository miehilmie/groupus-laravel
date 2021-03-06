<?php

class Chat extends Basemodel {
    public static $timestamps = false;

    public function conversation() {
        return $this->belongs_to('Conversation');
    }
    public function messages() {
        return $this->conversation->messages()->order_by('created_at', 'asc');
    }
    public function receiver() {
        return $this->belongs_to('User', 'receiver_id');
    }
    public function sender() {
        return $this->belongs_to('User', 'sender_id');
    }
    public function jewel() {
        return Chatmessage::where('conversation_id', '=', $this->conversation_id)
            ->where('created_at', '>', $this->last_activity)->count();
    }
}