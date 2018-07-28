<?php

namespace Application\Model;

class User
{

    protected $id;
    protected $nome;
    protected $email;

    public function exchangeArray(array $data)
    {

        $this->id = $data['id'];
        $this->nome= $data['nome'];
        $this->email= $data['email'];

    }

    public function getArrayCopy()
    {

        return [
            'id'    => $this->id,
            'nome'  => $this->nome,
            'email' => $this->email
        ];

    }


    public function getId()
    {
       return $this->id;
    }

    public function getNome()
    {
       return $this->nome;
    }

    public function getEmail()
    {
       return $this->email;
    }

}
