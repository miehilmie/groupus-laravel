<?php

class Grouppost extends Basemodel
{
    public function poster() {
        return $this->belongs_to('User', 'poster_id');
    }

    public function attachment() {
        return $this->belongs_to('Attachment');
    }

    public function group() {
        return $this->belongs_to('Group');
    }
}