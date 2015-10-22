<?php

namespace Calculator\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    protected $paydate_calculator = null;

    public function indexAction()
    {
        $objPC = $this->getPaydateCalculator();

                $fund_day = "2015-01-01";
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

    public function addAction()
    {
        return new ViewModel();
    }

    public function calculateAction()
    {

        $request = $this->getRequest();
        $response = $this->getResponse();

        if ($request->isGet()) {

            $response->setContent(\Zend\Json\Json::encode(array('response' => true)));
        }
        return $response;

        //return new ViewModel();
    }


}

