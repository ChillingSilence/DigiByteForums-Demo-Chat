# DigiByteForums-Demo-Chat
Demo website used at DigiByteForums.io

A simple website to show people how to use Digi-ID to register / log in to websites. The users Digi-ID is shown if you hover your mouse above the name.


Installation
============
* Create a MySQL database
* Configure database information and server url in config.php


Notes
=====
* GMP PHP extension is required

* By default, it will only allow 1 user by IP to **try** login at the same time (once a user is logged, another user could start the login process), this example could be modified to allow several (no need to modify DigiID)