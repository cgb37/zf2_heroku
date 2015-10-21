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

        $fund_day = "2015-10-12";
        $period = $objPC->Calculate_Due_Date($fund_day);

        var_dump($period);


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

