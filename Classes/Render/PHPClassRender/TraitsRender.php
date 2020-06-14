<?php
namespace Digitalwerk\PHPClassBuilder\Render\PHPClassRender;

use Digitalwerk\PHPClassBuilder\Object\PHPClass\TraitObject;
use Digitalwerk\PHPClassBuilder\Object\PHPClassObject;
use Digitalwerk\PHPClassBuilder\Render\AbstractPHPClassRender;

/**
 * Class TraitsRender
 * @package Digitalwerk\PHPClassBuilder\Render\PHPClassRender
 */
class TraitsRender extends AbstractPHPClassRender
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
        if ($this->classObject->getTraits()) {
            foreach ($this->classObject->getTraits() as $trait) {
                $result[] = $this->renderTrait($trait);
            }
        }

        return $result;
    }

    /**
     * @param TraitObject $trait
     * @param bool $addNewLineBeforeComment
     * @return string
     */
    public function renderTrait(TraitObject $trait, $addNewLineBeforeComment = true): string
    {
        if ($trait->getComment()) {
            if ($addNewLineBeforeComment && $this->getCount() > 0) {
                $result[] = '';
            }
            $result[] = $this->classObject->getTabSpaces() . $trait->getComment();
        }
        $result[] = $this->classObject->getTabSpaces() . 'use ' . $trait->getName() . ';';

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
