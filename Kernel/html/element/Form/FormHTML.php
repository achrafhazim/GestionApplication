<?php

namespace Kernel\html\element\Form;

use Kernel\html\element\Form\input\Input;
use Kernel\html\element\Form\input\MultiSelect;
use Kernel\html\element\Form\input\Schema_Input_HTML;
use Kernel\html\element\Form\input\Select;
use Kernel\html\element\Form\input\Textarea;
use function implode;

class FormHTML extends FormAbstract
{

    public function builder_form(): string
    {
        $form_grop = [];

        foreach ($this->inputs as $input) {
            $form_grop[] = $this->InputTage($input);
        }
        return implode(" ", $form_grop);
    }
/**
 *
 * @param Schema_Input_HTML $input
 * @return string
 */
    private function InputTage(Schema_Input_HTML $input):string
    {

        switch ($input->getType()) {
            case "textarea":
                $inputHTML = $this->style_form_horizonta(new Textarea($input));
                break;
            case "select":
                $inputHTML = $this->style_form_horizonta(new Select($input));
                break;
            case "mult_select":
                $inputHTML = $this->style_Modals(new MultiSelect($input));
                break;

            default:
                $inputHTML = $this->style_form_horizonta(new Input($input));
                break;
        }
        return $inputHTML;
    }
}
