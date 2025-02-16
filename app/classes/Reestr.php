<?php


class Reestr
{
    public $Наименование, $Производитель, $Рег_номер_товара, $Рег_номер_РУ, $Тип, $N_п_п;

    /**
     * @param $Наименование
     * @param $Производитель
     * @param $Рег_номер_товара
     * @param $Рег_номер_РУ
     * @param $Тип
     * @param $N_п_п
     */
    public function __construct($Наименование, $Производитель, $Рег_номер_товара, $Рег_номер_РУ, $Тип, $N_п_п)
    {
        $this->Наименование = $Наименование;
        $this->Производитель = $Производитель;
        $this->Рег_номер_товара = $Рег_номер_товара;
        $this->Рег_номер_РУ = $Рег_номер_РУ;
        $this->Тип = $Тип;
        $this->N_п_п = $N_п_п;
    }

    public function toJson() {
        return json_encode([
            'Наименование' => $this->Наименование,
            'Производитель' => $this->Производитель,
            'Рег_номер_товара' => $this->Рег_номер_товара,
            'Рег_номер_РУ' => $this->Рег_номер_РУ,
            'Тип' => $this->Тип,
            'N_п_п' => $this->N_п_п,


        ]);
    }
}