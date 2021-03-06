<?php

namespace App\Conversations\Reponses;
use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use App\Conversations\StartingPointConversation;
class Reponse3 extends Conversation
{
    /**
     * First question
     */
    public function talk()
    {

        $this->say('<strong>للحدّ من التعرض للإصابة بفيروس كورونا ومنع انتقاله يرجى إتباع الإجراءات الوقائية التالية </strong>');
        $this->say('	.غسل اليدين عدة مرات في اليوم بالماء والصابون أو استخدام مادة مطهرة (solution hydroalcoolique) ');
        $this->say('	.تجنب الاتصال المباشر مع أي شخص يعاني من الأعراض المذكورة أو الالتهاب التنفسي الحاد');
        $this->say('	.استخدام المنديل الورقي أو باطن مرفق اليد عند العطس أو السعال ووضع المنديل بعد استعماله مباشرة في سلة المهملات');

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
