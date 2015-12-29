<?php

/**
 * The model class executes common arithmetics
 * and returns presumed constants that are required by but are not
 * necessarily to be attached on other models
 */
class Defaults extends CActiveRecord {

    /**
     * Count the number of days between two dates.
     * $since must be less than $till
     * 
     * @param type $since
     * @param type $till
     * @return int
     */
    public static function countdays($since, $till) {
        $days = 0;

        $from = self::dateExplode($since);
        $to = self::dateExplode($till);

        (int) $toka = $from['yr'] . $from['mth'] . $from['dt'];
        (int) $hadi = $to['yr'] . $to['mth'] . $to['dt'];

        while ($toka < $hadi) {
            $from['dt'] ++;

            $from = self::normalizeDate($from);

            (int) $toka = $from['yr'] . $from['mth'] . $from['dt'];
            $days++;
        }

        return $days;
    }

    /**
     * Normalize a date if need be.
     * 
     * @param array $date Date in format array('yr' => yyyy, 'mth' => mm, 'dt' => dd)
     * @return array $date Date in format array('yr' => yyyy, 'mth' => mm, 'dt' => dd)
     */
    public static function normalizeDate($date) {
        if ($date['dt'] > self::maxdate($date['mth'], $date['yr'])) {
            $date['dt'] = $date['dt'] - self::maxdate($date['mth'], $date['yr']);
            $date['mth'] ++;
            if ($date['mth'] > 12) {
                $date['mth'] = $date['mth'] - 12;
                $date['yr'] ++;
            }
        }

        if ($date['dt'] < 1) {
            $date['mth'] --;
            if ($date['mth'] < 1) {
                $date['mth'] = $date['mth'] + 12;
                $date['yr'] --;
            }
            $date['dt'] = $date['dt'] + self::maxdate($date['mth'], $date['yr']);
        }

        $date['mth'] = self::twoDigits($date['mth']);

        $date['dt'] = self::twoDigits($date['dt']);

        return $date;
    }

    /**
     * Return the number of days of a month
     * 
     * @param type $mth
     * @param type $yr
     * @return int
     */
    public static function maxdate($mth, $yr) {

        if ($mth == 4 || $mth == 6 || $mth == 9 || $mth == 11)
            return 30;

        if ($mth == 2) {
            if ($yr % 4 == 0)
                return 29;

            return 28;
        }

        return 31;
    }

    /**
     * Explode the date string into an array
     * 
     * @param type $date
     * @return type
     */
    public static function dateExplode($date) {
        return array(
            'yr' => substr($date, 0, 4),
            'mth' => substr($date, 5, 2),
            'dt' => substr($date, 8, 2)
        );
    }

    public static function dateImplode($date) {
        return $date['yr'] . '-' . self::twoDigits($date['mth']) . '-' . self::twoDigits($date['dt']);
    }

    public static function countYears($since, $till) {
        $from = self::dateExplode($since);
        $to = self::dateExplode($till);

        $up_since = $to['yr'] . $from['mth'] . $from['dt'];
        $up_till = $to['yr'] . $to['mth'] . $to['dt'];

        $years = $to['yr'] - $from['yr'];

        if ($up_since >= $up_till)
            $years--;

        return empty($years) ? '0' : $years;
    }

    public static function countMonths($startDate, $endDate) {
        if ($startDate > $endDate) {
            $otherDate = $endDate;
            $endDate = $startDate;
            $startDate = $otherDate;
        }

        $startDate = self::dateExplode($startDate);
        $endDate = self::dateExplode($endDate);

        if ($endDate['dt'] > $startDate['dt'])
            $endDate['mth'] ++;

        if ($endDate['mth'] > 12) {
            $endDate['yr'] ++;
            $endDate['mth'] = '01';
        }

        $endDate['dt'] = $startDate['dt'];

        if ($endDate['dt'] > ($maxDate = self::maxdate($endDate['mth'], $endDate['yr'])))
            $endDate['dt'] = $maxDate;

        $startDate = self::dateImplode($startDate);
        $endDate = self::dateImplode($endDate);

        $months = 0;
        if ($startDate == $endDate)
            $months++;

        while ($startDate < $endDate) {
            $months++;
            $startDate = self::dateExplode($startDate);
            $startDate['mth'] ++;

            if ($startDate['mth'] > 12) {
                $startDate['yr'] ++;
                $startDate['mth'] = '01';
            }

            $startDate = self::dateImplode($startDate);
        }

        return $months;
    }

    /**
     * 
     * @return date date today
     */
    public static function today() {
        return date('Y') . '-' . date('m') . '-' . date('d');
    }

    /**
     * 
     * @return date date today
     */
    public static function firstOfThisYear() {
        return date('Y') . '-01-01';
    }

    /**
     * Return number of days in a year
     * 
     * @param date $startDate
     * @return int
     */
    public static function daysInAYear($startDate) {
        $date = self::dateExplode($startDate);
        return (($date['yr'] % 4 == 0 && $date['mth'] < 3) || ($date['yr'] % 4 == 3 && $date['mth'] > 2)) ? 366 : 365;
    }

    /**
     * Return a string with two character length
     * 
     * @param type $value
     * @return type
     */
    public static function twoDigits($value) {
        if (strlen($value) >= 2)
            return $value;

        return "0$value";
    }

    /**
     * 
     * @param int $month 1 - 12
     * @return string name of month
     */
    public static function monthName($month) {
        switch ($month) {
            case 1: return 'January';
                break;
            case 2: return 'February';
                break;
            case 3: return 'March';
                break;
            case 4: return 'April';
                break;
            case 5: return 'May';
                break;
            case 6: return 'June';
                break;
            case 7: return 'July';
                break;
            case 8: return 'August';
                break;
            case 9: return 'September';
                break;
            case 10: return 'October';
                break;
            case 11: return 'November';
                break;
            case 12: return 'December';
                break;

            default:
                break;
        }
    }

    /**
     * 
     * @param int $day 0 - 6
     * @return string name of day
     */
    public static function dayName($day) {
        switch ($day) {
            case 0: return 'Sunday';
                break;
            case 1: return 'Monday';
                break;
            case 2: return 'Tuesday';
                break;
            case 3: return 'Wednesday';
                break;
            case 4: return 'Thursday';
                break;
            case 5: return 'Friday';
                break;
            case 6: return 'Saturday';
                break;

            default:
                break;
        }
    }

    /**
     * 0 is zero
     */
    const ZERO = 'zero';

    /**
     * 
     * @param int $no 1 - 19
     * @return string name of number
     */
    public static function oneToNineteen($no) {
        $no = abs($no);

        switch ($no) {
            case 1: return 'one';
                break;
            case 2: return 'two';
                break;
            case 3: return 'three';
                break;
            case 4: return 'four';
                break;
            case 5: return 'five';
                break;
            case 6: return 'six';
                break;
            case 7: return 'seven';
                break;
            case 8: return 'eight';
                break;
            case 9: return 'nine';
                break;
            case 10: return 'ten';
                break;
            case 11: return 'eleven';
                break;
            case 12: return 'twelve';
                break;
            case 13: return 'thirteen';
                break;
            case 14: return 'fourteen';
                break;
            case 15: return 'fifteen';
                break;
            case 16: return 'sixteen';
                break;
            case 17: return 'seventeen';
                break;
            case 18: return 'eighteen';
                break;
            case 19: return 'nineteen';
                break;
            default:
                break;
        }
    }

    /**
     * 
     * @param int $no 20 - 99
     * @return string
     */
    public static function tens($no) {
        $no = abs($no);

        if ($no >= 20) {
            if ($no < 30)
                return 'twenty';
            if ($no < 40)
                return 'thirty';
            if ($no < 50)
                return 'forty';
            if ($no < 60)
                return 'fifty';
            if ($no < 70)
                return 'sixty';
            if ($no < 80)
                return 'seventy';
            if ($no < 90)
                return 'eighty';
            if ($no < 100)
                return 'ninety';
        }
    }

    /**
     * 
     * @param int $no 1 - 19
     * @return string name of number
     */
    public static function lessThan20($no) {
        return self::oneToNineteen($no);
    }

    /**
     * 
     * @param int $no 20 - 99
     * @return string name of number
     */
    public static function lessThan100($no) {
        if ($no < 20)
            return self::lessThan20($no);

        $tens = self::tens($no);
        $ones = self::lessThan20($no % 10);

        return "$tens $ones";
    }

    /**
     * 
     * @param int $no 100 - 999
     * @return string name of number
     */
    public static function hundreds($no) {
        $hundreds = self::lessThan20(floor($no / 100));
        $tensAndOnes = self::lessThan100($ones = $no % 100);
        $and = $ones > 0 ? ' and' : null;

        $hundreds = empty($hundreds) ? null : "$hundreds hundred$and ";

        return "$hundreds$tensAndOnes";
    }

    /**
     * 
     * @param int $no 1 - 999
     * @return string name of number
     */
    public static function lessThan1000($no) {
        if ($no >= 100)
            return self::hundreds($no);

        if ($no >= 20)
            return self::lessThan100($no);

        return self::lessThan20($no);
    }

    /**
     * 
     * @param int $no 1,000 - 999,999
     * @return string name of number
     */
    public static function thousands($no) {
        $thousands = self::lessThan1000(floor($no / 1000));
        $hundredsTensAndOnes = self::lessThan1000($ones = $no % 1000);
        $and = $ones < 100 && $ones > 0 ? ' and' : (empty($hundredsTensAndOnes) ? ' ' : ',');

        $thousands = empty($thousands) ? null : "$thousands thousand$and ";

        return "$thousands$hundredsTensAndOnes";
    }

    /**
     * 
     * @param int $no 1,000,000 - 999,999,999
     * @return string name of number
     */
    public static function millions($no) {
        $millions = self::lessThan1000(floor($no / 1000000));
        $thousandsHundredsTensAndOnes = self::thousands($ones = $no % 1000000);
        $and = $ones < 100 && $ones > 0 ? ' and' : (empty($thousandsHundredsTensAndOnes) ? ' ' : ',');

        $millions = empty($millions) ? null : "$millions million$and ";

        return "$millions$thousandsHundredsTensAndOnes";
    }

    /**
     * 
     * @param int $no 1,000,000,000 - 999,999,999,999
     * @return string name of number
     */
    public static function billions($no) {
        $billions = self::lessThan1000(self::firstThreeDigits($no));
        $millionsThousandsHundredsTensAndOnes = self::millions($ones = self::otherDigits($no));
        $and = $ones < 100 && $ones > 0 ? ' and' : (empty($millionsThousandsHundredsTensAndOnes) ? ' ' : ',');

        $billions = empty($billions) ? null : "$billions billion$and ";

        return "$billions$millionsThousandsHundredsTensAndOnes";
    }

    /**
     * 
     * @param int $no 1,000,000,000,000 - 99,999,999,999,999
     * @return string name of number
     */
    public static function trillions($no) {
        $trillions = self::lessThan1000(self::firstThreeDigits($no));
        $billionsMillionsThousandsHundredsTensAndOnes = self::billions($ones = self::otherDigits($no));
        $and = $ones < 100 && $ones > 0 ? ' and' : (empty($billionsMillionsThousandsHundredsTensAndOnes) ? ' ' : ',');

        $trillions = empty($trillions) ? null : "$trillions trillion$and ";

        return "$trillions$billionsMillionsThousandsHundredsTensAndOnes";
    }

    /**
     * these numbers bring misnoma
     */
    const BILLION_LENGTH = 10;
    const TRILLION_LENGTH = 13;

    /**
     * 
     * @param int $no billions and trillions only
     * @return int digits in billion or trillion place values
     */
    public static function firstThreeDigits($no) {
        return substr($no, 0, strlen($no) - self::minIndex($no));
    }

    /**
     * 
     * @param int $no billions and trillions only
     * @return int digits in the other place values
     */
    public static function otherDigits($no) {
        return substr($no, strlen($no) - $minIndex = self::minIndex($no), $minIndex);
    }

    /**
     * 
     * @param int $no billions and trillions
     * @return int no. of digits in billion or trillion place values
     */
    public static function minIndex($no) {
        return (strlen($no) >= self::TRILLION_LENGTH ? self::TRILLION_LENGTH : self::BILLION_LENGTH) - 1;
    }

    /**
     * return name of number of absolute value zero upto less than billions
     * 
     * @param int $money 0 - 99,999,999,999,999
     * @return string name of number
     */
    public static function moneyValue($money) {
        $whole = floor(abs($money));
        $cents = self::cents(abs($money) - $whole);

        if ($whole >= 1000000000000)
            $shillings = self::trillions($whole);
        else
        if ($whole >= 1000000000)
            $shillings = self::billions($whole);
        else
        if ($whole >= 1000000)
            $shillings = self::millions($whole);
        else
        if ($whole >= 1000)
            $shillings = self::thousands($whole);
        else
        if ($whole > 0)
            $shillings = self::lessThan1000($whole);
        else
            $shillings = self::ZERO;

        return $money < 0 ? "($shillings shillings $cents)" : "$shillings shillings $cents";
    }

    /**
     * 
     * @param double $cents
     * @return string name of cents
     */
    public static function cents($cents) {
        $cents = floor(round(100 * $cents, 3));

        if (!empty($cents)) {
            $cents = 'and ' . self::lessThan1000($cents) . ' cents';
            return $cents;
        }
    }

    public static function decimals($number, $decimals) {
        $number = round($number, $decimals);
        if ($decimals > 0) {
            if ($number <= -10) {
                $length = $decimals + 4;
                if (strlen(round($number, $decimals)) == 3)
                    $number = round($number, $decimals) . '.'; //e.g. -11.000 becomes '-11', then '-11.'
            } else
            if ($number < 0) {
                $length = $decimals + 3;
                if (strlen(round($number, $decimals)) == 2)
                    $number = round($number, $decimals) . '.'; //e.g. -3.000 becomes '-3', then '-3.'
            } else
            if ($number < 10) {
                $length = $decimals + 2;
                if (strlen(round($number, $decimals)) == 1)
                    $number = round($number, $decimals) . '.'; //e.g. 3.000 becomes '3', then '3.'
            } else {
                $length = $decimals + 3;
                if (strlen(round($number, $decimals)) == 2)
                    $number = round($number, $decimals) . '.'; //e.g. 10.000 becomes '10', then '10.'
            }

            for ($i = strlen($number); $i < $length; $i++) {
                $number = $number . '0';
            }
        } else
            $number = round($number, $decimals);
        return $number;
    }

}
