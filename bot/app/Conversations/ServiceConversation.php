<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;


class ServiceConversation extends Conversation
{
    /**
     * First question
     */
    public function askReason()
    {

        $this->say('Notre expertise s’étale sur divers domaines pour que nos clients se retrouvent dans les meilleures dispositions afin de tirer profit de ses activités digitales.');
        $this->say('Nos services :');
        $question = Question::create("")
            ->fallback('Echec')
            ->callbackId('ask_services')
            ->addButtons([
                Button::create('Développement Web')->value('dev_web'),
                Button::create('Développement Mobile')->value('dev_mobile'),
                Button::create('Web Marketing')->value('web_mark'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $answerValue = $answer->getValue();
                
                switch ($answerValue) {
                    case 'dev_web':
                        $this->say('<b style="color:#ff9f1a">Développement Web</b><br>
                        Un site internet est une façon unique de communiquer avec le monde. 
                        Ainsi, que vous ayez choisi de créer un site web pour partager votre passion pour la musique ou les animaux, 
                        faire connaître votre entreprise aux clients potentiels, vendre des objets d’artisanat ou autre,
                         il n’y a plus de barrières. Avec un site, une multitude de possibilités s’offre à vous.');
                        break;
                    case 'dev_mobile':
                        $this->say('<b style="color:#ff9f1a">Développement Mobile</b><br>
                        Avoir une application, bien que cela devienne de plus en plus fréquent, 
                        fait de votre l’entreprise ou de votre marque un acteur moderne et proche de son consommateur.');
                        break;   
                    case 'web_mark':
                        $this->say('<b style="color:#ff9f1a">Web Marketing</b><br>
                        Nous vous rendons compte de votre positionnement sur les moteurs de recherche, la provenance et la qualité de votre trafic, 
                        votre taux de conversion (pour les sites e-commerce). 
                        Les outils du web marketing permettent d’analyser le contexte, la concurrence et la demande.');
                        break;   
                    default:
                        $this->say('Réessayer');
                        break;
                }
        
                $this->bot->startConversation(new EndingConversation());
            }else{
                $this->say('Hmm... Laissez-moi penser, vous avez dit quoi déjà?');
            }
            
        });
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askReason();
    }
}
