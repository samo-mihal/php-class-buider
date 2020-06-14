<?php
namespace Digitalwerk\PHPClassBuilder\Render;

use Digitalwerk\PHPClassBuilder\Object\PHPClassObject;
use Digitalwerk\PHPClassBuilder\Render\PHPClassRender\ConstantsRender;
use Digitalwerk\PHPClassBuilder\Render\PHPClassRender\FunctionsRender;
use Digitalwerk\PHPClassBuilder\Render\PHPClassRender\HeaderRender;
use Digitalwerk\PHPClassBuilder\Render\PHPClassRender\TraitsRender;
use Digitalwerk\PHPClassBuilder\Render\PHPClassRender\VariablesRender;

/**
 * Class PHPClassRender
 * @package Digitalwerk\PHPClassBuilder\Render
 */
class PHPClassRender extends AbstractPHPClassRender
{
    /**
     * @var HeaderRender
     */
    protected $headerRender = null;

    /**
     * @var TraitsRender
     */
    protected $traitsRender = null;

    /**
     * @var ConstantsRender
     */
    protected $constantsRender = null;

    /**
     * @var VariablesRender
     */
    protected $variablesRender = null;

    /**
     * @var FunctionsRender
     */
    protected $functionsRender = null;

    /**
     * PHPClassRender constructor.
     * @param PHPClassObject $classObject
     */
    public function __construct(PHPClassObject $classObject)
    {
        parent::__construct($classObject);
        $this->headerRender = new HeaderRender($classObject);
        $this->traitsRender = new TraitsRender($classObject);
        $this->constantsRender = new ConstantsRender($classObject);
        $this->variablesRender = new VariablesRender($classObject);
        $this->functionsRender = new FunctionsRender($classObject);
    }

    /**
     * @return void
     */
    public function render(): void
    {
        $template[] = implode("\n",$this->headerRender->render());
        $template[] = '{';
        $traits = implode("\n",$this->traitsRender->render());
        if ($traits) {
            $template[] = rtrim($traits);
            $template[] = '';
        }
        $constants = implode("\n",$this->constantsRender->render());
        if ($constants) {
            $template[] = rtrim($constants);
            $template[] = '';
        }
        $variables = implode("\n",$this->variablesRender->render());
        if ($variables) {
            $template[] = rtrim($variables);
            $template[] = '';
        }
        $functions = implode("\n",$this->functionsRender->render());
        if ($functions) {
            $template[] = rtrim($functions);
        }
        $template[] = '}';
        $template = implode("\n", $template);

        if ($this->classObject->getFilename() && $template) {
            file_put_contents($this->classObject->getFilename(), $template);
        }
    }
}
