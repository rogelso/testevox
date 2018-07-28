<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGatewayInterface;

class UserTable
{

    protected $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;

    }


    public function fetchAll()
    {
        $datas = $this->tableGateway->select();


        return $datas;
    }

    public function getUser(int $id)
    {

        $current = $this->tableGateway->select([
            'id' => $id
        ]);

        return $current->current();

    }

    public function deleteUser(int $id)
    {

        $this->tableGateway->delete([
            'id' => $id
        ]);

    }

    public function saveUser(User $user)
    {
        $data = [
          'nome' => $user->getNome(),
          'email' => $user->getEmail()
        ];

        //For update user
        if ($user->getId()) {

            $this->tableGateway->update($data, [
              'id' => $user->getId()
            ]);

        //For insert new user
        } else {
            $this->tableGateway->insert($data);
        }


    }

}
