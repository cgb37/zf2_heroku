<?php
/**
 * Created by PhpStorm.
 * User: cbrownroberts
 * Date: 10/21/15
 * Time: 2:12 PM
 */

namespace Calculator\Form;
use Zend\Form\Form;
use Zend\Form\Element;


class CalculatorForm extends Form
{

    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('calculator');

        $this->setAttribute('method', 'get');
        $this->setAttribute('action', '/calculator');
        $this->setAttribute('class', 'form-inline');

        $this->add(array(
            'name' => 'fund_date_input',
            'type' => 'date',
            'options' => array(
                'label' => 'Fund Date',
                'id' => 'fund_date_input'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'fund_date_input',
                'value' => '2015-10-13',
            ),
        ));
        $this->add(array(
            'name' => 'pay_span',
            'type' => 'select',
            'options' => array(
                'label' => 'Pay Span',
                'id' => 'pay_span_input',
                'value_options' => array(
                    'weekly'    => 'Weekly',
                    'bi-weekly' => 'Bi-weekly',
                    'monthly'   => 'Monthly'
                ),
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'pay_span_input'
            ),
        ));
        $this->add(array(
            'name' => 'direct_deposit',
            'type' => 'select',
            'options' => array(
                'label' => 'Direct Deposit',
                'id' => 'direct_deposit_input',
                'value_options' => array(
                    'yes'    => 'Yes',
                    'no' => 'No'
                ),
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'direct_deposit_input'
            ),
        ));

        $this->add(array(
            'name' => 'due_date_submit',
            'type' => 'Submit',
            'options' => array(
                'id' => 'first_due_date_submit'
            ),
            'attributes' => array(
                'value' => 'Calculate Pay Date',
                'id' => 'first_due_date_submit',
                'class' => 'form-control btn-primary',
            ),
        ));
    }
}