<?php
namespace Application\Form;

use Zend\Form\Form;

class UserForm extends Form
{

    public function __construct($name = null)
    {
        parent::__construct('user');

        $this->setAttribute('method', 'POST');

        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);

        $this->add([
            'name' => 'nome',
            'type' => 'text',
            'options' => [
                'label' => 'Nome '
            ]
        ]);

        $this->add([
            'name' => 'email',
            'type' => 'text',
            'options' => [
                'label' => 'Email '
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
               'value' => 'Cadastrar ',
               'id'    => 'buttonSave'
            ]
        ]);

    }

}
