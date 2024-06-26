<?php
//include '../../connection/connection.php';
require_once 'connection/connection.php';
include 'User.php';

class UsersList
{
    private $usersList;

    /**
     * UsersList constructor.
     * @param $usersList
     */
    public function __construct()
    {
        $this->usersList = array();
    }

    /**
     * @return mixed
     */
    public function getUsersList()
    {
        return $this->usersList;
    }

    /**
     * @param mixed $usersList
     */
    public function setUsersList($usersList): void
    {
        $this->usersList = $usersList;
    }

    public function putUser($user)
    {
        array_push($this->usersList, $user);
    }

    public function getUser($token)
    {
        foreach ($this->usersList as $user) {
            if ($user->getToken() == $token) {
                return $user;
            }
        }
        return null;
    }

    public function getUserById($id)
    {
        foreach ($this->usersList as $user) {
            if ($user->getId() == $id) {
                return $user;
            }
        }
        return null;
    }

    public function updateUserInDB($con,$id,$login)
    {
        $sql = "update users set login='$login' where id_user = '$id'";
        mysqli_query($con, $sql);
    }

    public function setListFromDB($con)
    {
        $sql = "SELECT * FROM users";
        $result = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $user = new User($row['id_user'], $row['login'], $row['username'], $row['email'], $row['id_role'], $row['token']);
            $this->putUser($user);
        }
    }


    public function getListUsers()
    {
        $usersData = [];
        foreach ($this->usersList as $user) {
            $usersData[] = json_decode($user->toJson(), true);
        }

        return json_encode($usersData);
    }
}

$usersList = new UsersList();
$connectionDB = new ConnectionDB();
$usersList->setListFromDB($connectionDB->con);
