<?php

namespace App\Conversations\Reponses;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use App\Conversations\StartingPointConversation;
class Reponse7 extends Conversation
{
    /**
     * First question
     */
    public function talk()
    {

        $this->say('لا يوجد حاليا علاج محدد للمرض الذي يسببه فيروس كورونا الجديد. غير أن العديد من أعراضه يمكن معالجتها، وبالتالي يعتمد العلاج على الحالة السريرية للمريض. وقد تكون الرعاية الصحية للأشخاص المصابين بالعدوى ناجعة للغاية');
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
