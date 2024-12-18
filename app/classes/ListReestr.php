<?php

include 'Reestr.php';

class ListReestr
{
    private $reestrList = array();

    /**
     * @param $reestrList
     */
    public function __construct()
    {
        $connectionDB = new ConnectionDB();
        $query = "SELECT * FROM reestr";
        $result = mysqli_query($connectionDB->con, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $reestr = new Reestr(
                $row['Наименование'],
                $row['Производитель'],
                $row['Рег_номер_товара'],
                $row['Рег_номер_РУ'],
                $row['Тип'],
                $row['N_п_п'],

            );
            array_push($this->reestrList, $reestr);
        };
    }

    public function getReestrList() {
        foreach ($this->reestrList as $reestr) {
            $reestrData[] = json_decode($reestr->toJson(), true);
        }

        return json_encode($reestrData);
    }
}

$reestrList = new ListReestr();