<?php

namespace App\Conversations\Reponses;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use App\Conversations\StartingPointConversation;
use Ixudra\Curl\Facades\Curl;
class Gouvernorat extends Conversation
{
    public function AssociationParticulier()
    {   
        $this->say("😇😇مرحبا بيك في منصة جسر بش نجمو ناخذو التبرع متاعك لو تسمح تجاوب علاسئلة هاذم ");
        $this->say(" 😍انت متطوّع ولا تمثّل جمعية ؟");
        $question = Question::create("")
        ->fallback('Unable to ask question')
        ->callbackId('ask_end')
            ->addButtons([
                Button::create('متطوّع')->value('Particulier'),
                Button::create('جمعية ')->value('Association'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $type_action = $answer->getValue();
                $this->bot->userStorage()->save([
                    'type_action' => $type_action,
                ]);
                $this->askFirstname();
        }else{
            $this->bot->startConversation(new StartingPointConversation());
        }
        });
    }
    public function askFirstname()
    {   
        $this->ask(" 😀تنجّم تعطيني لسمك و لقبّك ؟", function(Answer $answer) {
            // Save result
            $nom = $answer->getText();
            $this->bot->userStorage()->save([
                'nom' => $nom,
            ]);
            $this->askTelephone();
        });
    }
    public function askTelephone()
    {
        $this->ask(' 😉كان تنجّم تعطيني نومروك ؟', function(Answer $answer) {
            // Save result
            $telephone = $answer->getText();
            $this->bot->userStorage()->save([
                'telephone' => $telephone,
            ]);
            $this->askGouvernorat();
        });
    }


    public function askGouvernorat()
    {

        $this->say(" 😍تنجم تختار الولاية متاعك ؟ ");
        $question = Question::create("")
        ->fallback('Unable to ask question')
        ->callbackId('ask_end')
            ->addButtons([
                Button::create('أريانة')->value('Ariana'),
                Button::create('باجة')->value('Beja'),
                Button::create('بن عروس')->value('Ben Arous'),
                Button::create('بنزرت')->value('Bizerte'),
                Button::create('قابس')->value('Gabes'),
                Button::create('قفصة')->value('Gafsa'),
                Button::create('جندوبة')->value('Jendouba'),
                Button::create('القيروان')->value('Kairouan'),
                Button::create('القصرين')->value('Kasserine'),
                Button::create('قبلي')->value('Kebili'),
                Button::create('الكاف')->value('Le kef'),
                Button::create('المهدية')->value('Mahdia'),
                Button::create('منوبة')->value('Manouba'),
                Button::create('مدنين')->value('Medenine'),
                Button::create('المنستير')->value('Monastir'),
                Button::create('نابل')->value('Nabeul'),
                Button::create('صفاقس')->value('Sfax'),
                Button::create('سيدي بوزيد')->value('Sidi Bouzid'),
                Button::create('سليانة')->value('Siliana'),
                Button::create('سوسة')->value('Sousse'),
                Button::create('تطاوين')->value('Tataouine'),
                Button::create('توزر')->value('Tozeur'),
                Button::create('تونس')->value('Tunis'),
                Button::create('زغوان')->value('Zaghouan'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $gouvernorat = $answer->getValue();
                $this->bot->userStorage()->save([
                    'gouvernorat' => $gouvernorat,
                ]);
                $this->askAdresse();
        }else{
            $this->bot->startConversation(new StartingPointConversation());
        }
        });
    }

    public function askAdresse()
    {
        $this->ask('🏡 تنجم تقلي وين تسكن ؟ ', function(Answer $answer) {
            // Save result
            $adresse = $answer->getText();
            $this->bot->userStorage()->save([
                'adresse' => $adresse,
            ]);
            $this->askTypeDon();
        });
    }
    public function askTypeDon()
    {
        $this->say("😍شنوة نوع التبرع الي بش تعطيه ");
        $question = Question::create("")
        ->fallback('Unable to ask question')
        ->callbackId('ask_end')
            ->addButtons([
                Button::create('فلوس')->value('Argent'),
                Button::create('ماكلة ')->value('Nourriture'),
                Button::create('موارد بشرية')->value('Ressources Humaines'),
                Button::create('أجهزة')->value('Ressources Materiels'),
                Button::create('حجاة اخرة')->value('Autres'),
            ]);
        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $type_don = $answer->getValue();
                $this->bot->userStorage()->save([
                    'type_don' => $type_don,
                ]);
                $this->askDescription();
        }else{
            $this->bot->startConversation(new StartingPointConversation());
        }
        });
    }
    public function askDescription()
    {
        $this->ask(' 🙏 تنجم تحكيلي باش تنجم تعاون ', function(Answer $answer) {
            // Save result
            $description = $answer->getText();
            $this->bot->userStorage()->save([
                'description' => $description,
            ]);
            $this->askMotorise();
        });
    }
    public function askMotorise()
    {
        $this->say(" 🚗عندك كرهبة ؟");
        $question = Question::create("")
        ->fallback('Unable to ask question')
        ->callbackId('ask_end')
            ->addButtons([
                Button::create('نعم')->value("1"),
                Button::create(' لا ')->value("0"),

            ]);
        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $motorise = $answer->getValue();
                $this->bot->userStorage()->save([
                    'motorise' => $motorise,
                ]);
                $this->askAccordUTSS();
        }else{
            $this->bot->startConversation(new StartingPointConversation());
        }
        });
    }
    public function askAccordUTSS()
    {
        $this->say("هل تقبل انو التبرع متاعك تتكفل بيه الدولة");
        $question = Question::create("")
        ->fallback('Unable to ask question')
        ->callbackId('ask_end')
            ->addButtons([
                Button::create('نعم')->value("1"),
                Button::create(' لا ')->value("0"),

            ]);
        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $accord_utss = $answer->getValue();
                $this->bot->userStorage()->save([
                    'accord_utss' => $accord_utss,
                ]);
                $this->valider();
        }else{
            $this->bot->startConversation(new StartingPointConversation());
        }
        });
    }
    public function valider(){
        $body = new \stdClass();
        $body->nom = $this->bot->userStorage()->get('nom');
        $body->type_action = $this->bot->userStorage()->get('type_action');
        $body->telephone = $this->bot->userStorage()->get('telephone');
        $body->adresse = $this->bot->userStorage()->get('adresse');
        $body->gouvernorat = $this->bot->userStorage()->get('gouvernorat');
        $body->motorise = $this->bot->userStorage()->get('motorise');
        $body->accord_utss = $this->bot->userStorage()->get('accord_utss');
        $body->type_don = $this->bot->userStorage()->get('type_don');
        $body->description = $this->bot->userStorage()->get('description');
        $response = Curl::to('/api/don')
        ->withHeader('Content-Type: application/json')
        ->withData($body)
        ->asJson()
        ->post();   
        if($body->accord_utss == "1"){
            $this->say("شكرا على ثيقتك فينا و على مساهمتك بش نمنعوا بلادنا
            تونس مسؤوليتنا الكل و مع بعضنا والله ما نغلبوه");
            $this->say("هذي المنظمة الي بش تتكفل بالبرع متاعك");
            $this->say($response->telephone.' :الهاتف '.$response->lastname.' '.$response->name);
        }else{
            $this->say('Union Nationale de la Femme Tunisienne: +216 71 378 447 الاتحاد الوطني للمرأة التونسية');
            $this->say('Croissant Rouge: +216 71 378 447 الهلال الاحمر التونسي');
            $this->say('Le Scoutisme: +216 71 378 447 الكشافة التونسية');
        }   

        $question = Question::create("")
        ->fallback('Unable to ask question')
        ->callbackId('ask_end')
            ->addButtons([
                Button::create('رجوع')->value('btn_retour'),
            ]);
        return $this->ask($question, function (Answer $answer) {
                if ($answer->isInteractiveMessageReply()) {
                    if($answer->getValue() == "btn_retour"){
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
        $this->AssociationParticulier();
    }
}
