<?php

class Ajax_Chats_Controller extends Base_Controller {
    public $restful = true;

    public function post_toggle() {
        $to= str_replace('chatid-','',Input::get('id'));
        $conversation = $this->get_conversation($to);
        $my_chat = $conversation->sender_chat();
        $my_chat->toggle = (Input::get('status') == 'true') ? 1 : 0;
        if((Input::get('status') == 'true')) {
            $to_chat = $conversation->receiver_chat();
            $my_chat->last_activity = $to_chat->last_activity;
        }
        $my_chat->save();

        return $my_chat->toggle;
    }

    public function post_closechat() {
        $to= str_replace('chatid-','',Input::get('id'));
        $conversation = $this->get_conversation($to);
        $my_chat = $conversation->sender_chat();
        $my_chat->open = 0;
        $to_chat = $conversation->receiver_chat();
        $my_chat->last_activity = $to_chat->last_activity;
        $my_chat->toggle = 0;
        $my_chat->save();

        return $my_chat->open;
    }

    public function post_openchat() {
        $to= str_replace('chatid-','',Input::get('id'));
        $conversation = $this->get_conversation($to);
        $my_chat = $conversation->sender_chat();
        $my_chat->open = 1;
        $my_chat->toggle = (Input::get('dft') == 'true') ? 1 : 0;
        $my_chat->save();


        $o = new stdClass();
        $o->msg = json_decode(eloquent_to_json($my_chat->messages));
        $o->belongs_to = $to;
        $o->name = Str::limit($my_chat->receiver->name, 10);

        $o->error = 0;

        return json_encode($o);
    }

    public function post_send() {

        $now  = date('Y-m-d H:i:s',time());
        $user = Auth::user();

        $to= str_replace('chatid-','',Input::get('id'));
        $conversation = $this->get_conversation($to);
        $my_chat = $conversation->sender_chat();
        $my_chat->last_activity = $now;
        $my_chat->save();
        $to_chat = $conversation->receiver_chat();
        $to_chat->toggle = ($to_chat->open == '0') ? 0 :  $to_chat->toggle;
        if($to_chat->toggle == 1) {
            $to_chat->last_activity = $now;
        }
        $to_chat->open = 1;
        $to_chat->save();
        $msg = Chatmessage::create(array(
            'message'         => Input::get('message'),
            'created_at'      => $now,
            'sender_id'       => $user->id,
            'conversation_id' => $conversation->id
        ));

        $response = new stdClass();
        $response->message = Input::get('message');
        $response->time = $now;

        return json_encode($response);

    }
    /**
     * for live long poll chat message
     * @return json
     */
    public function get_update() {
        // Ignore user aborts and allow the script
        // to run forever
        ignore_user_abort(true);
        set_time_limit(0);

        $sleepTime = 1; //Seconds
        $data = 0;
        $timeout = 0;
        $time = Input::get('timestamp');
        $user = Auth::user();
        //Query database for data
        $response = new stdClass();

        // initialize
        if(!$time) {
            $response->o = array();
            $response->timestamp = time();
            return json_encode($response);
        }


        // Run a pointless loop that sometime
        // hopefully will make us click away from
        // page or click the "Stop" button.
        $last_time  = date('Y-m-d H:i:s',$time);
        while(1)
        {
            // Did the connection fail?
            if((connection_status() != CONNECTION_NORMAL) || $data || $timeout >= 20)
            {
                break;
            }

            // Sleep for 10 seconds
            $to_chat = Chat::where('receiver_id', '=', $user->id)
                ->where('last_activity', '>', $last_time)
                ->get();

            if(count($to_chat) > 0){
                $data = true;
            }

            flush();
            sleep($sleepTime);
            $timeout++;

        }

        // If this is reached, then the 'break'
        // was triggered from inside the while loop

        // So here we can log, or perform any other tasks
        // we need without actually being dependent on the
        // browser.
        if(count($to_chat) > 0) {
            $response->o = array();
            foreach ($to_chat as $chat) {
                $msgs = $chat->messages()
                    ->where('created_at', '>', $last_time)
                    ->where('sender_id','!=',$user->id)
                    ->get();
                if(count($msgs) == 0) {
                    continue;
                }

                $robj = new stdClass();
                $robj->id = $chat->sender->id;
                $robj->fullname = $chat->sender->name;
                $robj->name = Str::limit($robj->fullname, 10);
                $robj->msgs = array();
                $robj->jewel = 0;
                if($chat->conversation->sender_chat()->toggle == 0) {
                    $robj->jewel = count($msgs);
                }
                foreach ($msgs as $m) {
                    if($m->sender_id !== $user->id){
                        $robj->msgs[] = json_decode(eloquent_to_json($m));
                    }
                }

                $response->o[] = $robj;
            }

            $response->timestamp = time();
            $data = true;

            return json_encode($response);
        }

        return Response::error('404');

    }

    private function get_conversation($to) {
        $now  = date('Y-m-d H:i:s',time());
        $user = Auth::user();

        $from = $user->id;

        $from_chat   = Chat::where_sender_id_and_receiver_id($from, $to)->first();
        $to_chat = Chat::where_sender_id_and_receiver_id($to, $from)->first();

        if(!$to_chat || !$from_chat) {
            // no conversation yet
            $conversation = Conversation::create(array(
                'last_activity' => $now
            ));

            $conversation_id = $conversation->id;
            if(!$to_chat) {
                $to_chat = Chat::create(array(
                    'sender_id'       => $to,
                    'receiver_id'     => $from,
                    'conversation_id' => $conversation_id
                ));
            }

            if(!$from_chat) {
                $from_chat = Chat::create(array(
                    'sender_id'       => $from,
                    'receiver_id'     => $to,
                    'conversation_id' => $conversation_id
                ));
            }
        }else {
            $conversation_id = $to_chat->conversation_id;
            $conversation    = Conversation::find($conversation_id);
        }

        return $conversation;
    }
}