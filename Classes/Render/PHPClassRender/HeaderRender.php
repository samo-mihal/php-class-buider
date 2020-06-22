<?php
namespace Digitalwerk\PHPClassBuilder\Render\PHPClassRender;

use Digitalwerk\PHPClassBuilder\Object\PHPClass\UsedClassObject;
use Digitalwerk\PHPClassBuilder\Object\PHPClassObject;
use Digitalwerk\PHPClassBuilder\Render\AbstractPHPClassRender;

/**
 * Class HeaderRender
 * @package Digitalwerk\PHPClassBuilder\Render\PHPClassRender
 */
class HeaderRender extends AbstractPHPClassRender
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
        $result[] = '<?php';
        if ($this->classObject->isStrictMode()) {
            $result[] = 'declare(strict_types=1);';
        }
        $result[] = 'namespace ' . $this->classObject->getNameSpace() . ';';
        if ($this->classObject->getUsedClasses()) {
            $result[] = '';
            /** @var UsedClassObject $usedClass */
            foreach ($this->classObject->getUsedClasses() as $usedClass) {
                $result[] = 'use ' . $usedClass->getName() . ';';
            }
        }
        $result[] = '';
        if ($this->classObject->getComment()) {
            $result[] = $this->classObject->getComment();
        }
        $result[] = 'class ' . $this->classObject->getName() . ' ' . $this->classObject->getExtendsOrImplements();

        return $result;
    }
}
