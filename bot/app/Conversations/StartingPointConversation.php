<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class StartingPointConversation extends Conversation
{
    /**
     * First question
     */
    public function start()
    {
        $this->say('مرحبا , انا جسر بوت وبش نعاونك تفهم كيفاش تستعمل منصة جسر كيما زادا نعطيك نصايح كيفاش تحمي روحك من فيروس كورونا
        ');
        $question = Question::create("")
            ->fallback('Echec')
            ->callbackId('ask_')
            ->addButtons([
                Button::create('نحب نتبرع ونعاون بلادي')->value('qst_don'),
                Button::create('ما هو فيروس كورونا الجديد؟')->value('qst_1'),
                Button::create('ما هي أعراض الإصابة بفيروس كورونا الجديد ؟')->value('qst_2'),
                Button::create('ما الذي يمكن القيام به للحماية من الفيروس الجديد؟')->value('qst_3'),
                Button::create('إظهار المزيد')->value('la_suite'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $answerValue = $answer->getValue();
                switch ($answerValue) {
                    case 'qst_1':
                        $this->bot->startConversation(new  Reponses\Reponse1());
                        break;
                    case 'qst_2':
                        $this->bot->startConversation(new  Reponses\Reponse2());
                        break;   
                    case 'qst_3':
                        $this->bot->startConversation(new  Reponses\Reponse3());
                        break;
                    case 'qst_don':
                        $this->bot->startConversation(new  Reponses\Gouvernorat());
                        break;
                    case 'la_suite':
                        $this->bot->startConversation(new  SuiteQuestionsConversation());
                        break; 
                }
            }else{
                $this->bot->startConversation(new StartingPointConversation());
            }
        });
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->start();
    }
}
