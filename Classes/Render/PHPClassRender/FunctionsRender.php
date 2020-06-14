<?php
namespace Digitalwerk\PHPClassBuilder\Render\PHPClassRender;

use Digitalwerk\PHPClassBuilder\Object\PHPClass\FunctionObject;
use Digitalwerk\PHPClassBuilder\Object\PHPClassObject;
use Digitalwerk\PHPClassBuilder\Render\AbstractPHPClassRender;

/**
 * Class FunctionsRender
 * @package Digitalwerk\PHPClassBuilder\Render\PHPClassRender
 */
class FunctionsRender extends AbstractPHPClassRender
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
        if ($this->classObject->getFunctions()) {
            foreach ($this->classObject->getFunctions() as $function) {
                $result[] = $this->renderFunction($function);
                $result[] = '';
            }
        }

        return $result;
    }

    /**
     * @param FunctionObject $function
     * @return string
     */
    public function renderFunction(FunctionObject $function): string
    {
        if ($function->getComment()) {
            $result[] = $this->classObject->getTabSpaces() . $function->getComment();
        }
        $result[] = $this->classObject->getTabSpaces() . $function->getType() . ' ' . $function->getName() . $function->getArgumentsAndDescription();
        $result[] = $this->classObject->getTabSpaces() . $function->getContent();

        return implode("\n", $result);
    }
}
