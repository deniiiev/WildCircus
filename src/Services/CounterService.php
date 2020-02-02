<?php


namespace App\Services;


use App\Repository\TicketsRepository;

class CounterService
{
    private $ticketsRepository;

    public function __construct(TicketsRepository $ticketsRepository)
    {
        $this->ticketsRepository = $ticketsRepository;
    }

    public function total($options = [])
    {
        $tickets = $this->ticketsRepository->findBy($options);
        $total = 0;
        foreach ($tickets as $value) {
            if ($value->getDays() == true) {
                $total += $value->getCount() * $value->getPrice()->getWeekend();
            } else {
                $total += $value->getCount() * $value->getPrice()->getWeek();
            }
        }
        return $total;
    }

    public function status($options = [])
    {
        return $this->ticketsRepository->findBy($options);
    }
}
