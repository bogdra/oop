<?php


namespace \App\Entities;


class Commision
{

    private $from;
    private $to;
    private $commission;

    public function __construct(float $fromValue, float $toValue, float $commissionValue)
    {
        if ($fromValue > $toValue) {
            throw new \Exception('The toValue must be grater or equal with the fromValue');
        }

        foreach ([$fromValue, $toValue, $commissionValue] as $value)
        {
            if ($value < 0) {
                throw new \Exception('value must be greater or equal to 0');
            }
        }

        $this->from = $fromValue;
        $this->to = $toValue;
        $this->commission = $commissionValue;
    }
    
    public function getFrom()
    {
        return $this->from;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function getCommission()
    {
        return $this->commission;
    }
}