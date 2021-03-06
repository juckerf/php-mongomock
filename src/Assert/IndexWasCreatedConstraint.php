<?php
namespace Helmich\MongoMock\Assert;

use Helmich\MongoMock\Log\Index;
use Helmich\MongoMock\MockCollection;

class IndexWasCreatedConstraint extends \PHPUnit_Framework_Constraint
{

    /**
     * @var
     */
    private $key;
    /**
     * @var array
     */
    private $options;

    public function __construct($key, $options = [])
    {
        parent::__construct();
        $this->key = $key;
        $this->options = $options;
    }

    protected function matches($other)
    {
        if (!$other instanceof MockCollection) {
            return false;
        }

        $constraint = \PHPUnit_Framework_Assert::equalTo(new Index($this->key, $this->options));

        foreach ($other->indices as $index) {
            if ($constraint->evaluate($index, '', true)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'has index of ' . json_encode($this->key);
    }
}