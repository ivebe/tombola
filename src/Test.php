<?php

namespace Ivebe\Tombola;

/**
 * Class Test
 *
 * Self test to verify that table satisfy all rules:
 *
 * 1) One table consist of 6 tickets.
 * 2) It must have all numbers from 1 to 90, and they must be used only once
 *   3) 1st column, numbers from 1 to 9
 *   4) 2nd-8th column, numbers from 20-29, 30-39 ... 80-89
 *   5) 9th column numbers from 80 to 90
 * 6) each row has exactly 5 numbers
 * 7) each column must have at least one number
 * 8) each ticket must have 3 rows
 *
 * @package Ivebe\Tombola
 */
class Test
{
    public static function verify($tickets)
    {
        //rule #1
        if(count($tickets) != 6)
            return false;

        $tableNumbers = [];

        for($i=0; $i<9; $i++)
            $tableCols[$i] = [];

        foreach($tickets as $ticket)
        {
            //rule #6, #7 and #8
            if($ticket->rowCount(0) != 5)
                return false;

            if($ticket->rowCount(1) != 5)
                return false;

            if($ticket->rowCount(2) != 5)
                return false;

            $nums = $ticket->getNumbers();
            foreach($nums as $num)
                $tableNumbers = array_merge($tableNumbers, $num);

            for($i=0; $i<9; $i++)
                $tableCols[$i] = array_merge($tableCols[$i], $ticket->getBucket($i));
        }

        //remove 0s
        foreach($tableNumbers as $k => $num)
            if($num == 0)
                unset($tableNumbers[$k]);

        //rule #2
        if(count($tableNumbers) != 90)
            return false;

        //rule #2
        if(!empty(array_diff($tableNumbers, range(1,90))))
            return false;


        //rule #3, #4 and #5
        if(!empty(array_diff($tableCols[0], range(1,9))))
            return false;

        if(!empty(array_diff($tableCols[1], range(10,19))))
            return false;

        if(!empty(array_diff($tableCols[2], range(20,29))))
            return false;

        if(!empty(array_diff($tableCols[3], range(30,39))))
            return false;

        if(!empty(array_diff($tableCols[4], range(40,49))))
            return false;

        if(!empty(array_diff($tableCols[5], range(50,59))))
            return false;

        if(!empty(array_diff($tableCols[6], range(60,69))))
            return false;

        if(!empty(array_diff($tableCols[7], range(70,79))))
            return false;

        if(!empty(array_diff($tableCols[8], range(80,90))))
            return false;


        return true;
    }
}