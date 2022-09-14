<?php 

namespace App;

use Pusher\Pusher;

class PusherHelpers {
    public function __construct() {
        $options = array(
            'cluster' => config('broadcasting.connections.pusher.options.cluster'),
            'useTLS' => true
        );
        
        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            $options
        );

        $this->pusher = $pusher;
    }

    public function trigger($channel, $event, $data) {
        
        $this->pusher->trigger($channel, $event, $data);
    }
}