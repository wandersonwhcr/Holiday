<?php

namespace Checkdomain\Holiday\Provider;

/**
 * Class FRTest
 */
class FRTest extends AbstractTest
{
    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        $this->provider = new FR();
    }

    /**
     * @param string $date
     * @param string $state
     * @param array  $expectation
     *
     * @dataProvider dateProvider
     */
    public function testHolidays($date, $state = null, array $expectation = null)
    {
        $date    = new \DateTime($date);
        $holiday = $this->provider->getHolidayByDate($date, $state);

        if ($expectation === null) {
            $this->assertNull($holiday);
        } else {
            $this->assertNotNull($holiday, 'No Holiday found but assumed to find one on '.$date->format('Y-m-d'));
            $this->assertEquals($date->format('d.m.Y'), $holiday->getDate()->format('d.m.Y'));

            foreach ($expectation as $property => $expectedValue) {
                $method = 'get'.ucfirst($property);
                $value = $holiday->$method();

                $this->assertEquals($expectedValue, $value);
            }
        }
    }

    /**
     * Provides some test dates and the expectation
     *
     * @return array
     */
    public function dateProvider()
    {
        return array(
            array('2014-03-21', null, null),
            array('2014-01-01', null, array('name' => 'Jour de l\'an')),
            array('2014-04-21', null, array('name' => 'Lundi de Pâques')),
            array('2014-05-01', null, array('name' => 'Fête du Travail')),
            array('2014-05-08', null, array('name' => '8 Mai 1945')),
            array('2014-05-29', null, array('name' => 'Jeudi de l\'Ascension')),
            array('2014-06-09', null, array('name' => 'Lundi de Pentecôte')),
            array('2014-07-14', null, array('name' => 'Fête Nationale')),
            array('2014-08-15', null, array('name' => 'Assomption')),
            array('2014-11-01', null, array('name' => 'La Toussaint')),
            array('2014-11-11', null, array('name' => 'Armistice')),
            array('2014-12-25', null, array('name' => 'Noël')),
        );
    }
} 
