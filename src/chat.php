<?php
namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface
{
    protected $clients;
    protected $temp='';

    public function __construct()
    {
        $this->clients = [];
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients[$conn->resourceId] = $conn;
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);

        if (isset($data['type'])) {
            if ($data['type'] == 'register' && isset($data['name']) && isset($data['friend'])) {
                $this->temp =$data['friend'];
                $this->clients[$from->resourceId]->name = $data['name'];
                $this->clients[$from->resourceId]->sendingto = $data['friend'];


                echo "User {$data['name']} registered. and sending message to : {$data['friend']}\n";
            } elseif ($data['type'] == 'message' && isset($data['name'], $data['msg'], $data['friend'])) {
                $name = $data['name'];   /// sender send  name = sender name //4909
                $msg = $data['msg'];
                $friend = $data['friend']; //5172

                foreach ($this->clients as $client) {
                    if (isset($client->name) && $client->name == $friend && $client->sendingto==$name ) { //receiver side
                        if(($this->temp==$friend)  || ($this->temp==$name) ){ //screen

                            $client->send(json_encode([
                                'msg' => $msg,
                                'name' => $name,
                                'friend' => $friend
                            ]));
                        }
                    }
                }
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        unset($this->clients[$conn->resourceId]);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}