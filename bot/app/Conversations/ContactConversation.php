<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class ContactConversation extends Conversation
{
    /**
     * First question
     */
    public function start()
    {

        $this->say("Pour toute demande de devis, de conseils, d’informations ou de rendez-vous, Prière de nous contacter sur :");

        $this->say("contact@optimaje.com");
        $this->say("+(216) 21 014 181<br>
                    +(216) 95 570 025");
        $this->say("Notre adresse : <br>	
        Faculté des Sciences de Tunis, Campus Universitaire 2092, El Manar Tunis.");

        $this->bot->startConversation(new EndingConversation());

    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->start();
    }
}
