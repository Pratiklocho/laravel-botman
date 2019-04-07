<?php

namespace App\Conversations;
use Validator;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class OnboardingConversation extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function askName()
    {
        $this->ask('What is your name?', function(Answer $answer) {
            $this->bot->userStorage()->save([
                'name' => $answer->getText(),
            ]);

            $this->say('Nice to meet you '. $answer->getText());
            $this->askEmail();
        });
    }

    public function askEmail()
    {
        $this->ask('What is your email?', function(Answer $answer) {

            $validator = Validator::make(['email' => $answer->getText()], [
                'email' => 'email',
            ]);

            if ($validator->fails()) {
                return $this->repeat('That doesn\'t look like a valid email. Please enter a valid email.');
            }

            $this->bot->userStorage()->save([
                'email' => $answer->getText(),
            ]);

            $this->askMobile();
        });
    }

    public function askMobile()
    {
        $this->ask('Great! Please send your <b>Mobile Number</b> so that we can contact you as soon as possible', function(Answer $answer) {

            $validator = Validator::make(['mobile' => $answer->getText()], [
                'mobile' => 'required|numeric|regex:/^[6-9]\d{9}$/',
            ]);

            if ($validator->fails()) {
                return $this->repeat('It seems like mobile number is not valid. Please send 10 digit mobile number and without pre +91. Thank You!');
            }

            $this->bot->userStorage()->save([
                'mobile' => $answer->getText(),
            ]);

//            $this->say('Great!');
            $this->askPincode();
        });
    }

    public function askPincode()
    {
        $this->ask('Great! Please Send Your <b>Pincode</b>?', function(Answer $answer) {

            $validator = Validator::make(['pincode' => $answer->getText()], [
                'pincode' => 'required|numeric|regex:/\d{6}$/',
            ]);

            if ($validator->fails()) {
                return $this->repeat('It seems like pincode is not valid please send 6 digit pincode. Thank You!');
            }

            $this->bot->userStorage()->save([
                'pincode' => $answer->getText(),
            ]);

//            $this->say('Great!');
            $this->askAddress();
        });
    }

    public function askAddress()
    {
        $this->ask('Great! Please send your <a>address</b>. So we could send you, your order.?', function(Answer $answer) {

            $validator = Validator::make(['address' => $answer->getText()], [
                'address' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->repeat('please enter your address');
            }

            $this->bot->userStorage()->save([
                'address' => $answer->getText(),
            ]);

//            $this->say('Great!');
            $this->askConfirm();
        });
    }

    public function askConfirm()
    {

        $question = Question::create('Great! Do you want to confirm an order for the below product?')
            ->callbackId('select_service')
            ->addButtons([
                Button::create('Yes')->value('Yes'),
                Button::create('No')->value('No'),
            ]);

        $this->ask($question, function(Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if($answer->getValue() =='Yes'){
                    $this->confirmBooking();
                } else {
                    $this->say('Okay! Nice to meet you nathi name. Thank you...!:)');
                }
            }
        });

        $this->say('<img src="https://image.evastram.com/large/evastram-1539870506-1354.jpg" width="100%">');
    }



//Great! Please Send Your Pincode?
//
//It seems like pincode is not valid please send 6 digit pincode. Thank You!
//
//Great! Please send your address. So we could send you, your order.
//
//Great! Do you want to confirm an order for the below product?
//
//Okay! Nice to meet you nathi name. Thank you...!:)

    public function confirmBooking()
    {
        $user = $this->bot->userStorage()->find();

        $message = '-------------------------------------- <br>';
        $message .= 'Name : ' . $user->get('name') . '<br>';
        $message .= 'Email : ' . $user->get('email') . '<br>';
        $message .= 'Mobile : ' . $user->get('mobile') . '<br>';
        $message .= 'Pincode : ' . $user->get('pincode') . '<br>';
        $message .= 'Address : ' . $user->get('address') . '<br>';
        $message .= '---------------------------------------';

        $this->say('Great. Your booking has been confirmed. Here is your booking details. <br><br>' . $message);
    }

    public function run()
    {
        $this->askName();
    }
}
