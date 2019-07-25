<?php 
class ParserTest extends \Codeception\Test\Unit
{

    protected function _before()
    {
        $parser = new Kingga\Workflow\Parser;
        $this->week = $parser->parse(__DIR__ . '/_support/Time-Sheet.csv');
    }

    protected function _after()
    {
    }

    public function testTotalWeekTime()
    {
        $this->assertEquals(41.583, round($this->week->getTotalTime(), 3));
    }

    public function testTotalTuesdayTime()
    {
        $tuesday = $this->week->getDay(2);
        $this->assertEquals(8.25, round($tuesday->getTotalTime(), 2));
    }

    public function testTotalSundayTime()
    {
        $sunday = $this->week->getDay(7);
        $this->assertEquals(null, $sunday);
    }

    public function testTaskOnWednesdayDetails()
    {
        $entries = $this->week->getDay(3)->getEntries();

        $this->assertEquals(
            [
                'J002222',
                'Application',
                'Company Two',
                'Android',
                2.167,
            ],
            [
                $entries[0]->getJobId(),
                $entries[0]->getJob(),
                $entries[0]->getClient(),
                $entries[0]->getTask(),
                round($entries[0]->getTime(), 3),
            ]
        );
    }
}