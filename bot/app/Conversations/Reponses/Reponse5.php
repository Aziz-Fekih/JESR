<?php

namespace App\Conversations\Reponses;
use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use App\Conversations\StartingPointConversation;
class Reponse5 extends Conversation
{
    /**
     * First question
     */
    public function talk()
    {

        $this->say('نعم، تم تسجيل حالات انتقال للعدوى بين العاملين في الرعاية الصحية وذلك نظرا لاقترابهم من المرضى أكثر من عامة الناس، لذلك يوصى هؤلاء العاملين باستخدام وسائل الوقاية الشخصية المناسبة من العدوى وتدابير المكافحة اللازمة');
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
