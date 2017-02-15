<?php

namespace Ivebe\Tombola;

/**
 * Class Table
 *
 * - One table consist of 6 tickets.
 * - It must have all numbers from 1 to 90, and they must be used only once
 *   + 1st column, numbers from 1 to 9
 *   + 2nd-8th column, numbers from 20-29, 30-39 ... 80-89
 *   + 9th column numbers from 80 to 90
 * - each row has exactly 5 numbers
 * - each column must have at least one number
 *
 * @package Ivebe\Tombola
 */
class Table
{
    private $tickets;

    public function __construct()
    {
        //Why initialization in constructor? Because I decided to follow YAGNI.
        for($i=0; $i<6; $i++)
            $this->tickets[$i] = new Ticket;
    }

    private function generateBuckets()
    {
        $bucket[0] = range(1,9);   shuffle($bucket[0]);
        $bucket[1] = range(10,19); shuffle($bucket[1]);
        $bucket[2] = range(20,29); shuffle($bucket[2]);
        $bucket[3] = range(30,39); shuffle($bucket[3]);
        $bucket[4] = range(40,49); shuffle($bucket[4]);
        $bucket[5] = range(50,59); shuffle($bucket[5]);
        $bucket[6] = range(60,69); shuffle($bucket[6]);
        $bucket[7] = range(70,79); shuffle($bucket[7]);
        $bucket[8] = range(80,90); shuffle($bucket[8]);

        return $bucket;
    }

    private function distribute($buckets)
    {
        //1st iteration
        foreach($this->tickets as $ticket)
            for($k=0; $k<9; $k++)
                $ticket->addToBucket($k, array_pop($buckets[$k]));

        //add element from last bucket to random ticket
        $this->tickets[rand(0,5)]->addToBucket(8, array_pop($buckets[8]));

        //3 passes for max 2 numbers per column
        for($i=0; $i<3; $i++)
        {
            for($k=0; $k<9; $k++)
            {
                //if bucket empty skip
                if(count($buckets[$k]) == 0) continue;

                $valid = false;

                while(!$valid)
                {
                    $randTicket = $this->tickets[rand(0,5)];

                    if( $randTicket->bucketCount() == 15 || count($randTicket->getBucket($k)) == 2)
                        continue;

                    $valid = true;
                    $randTicket->addToBucket($k, array_pop($buckets[$k]));
                }
            }
        }

        //last pass
        for($k=0; $k<9; $k++)
        {
            //if bucket empty skip
            if(count($buckets[$k]) == 0) continue;

            $valid = false;

            while(!$valid)
            {
                $randTicket = $this->tickets[rand(0,5)];

                if( $randTicket->bucketCount() == 15 || count($randTicket->getBucket($k)) == 3)
                    continue;

                $valid = true;
                $randTicket->addToBucket($k, array_pop($buckets[$k]));
            }
        }

        //sort buckets in tickets
        foreach($this->tickets as $ticket) {
            $ticket->sortBuckets();
            $ticket->distribute();
            $ticket->fillBlanks();
        }
    }

    public function generate()
    {
        $buckets = $this->generateBuckets();
        $this->distribute($buckets);
    }

    public function getTickets()
    {
        return $this->tickets;
    }

    public function prettyPrint()
    {
        foreach($this->tickets as $ticket)
            $ticket->prettyPrint();
    }
}
