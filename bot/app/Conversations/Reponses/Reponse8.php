<?php

namespace App\Conversations\Reponses;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use App\Conversations\StartingPointConversation;
class Reponse8 extends Conversation
{
    /**
     * First question
     */
    public function talk()
    {

        $this->say('ينصح بإتباع الإرشادات سابقة الذكر مع ');
        $this->say("<ul style='list-style-type: disc !important; padding-right: 0;' dir='rtl'>
        <li>• تجنب الاتصال المباشر بالحيوانات (حية أو ميتة) أو التواجد في أسواق تداول الحيوانات </li>
        <li>• التـأكد من طهي المنتجات الحيوانية جيدا قبل تناولها</li>
        <li>• الاتصال بالمصالح الصحية في حالة ظهور أي من الأعراض المذكورة أعلاه</li>
        <li>• مراعاة البقاء في مكان الإقامة </li>
        <li>• تجنب الأماكن المزدحمة قدر الإمكان</li>
        <li>• استخدام الكمامات عند التواجد في الأماكن المزدحمة</li>
        </ul>");
    
        $this->say('وفي حالة ظهور أي من أعراض المرتبطة بهذا الفيروس المذكورة أعلاه الاتصال بالمصالح الصحية المحلية والالتزام بالإجراء المتخذة');

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
