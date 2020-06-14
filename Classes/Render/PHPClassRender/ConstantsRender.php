<?php
namespace Digitalwerk\PHPClassBuilder\Render\PHPClassRender;

use Digitalwerk\PHPClassBuilder\Object\PHPClass\ConstantObject;
use Digitalwerk\PHPClassBuilder\Object\PHPClassObject;
use Digitalwerk\PHPClassBuilder\Render\AbstractPHPClassRender;

/**
 * Class ConstantsRender
 * @package Digitalwerk\PHPClassBuilder\Render\PHPClassRender
 */
class ConstantsRender extends AbstractPHPClassRender
{
    /**
     * @var int
     */
    protected $count = 0;

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
        if ($this->classObject->getConstants()) {
            foreach ($this->classObject->getConstants() as $constant) {
                $result[] = $this->renderConstant($constant);
            }
        }

        return $result;
    }

    /**
     * @param ConstantObject $constant
     * @param bool $addNewLineBeforeComment
     * @return string
     */
    public function renderConstant(ConstantObject $constant, $addNewLineBeforeComment = true): string
    {
        if ($constant->getComment()) {
            if ($addNewLineBeforeComment && $this->getCount() > 0) {
                $result[] = '';
            }
            $result[] = $this->classObject->getTabSpaces() . $constant->getComment();
        }
        $result[] = $this->classObject->getTabSpaces() . 'const ' . $constant->getName() . ' = ' . $constant->getValue() . ';';

        $this->setCount($this->getCount() + 1);
        return implode("\n", $result);
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }
}
