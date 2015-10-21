<?php

namespace Calculator\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Calculator\Model\PaydateCalculator;
use Calculator\Form\CalculatorForm;

class IndexController extends AbstractActionController
{


    protected $paydate_calculator;


    public function indexAction()
    {

        $objPC = $this->getPaydateCalculator();

        $fund_day = "2015-1-22";
        $result = $objPC->Calculate_Due_Date($fund_day);

        //var_dump($result);
        $request = $this->getRequest();

        if($request->isXmlHttpRequest()){

            $view = new ViewModel();

            $data = $request->getPost();

            if(isset($data['fund_date_input']) && !empty($data['fund_date_input'])){
                $view->setVariable('result', $data['fund_date_input']);
            }

            $view->setTerminal(true);
            return $view;
        }



        $form = new CalculatorForm();

        return new ViewModel(array(
            'result' => $result,
            'form'   => $form
        ));
    }


    public function processAjaxRequestAction(){

        $result = array('status' => 'error', 'message' => 'There was some error. Try again.');

        $request = $this->getRequest();

        if($request->isXmlHttpRequest()){

            $data = $request->getPost();

            if(isset($data['fund_date_input']) && !empty($data['fund_date_input'])){
                $result['status'] = 'success';
                $result['message'] = 'We got the posted data successfully.';
            }
        }

        return new JsonModel($result);
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

