<?php
use App\Http\Controllers\BotManController;

$botman = resolve('botman');

//$botman->hears('Hi', function ($bot) {
//    $bot->reply('Send your full name?');
//});
//
//$botman->hears('Hi', function ($bot) {
//    $bot->reply('Pratik');
//});

$botman->hears('.*(Hi|Hello).*', BotManController::class.'@startConversation');

//$botman->hears('Start conversation', BotManController::class.'@startConversation');
