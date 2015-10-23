<?php

namespace Calculator\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Calculator\Model\PaydateCalculator;
use Calculator\Form\CalculatorForm;

class IndexController extends AbstractActionController
{

    protected $paydate_calculator = null;

    public function indexAction()
    {

        $form = new CalculatorForm();

        return new ViewModel(array(

            'form'   => $form
        ));

    }

    public function calculateAction()
    {

        $request = $this->getRequest();
        $response = $this->getResponse();

        $objPC = $this->getPaydateCalculator();

        $fund_day = $request->getQuery()->fund_date_input;

        $pay_span_input = $request->getQuery()->pay_span;
        $pay_span = $objPC->setPaySpan($pay_span_input); // weekly, bi-weekly, monthly

        $direct_deposit_input = $request->getQuery()->direct_deposit;
        $direct_deposit = $objPC->setDirectDeposit($direct_deposit_input);

        $due_date = $objPC->Calculate_Due_Date($fund_day, $pay_span, $direct_deposit);
        $due_date_timestamp = strtotime($due_date);


        if ($request->isGet()) {

            $response->setContent(\Zend\Json\Json::encode(array(
                'response' => true,
                'due_date' => $due_date,
                'due_date_timestamp' => $due_date_timestamp
            )));
        }
        return $response;
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




}

