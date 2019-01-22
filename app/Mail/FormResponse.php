<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FormResponse extends Mailable {

    use Queueable,
        SerializesModels;

    protected $name;
    protected $surname;
    protected $phone;
    protected $email;
    protected $time;
    protected $date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $properties = []) {

        if (isset($properties['name'])) {

            $this->setName($properties['name']);
        }

        if (isset($properties['surname'])) {

            $this->setSurname($properties['surname']);
        }

        if (isset($properties['phone'])) {

            $this->setPhone($properties['phone']);
        }

        if (isset($properties['email'])) {

            $this->setEmail($properties['email']);
        }

        if (isset($properties['time'])) {

            $this->setTime($properties['time']);
        }


        if (isset($properties['date'])) {

            $this->setDate($properties['date']);
        }
    }

    public function getName() {
        return $this->name;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getTime() {
        return $this->time;
    }

    public function getDate() {
        return $this->date;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setSurname($surname) {
        $this->surname = $surname;
        return $this;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
        return $this;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function setTime($time) {
        $this->time = $time;
        return $this;
    }

    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {

        $subject = "Event Successfully Created";

        return $this->from('jdoe.task@gmail.com', 'John Doe')
                        ->subject($subject)
                        ->view('emails.form-response', [
                            'name' => $this->getName(),
                            'surname' => $this->getSurname(),
                            'phone' => $this->getPhone(),
                            'email' => $this->getEmail(),
                            'time' => $this->getTime(),
                            'date' => $this->getDate(),
        ]);
    }

}
