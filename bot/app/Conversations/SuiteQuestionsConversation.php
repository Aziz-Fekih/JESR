<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class SuiteQuestionsConversation extends Conversation
{
    /**
     * First question
     */
    public function start()
    {

        // $this->say('مرحبًا ، أنا برنامج دردشة ذكي تم تطويره لمساعدتك على فهمك وحمايتك من فيروس كورونا');
        $question = Question::create("")
            ->fallback('Echec')
            ->callbackId('ask_')
            ->addButtons([
                Button::create('هل أعوان الصحة عرضة للإصابة بفيروس كورونا الجديد؟')->value('qst_5'),
                Button::create('هل يوجد لقاح ضد فيروس كورونا الجديد ؟')->value('qst_6'),
                Button::create('هل يوجد علاج ضد فيروس كورونا الجديد؟')->value('qst_7'),
                Button::create('ما هي الإجراءات بالنسبة للمسافرين إلى المناطق التي ظهر فيها فيروس كورونا الجديد؟  ')->value('qst_8'),
                Button::create('ما هي الإجراءات بالنسبة للقادمين من جمهورية الصين الشعبية؟')->value('qst_9'),
                Button::create('أين يمكن الحصول على مزيد من المعلومات عن فيروس كورونا الجديد ؟')->value('qst_10'),
                Button::create('رجوع')->value('btn_retour'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $answerValue = $answer->getValue();
                
                switch ($answerValue) {
                    case 'qst_1':
                        $this->bot->startConversation(new EndingConversation());
                        break;
                    case 'qst_2':
                        $this->bot->startConversation(new EndingConversation());
                        break;   
                    case 'qst_3':
                        $this->bot->startConversation(new EndingConversation());
                        break;
                    case 'qst_4':
                        $this->bot->startConversation(new EndingConversation());
                        break;
                    case 'qst_5':
                        $this->bot->startConversation(new EndingConversation());
                        break;
                    case 'qst_6':
                        $this->bot->startConversation(new EndingConversation());
                        break;     
                    case 'btn_retour': 
                        $this->bot->startConversation(new StartingPointConversation());   
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
