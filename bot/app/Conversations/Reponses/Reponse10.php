<?php

namespace App\Conversations\Reponses;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use App\Conversations\StartingPointConversation;
class Reponse10 extends Conversation
{
    /**
     * First question
     */
    public function talk()
    {

        $this->say(' للمزيد من المعلومات عن فيروس كورونا الجديد الرجاء  الاطلاع على موقع ');
        $this->say("­<a href='http://www.sante.tn/'>www.sante.tn</a> وزارة الصحة");
        $this->say("­<a href='https://www.onmne.tn/fr/index.php'>www.onmne.tn</a> المرصد الوطني للأمراض الجديدة والمستجدة ");



        $question = Question::create("")
        ->fallback('Unable to ask question')
        ->callbackId('ask_end')
            ->addButtons([
                Button::create('رجوع')->value('btn_retour'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'btn_retour') {
                    $this->bot->startConversation(new StartingPointConversation());
            }else{
                $this->bot->startConversation(new StartingPointConversation());
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
        $this->talk();
    }
}
