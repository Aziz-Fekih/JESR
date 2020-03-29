<?php

namespace App\Conversations\Reponses;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use App\Conversations\StartingPointConversation;
class Reponse9 extends Conversation
{
    /**
     * First question
     */
    public function talk()
    {

        $this->say('خلال 14 يوما الماضية أو إذا كنت على اتصال مباشر مع شخص يعاني من التهاب رئوي وكنت تعاني من الأعراض المذكورة أعلاه ');
        $this->say('­	خلال السفر يرجى إعلام طاقم الطائرة للاتصال بفرق المراقبة الصحية بالمطارات والمواني');
        $this->say('­	في صورة ظهور الأعراض بعد مغادرة المطار يتعين ملازمة مكان الإقامة واتخاذ إجراءات الوقاية والاتصال هاتفيا بطبيب أو الاتصال برقم 190 لإعلامهم بالأعراض');
        $this->say('­	عدم الاتجاه للأقسام الإستعجالية للحد من انتشار المرض');


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
