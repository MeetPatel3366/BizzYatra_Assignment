<?php
use Ratchet\Server\IoServer; // Importing the IoServer class from the Ratchet library
use Ratchet\Http\HttpServer; // Importing the HttpServer class from the Ratchet library
use Ratchet\WebSocket\WsServer; // Importing the WsServer class from the Ratchet library
use MyApp\Chat; // Importing the Chat class from the MyApp namespace

require dirname(__DIR__) . '/vendor/autoload.php'; // Requiring the Composer autoloader script

$server = IoServer::factory( // Creating a new IoServer instance
    new HttpServer( // Wrapping the HttpServer around
        new WsServer( // Wrapping the WsServer around
            new Chat() // Instantiating the Chat class
        )
    ),
    8081 // Specifying the port number (8081) for the server to listen on
);

$server->run(); // Starting the server and making it run indefinitely



/*
ChatGPT
This PHP script sets up a WebSocket server using Ratchet library, importing necessary classes, requiring Composer autoloader, creating a server instance with an HTTP server wrapping a WebSocket server, using a custom Chat class, and running the server on port 8081. */