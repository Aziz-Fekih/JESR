<?php

use App\Http\Controllers\BotManController;
use BotMan\BotMan\Middleware\Dialogflow;
use BotMan\BotMan\Middleware\Wit;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Incoming\Answer;
use App\Conversations\ServiceConversation;
use App\Conversations\PriceConversation;
use App\Conversations\EndingConversation;

$botman = resolve('botman');

// $cacheDriver = new \Doctrine\Common\Cache\PhpFileCache('cache');
// $botman = BotManFactory::create($config,new BotMan\BotMan\Cache\DoctrineCache($cacheDriver));

$dialogflow = DialogFlow::create('5f1d86f65be4476c9c9b37526b348879')->listenForAction();
$botman->middleware->received($dialogflow);


$botman->hears('ask.*', function ($bot) {
    // Retrieve Dialogflow information:
    $extras = $bot->getMessage()->getExtras();
    error_log(json_encode($extras));
    $apiReply = $extras['apiReply'];
    $apiAction = $extras['apiAction'];
    $apiIntent = $extras['apiIntent'];
    switch ($apiAction) {
        case 'ask-prix':
            $bot->startConversation(new PriceConversation);
            break;
        case 'ask-service':
            $bot->startConversation(new ServiceConversation);
            break;
        case 'ask-local':
            $bot->startConversation(new EndingConversation);
            break;
        default:
            if($apiReply){
                $bot->reply($apiReply);
            }else{
                $bot->reply("Je n'ai pas saisi ce que vous avez dit.");
            }
        break;
    }
})->middleware($dialogflow);

$botman->hears('input.welcome', function ($bot) {
    // Retrieve Dialogflow information:
    $extras = $bot->getMessage()->getExtras();
   
    $apiReply = $extras['apiReply'];
    $bot->reply($apiReply);
})->middleware($dialogflow)->skipsConversation();

$botman->hears('smalltalk.*', function ($bot) {
    // Retrieve Dialogflow information:
    $extras = $bot->getMessage()->getExtras();
   
    $apiReply = $extras['apiReply'];
    $bot->reply($apiReply);
})->middleware($dialogflow)->skipsConversation();

$botman->hears('start', function($bot){
    
    $bot->reply("Bonjour, je suis <b style='color:#595757'>Opti</b><b style='color:#f38e47'>Bot</b> 
    un chatbot intelligent développé et conçu par Optima Junior entreprise.");
    
    $bot->reply('Comment puis je vous aider');

    $question = Question::create('')
    ->callbackId('select_service')
    ->addButtons([
        Button::create('Nos service')->value('service'),
        Button::create('Demander un devis')->value('devis'),

    ]);

    $bot->ask($question, function(Answer $answer) {

    });

})->skipsConversation();

// $botman->hears('service', function($bot){
//     $bot->startConversation(new ServiceConversation);
// })->stopsConversation();

$botman->fallback(function($bot) {
     $bot->reply("Je n'ai pas saisi ce que vous avez dit.");
});

// $botman->hears('Hi', function ($bot) {


// //     $bot->reply("<div class='glider-contain'>
// //     <div class='glider'>
// //       <div>your con</div>
// //       <div>your cosdqsdntent here</div>
// //       <div>yqqqqqqqqur content here</div>
// //       <div>ydddddour content here</div>
// //     </div>
  
// //     <button role='button' aria-label='Previous' class='glider-prev'>«</button>
// //     <button role='button' aria-label='Next' class='glider-next'>»</button>
// //     <div role='tablist' class='dots'></div>
// //   </div><script>setGlider()</script>");
    
//     $question = Question::create('')
//     ->callbackId('select_service')
//     ->addButtons([
//         Button::create('Haisdsdsdsdsdr')->value('Hair'),
//         Button::create('Spa')->value('Spa'),
//         Button::create('Beauty')->value('Beauty'),
//         Button::create('Bqqqqeauty')->value('Beauty'),
//         Button::create('sds')->value('Beauty'),
//         Button::create('qd')->value('Beauty'),
//         Button::create('Besauty')->value('Beauty'),
//     ]);

//     $bot->ask($question, function(Answer $answer) {
//         if ($answer->isInteractiveMessageReply()) {
//             $bot->userStorage()->save([
//                 'service' => $answer->getValue(),
//             ]);
//         }
//     });

  

// })->skipsConversation();


// $botman->hears('Hi', function ($bot) {

//     $a = $bot->userStorage()->get('name');
    
//     sleep(1);
//     $bot->reply('Helloxx!  '. $a);
// });
$botman->hears('Start conversation', BotManController::class.'@startConversation')->skipsConversation();;



