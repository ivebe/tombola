<?php

class TableTicketsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * This test is very similar to the Ivebe\Tombola\Test
     * its only purpose is to give more detailed info in where exactly error occurred.
     */
    public function testTableGeneration()
    {
        $table = new \Ivebe\Tombola\Table;
        $table->generate();
        $tickets = $table->getTickets();

        //rule #1
        $this->assertCount(6, $tickets, "Table must have exactly 6 tickets.");

        $tableNumbers = [];

        for($i=0; $i<9; $i++)
            $tableCols[$i] = [];

        foreach($tickets as $ticket)
        {
            //rule #6, #7 and #8
            $this->assertEquals(5, $ticket->rowCount(0), "Rows must have exactly 5 numbers.");
            $this->assertEquals(5, $ticket->rowCount(1), "Rows must have exactly 5 numbers.");
            $this->assertEquals(5, $ticket->rowCount(2), "Rows must have exactly 5 numbers.");

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
        $this->assertCount(90, $tableNumbers, "Ticket must have exactly 90 numbers.");
        $this->assertTrue(empty(array_diff($tableNumbers, range(1,90))), "Table must have all numbers from 1 to 90");

        //rule #3, #4 and #5
        $this->assertTrue(empty(array_diff($tableCols[0], range(1,9))), "1st column must have numbers from 1 to 9");
        $this->assertTrue(empty(array_diff($tableCols[1], range(10,19))), "2nd column must have numbers from 10 to 19");
        $this->assertTrue(empty(array_diff($tableCols[2], range(20,29))), "3rd column must have numbers from 20 to 29");
        $this->assertTrue(empty(array_diff($tableCols[3], range(30,39))), "4th column must have numbers from 30 to 39");
        $this->assertTrue(empty(array_diff($tableCols[4], range(40,49))), "5th column must have numbers from 40 to 49");
        $this->assertTrue(empty(array_diff($tableCols[5], range(50,59))), "6th column must have numbers from 50 to 59");
        $this->assertTrue(empty(array_diff($tableCols[6], range(60,69))), "7th column must have numbers from 60 to 69");
        $this->assertTrue(empty(array_diff($tableCols[7], range(70,79))), "8th column must have numbers from 70 to 79");
        $this->assertTrue(empty(array_diff($tableCols[8], range(80,90))), "9th column must have numbers from 80 to 90");
    }
}
