<?php


namespace Inspector\Analysis\Complexity;


/**
 * @author Kabir Baidhya
 */
interface ComplexityComputerAwareInterface
{

    /**
     * Sets an instance of ComplexityComputer
     *
     * @param ComplexityComputer $complexityComputer
     * @return mixed
     */
    public function setComplexityComputer(ComplexityComputer $complexityComputer);

}
