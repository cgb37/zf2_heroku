<?php
/**
 * Created by PhpStorm.
 * User: charlesbrown-roberts
 * Date: 10/19/15
 * Time: 10:13 PM
 */

/** This function determines the first available due date following the funding of a loan.
 * The paydate will be at least 10 days in the future from the $fund_day. The
 * due_date will fall on a day that is a paydate based on their paydate model * specified by '$pay_span' unless
 * the date must be adjusted forward to miss a
 * weekend or backward to miss a holiday
 * Holiday adjustment takes precedence over Weekend.
 *
 * @param unix_timestamp $fund_day The day the loan was funded.
 * @param array $holiday_array An array of unix timestamp's containing holidays.
 * @param string $pay_span A string representing the frequency at which the customer is paid. (weekly,bi-weekly,monthly)
 * @param unix_timestamp $pay_day A timestamp containing one of the customers paydays
 * @param bool $direct_deposit A boolean determining whether or not the customer receives their paycheck via direct deposit.
 * @return unix_timestamp A unix timestamp representing the determined due date.
 */

namespace Calculator\Model;


class PaydateCalculator
{

    protected $_timezone;
    protected $_fund_day;
    protected $_holidays = array("01-01", "19-01", "16-02", "25-05", "03-07", "07-09", "12-10", "11-11", "26-11", "25-12");
    protected $_pay_span;
    protected $_direct_deposit;
    public    $due_date;

    /**
     * Federal Holidays
     * https://www.opm.gov/policy-data-oversight/snow-dismissal-procedures/federal-holidays/
     *
     * 01-01 New Year’s Day
     * 01-19 Birthday of Martin Luther King, Jr.
     * 02-16 Washington’s Birthday
     * 05-25 Memorial Day
     * 07-03 Independence Day
     * 09-07 Labor Day
     * 10-12 Columbus Day
     * 11-11 Veterans Day
     * 11-26 Thanksgiving Day
     * 12-25 Christmas Day
     */

    //TODO: get year from input value if not current year
    public function __construct()
    {
        $this->setTimezone("America/New_York");
        $this->setHolidays($this->_holidays, null);
    }

    //Calculate_Due_Date($fund_day, $holiday_array, $pay_span, $pay_day, $direct_deposit)
    public function Calculate_Due_Date($fund_day, $pay_span, $direct_deposit)
    {

        if($this->getPaySpan() == "P1W") {
            $first_day = date('Y-m-d', strtotime($fund_day. ' + 7 days'));
        } else {
            $first_day = date('Y-m-d', strtotime($fund_day));
        }

        //is direct deposit?,
        if($this->getDirectDeposit() == false) {
            // not direct deposit - add a day
            $first_day = date('Y-m-d', strtotime($first_day. ' + 1 days'));
        }

        $start       = new \DateTime($first_day, $this->getTimezone());
        $interval    = new \DateInterval($this->getPaySpan());
        $occurrences = 1;
        $period      = new \DatePeriod($start, $interval, $occurrences, \DatePeriod::EXCLUDE_START_DATE);

        foreach($period as $dt){
            $due_date = $dt->format("Y-m-d");

            //is it a weekend?
            if($this->isWeekend($due_date)) {

                //is it saturday or sunday
                if($dt->format("N") == 6) {

                    //saturday - add 2 days
                    $due_date = date('Y-m-d', strtotime($due_date. ' + 2 days'));

                    //is it a holiday?
                    if($this->isHoliday(strtotime($due_date)) == true ) {

                        //if the holiday falls on a monday subtract 3 days to fall on a friday
                        if(date("l", strtotime($due_date)) == 'Monday') {

                            //fall on a friday before monday holiday
                            $due_date = date('Y-m-d', strtotime($due_date. ' - 3 days'));
                            return $due_date;

                        } else {

                            //it is a holiday so subtract a day
                            $due_date = date('Y-m-d', strtotime($due_date. ' - 1 days'));
                            return $due_date;

                        }

                    } else {

                        return $due_date;

                    }

                }
                if($dt->format("N") == 7) {

                    //sunday - add 1 day
                    $due_date = date('Y-m-d', strtotime($due_date. ' + 1 days'));

                    //is it a holiday?
                    if($this->isHoliday(strtotime($due_date)) == true ) {

                        //if the holiday falls on a monday subtract 3 days to fall on a friday
                        if(date("l", strtotime($due_date)) == 'Monday') {

                            //fall on a friday before monday holiday
                            $due_date = date('Y-m-d', strtotime($due_date. ' - 3 days'));
                            return $due_date;

                        } else {

                            //it is a holiday so subtract a day
                            $due_date = date('Y-m-d', strtotime($due_date. ' - 1 days'));
                            return $due_date;

                        }

                    } else {

                        return $due_date;

                    }

                }

            } else {

                //is it a holiday?
                if($this->isHoliday(strtotime($due_date)) == true ) {

                    //if the holiday falls on a monday subtract 3 days to fall on a friday
                    if($dt->format("N") == 1) {

                        //fall on a friday before monday holiday
                        $due_date = date('Y-m-d', strtotime($due_date. ' - 3 days'));
                        return $due_date;

                    } else {

                        //it is a holiday so subtract a day
                        $due_date = date('Y-m-d', strtotime($due_date. ' - 1 days'));

                        //is it a weekend?
                        if($this->isWeekend($due_date)) {

                            //is it saturday or sunday
                            if($dt->format("N") == 6) {

                                //saturday - add 2 days
                                $due_date = date('Y-m-d', strtotime($due_date. ' + 2 days'));
                                return $due_date;

                            }
                            if($dt->format("N") == 7) {

                                //sunday - add 1 day
                                $due_date = date('Y-m-d', strtotime($due_date. ' + 1 days'));
                                return $due_date;

                            }

                        } else {

                            return $due_date;

                        }

                    }

                } else {

                    return $due_date;

                }

            }

        }

    }

    public function getCurrentYear()
    {
        return date("Y");
    }

    /**
     * @return mixed
     */
    public function getFundDay()
    {
        return $this->_fund_day;
    }

    /**
     * @param mixed $fund_day
     */
    public function setFundDay($fund_day)
    {
        $this->_fund_day = strtotime($fund_day);
    }

    /**
     * @return mixed
     */
    public function getTimezone()
    {
        return $this->_timezone;
    }

    /**
     * @param mixed $timezone
     */
    public function setTimezone($timezone)
    {
        $this->_timezone = new \DateTimeZone ( $timezone );
    }

    /**
     * @return mixed
     */
    public function getHolidays()
    {
        return $this->_holidays;
    }

    /**
     * @param mixed $holidays
     */
    public function setHolidays(array $holidays, string $year = null)
    {
        if(is_null($year)) {
            $year = $this->getCurrentYear();
        }

        $days = array();
        foreach($holidays as $h):
            $dateString = $h.'-'.$year;
            $days[] = strtotime($dateString);
        endforeach;

        $this->_holidays = $days;
    }

    public function isHoliday($date)
    {
        $holidays = $this->getHolidays();

        if(in_array($date, $holidays)) {
            return true;
        }

        return false;
    }

    function isWeekend($dateString) {


        $date = date("d-m-Y", strtotime($dateString));
        $inputDate = new \DateTime($date, new \DateTimeZone("America/New_York"));
        return $inputDate->format('N') >= 6;
    }

    public function setPayDays()
    {

        $start = new \DateTime('2015-01-11', $this->getTimezone());
        $interval = new \DateInterval('P2W');
        $end = new \DateTime('2015-12-31', $this->getTimezone());

        $period = new \DatePeriod($start, $interval, $end, \DatePeriod::EXCLUDE_START_DATE);
        return $period;
    }

    /**
     * @return mixed
     */
    public function getPaySpan()
    {
        return $this->_pay_span;
    }

    /**
     * @param mixed $span
     */
    public function setPaySpan($span)
    {
        $span = strtolower($span);
        switch($span) {

            case 'weekly':
                $pay_span = 'P1W';
                break;
            case 'bi-weekly':
                $pay_span = 'P2W';
                break;
            case 'monthly':
                $pay_span = 'P1M';
                break;

        }
        $this->_pay_span = $pay_span;
    }

    /**
     * @return mixed
     */
    public function getDirectDeposit()
    {
        return $this->_direct_deposit;
    }

    /**
     * @param mixed $option
     */

    public function setDirectDeposit($option)
    {
        $option = strtolower($option);
        switch($option) {

            case 'no':
                $direct_deposit = false;
                break;
            case 'yes':
                $direct_deposit = true;
                break;
            default:
                $direct_deposit = true;
        }

        $this->_direct_deposit = $direct_deposit;
    }




}