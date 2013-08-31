<?php namespace Controllers;

use Lio\Contacts\ContactRepository;
use App, Input;

class Contacts extends Base
{
    protected $contacts;

    public function __construct(ContactRepository $contacts)
    {
        $this->contacts = $contacts;
        $this->beforeFilter('csrf', array('on' => 'post'));
    }

    public function getIndex()
    {
        return $this->view('contacts.index');
    }

    public function postIndex()
    {
        $form = App::make('Lio\Contacts\ContactForm');

        if ( ! $form->isValid()) {
            return $this->redirectBack(['errors' => $form->getErrors()]);
        }

        $contact = $this->contacts->getNew(Input::all());

        if ( ! $contact->isValid()) {
            return $this->redirectBack(['errors' => $contact->getErrors()]);
        }

        $this->contacts->store($contact);

        return $this->redirectAction('Controllers\Contacts@getThanks');
    }

    public function getThanks()
    {
        return $this->view('contacts.thanks');
    }
}