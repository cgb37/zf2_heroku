<?php
/**
 * Created by PhpStorm.
 * User: charlesbrown-roberts
 * Date: 10/19/15
 * Time: 10:13 PM
 */

namespace Calculator\Model;


class PaydateCalculator
{

    protected $_timezone;
    protected $_fund_day;
    protected $_holidays = array("01-01", "19-01", "16-02", "25-05", "03-07", "07-09", "12-10", "11-11", "26-11", "25-12");

    /**
     * Federal Holidays
     * https://www.opm.gov/policy-data-oversight/snow-dismissal-procedures/federal-holidays/
     *
     * 01-01 Thursday,  January 1	 New Year’s Day
     * 01-19 Monday,    January 19	 Birthday of Martin Luther King, Jr.
     * 02-16 Monday,    February 16* Washington’s Birthday
     * 05-25 Monday,    May 25	     Memorial Day
     * 07-03 Friday,    July 3**	 Independence Day
     * 09-07 Monday,    September 7	 Labor Day
     * 10-12 Monday,    October 12	 Columbus Day
     * 11-11 Wednesday, November 11	 Veterans Day
     * 11-26 Thursday,  November 26	 Thanksgiving Day
     * 12-25 Friday,    December 25	 Christmas Day
     */


    public function __construct()
    {
        $this->setFundDay("2015-10-19");
        $this->setTimezone("America/New_York");
        $this->setHolidays($this->_holidays, null);
    }

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
    public function Calculate_Due_Date($fund_day, $holiday_array, $pay_span, $pay_day, $direct_deposit)
    {
        return 0;
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
        $start = new \DateTime('2015-01-01');
        $interval = new \DateInterval('P1W');
        $end = new \DateTime('2015-12-31');

        $period = new \DatePeriod($start, $interval, $end, \DatePeriod::EXCLUDE_START_DATE);
        return $period;
    }

}