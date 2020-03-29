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
use App\Conversations\StartingPointConversation;
use App\Conversations\SuiteQuestionsConversation;

use App\Conversations\Reponses;

$botman = resolve('botman');


$botman->hears('start', function($bot){
    $bot->startConversation(new StartingPointConversation);
})->skipsConversation();


// Traiter les questions
$botman->hears('qst_.*', function($bot){
    $message = $bot->getMessage()->getPayload()['message'];
    switch($message){
        case 'qst_1': $bot->startConversation(new Reponses\Reponse1);
        break;
        case 'qst_2': $bot->startConversation(new Reponses\Reponse2);
        break;
        case 'qst_3': $bot->startConversation(new Reponses\Reponse3);
        break;
        case 'qst_4': $bot->startConversation(new Reponses\Reponse4);
        break;
        case 'qst_5': $bot->startConversation(new Reponses\Reponse5);
        break;
        case 'qst_6': $bot->startConversation(new Reponses\Reponse6);
        break;
        case 'qst_7': $bot->startConversation(new Reponses\Reponse7);
        break;
        case 'qst_8': $bot->startConversation(new Reponses\Reponse8);
        break;
        case 'qst_9': $bot->startConversation(new Reponses\Reponse9);
        break;
        case 'qst_10': $bot->startConversation(new Reponses\Reponse10);
        break;
        case 'qst_don': $bot->startConversation(new Reponses\Gouvernorat);
        break;
    }
})->skipsConversation();

$botman->hears('la_suite', function($bot){
    $bot->startConversation(new SuiteQuestionsConversation);
})->skipsConversation();






// $botman->hears('service', function($bot){
//     $bot->startConversation(new ServiceConversation);
// })->stopsConversation();

$botman->fallback(function($bot) {
    $bot->startConversation(new StartingPointConversation);
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
$botman->hears('Start conversation', BotManController::class.'@startConversation')->skipsConversation();