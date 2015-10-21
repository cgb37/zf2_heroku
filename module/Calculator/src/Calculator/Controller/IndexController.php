<?php

namespace Calculator\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Calculator\Model\PaydateCalculator;

class IndexController extends AbstractActionController
{


    protected $paydate_calculator;


    public function indexAction()
    {

        $objPC = $this->getPaydateCalculator();

        $fund_day = "2015-10-05";
        $period = $objPC->Calculate_Due_Date($fund_day);

        var_dump($period);



        /*
        //var_dump($objPC->setPayDays());
        $period = $objPC->setPayDays();

        $events = array();
        foreach ($period as $date) {
            $paydayTimestamp = strtotime( $date->format('d-m-Y'));

            if($objPC->isHoliday($paydayTimestamp)) {

                //echo $date->format('d-m-Y'). " is a holiday<br>";
                $start = $date->format('Y-m-d');
                $title = "Holiday";

            } else {
                $dateString = $date->format("Y-m-d");
                //echo $dateString. " is Not a holiday<br>";

                if($objPC->isWeekend($dateString)) {
                    $title =  "weekend";
                } else {
                    $title = " Not a weekend<br>";
                }

                $start = $dateString;

            }

            $events[] = array(

                'title' => $title,
                'start' => $start

            );



        }

        var_dump(json_encode($events));
        */
        return new ViewModel();
    }

    public function calendarAction()
    {
        return new ViewModel();
    }


    public function getPaydateCalculator()
    {
        if (!$this->paydate_calculator) {

            $this->paydate_calculator = $this->getServiceLocator()->get('PaydateCalculator');
        }
        return $this->paydate_calculator;
    }

}

