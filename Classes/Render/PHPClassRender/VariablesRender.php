<?php
namespace Digitalwerk\PHPClassBuilder\Render\PHPClassRender;

use Digitalwerk\PHPClassBuilder\Object\PHPClass\VariableObject;
use Digitalwerk\PHPClassBuilder\Object\PHPClassObject;
use Digitalwerk\PHPClassBuilder\Render\AbstractPHPClassRender;

/**
 * Class VariablesRender
 * @package Digitalwerk\PHPClassBuilder\Render\PHPClassRender
 */
class VariablesRender extends AbstractPHPClassRender
{
    /**
     * VariableRender constructor.
     * @param PHPClassObject $classObject
     */
    public function __construct(PHPClassObject $classObject)
    {
        parent::__construct($classObject);
    }

    /**
     * @return array
     */
    public function render(): array
    {
        $result = [];
        if ($this->classObject->getVariables()) {
            foreach ($this->classObject->getVariables() as $variable) {
                $result[] = $this->renderVariable($variable);
                $result[] = '';
            }
        }

        return $result;
    }

    /**
     * @param VariableObject $variable
     * @return string
     */
    public function renderVariable(VariableObject $variable): string
    {
        if ($variable->getComment()) {
            $result[] = $this->classObject->getTabSpaces() . $variable->getComment();
        }
        $result[] = $this->classObject->getTabSpaces() . $variable->getType() . ' $' . $variable->getName() . ' = ' . $variable->getValue() . ';';

        return implode("\n", $result);
    }
}
