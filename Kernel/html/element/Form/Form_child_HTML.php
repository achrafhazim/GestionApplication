<?php

namespace Kernel\html\element\Form;

use Kernel\html\element\Form\input\Abstract_Input;
use Kernel\html\element\Form\input\Input;
use Kernel\html\element\Form\input\MultiSelect;
use Kernel\html\element\Form\input\Schema_Input_HTML;
use Kernel\html\element\Form\input\Select;
use Kernel\html\element\Form\input\Textarea;
use function implode;

class Form_child_HTML extends FormAbstract
{

    public function builder_form(): string
    {
        $label = [];
        $input = [];
        foreach ($this->inputs as $input) {
            $inputGenerete = $this->GenereteType($input);

            $inputHTML[] = $inputGenerete->builder_Tag();
            $label[] = $inputGenerete->getLable();
        }
        $Thead = $this->parseThead($label);
        $Tbody = $this->parseTbody($inputHTML);
        return implode(" ", $Thead) . implode(" ", $Tbody);
    }

    /**
     *
     * @param type $labels
     * @return array
     */
    private function parseThead($labels): array
    {

        $Thead = [];


        $Thead[] = ' <thead>  <tr >';
        foreach ($labels as $label) {
            $Thead[] = '   <th class="text-center"> ' . $label . '</th>';
        }
        $Thead[] = '    <th class="text-center" style="border-top: 1px solid #ffffff; border-right: 1px solid #ffffff;"> ';
        $Thead[] = '  </th>     </thead>';

        return $Thead;
    }

    /**
     *
     * @param type $inputsHTML
     * @return array
     */
    private function parseTbody($inputsHTML): array
    {

        $Tbody = [];
        $Tbody[] = ' <tbody id="content-child"> <tr   class="inputs-child">';
        foreach ($inputsHTML as $inputHTML) {
            $Tbody[] = '   <td > ' . $inputHTML . ' </td>';
        }
        $Tbody[] = '     <td > <button class="delete btn btn-xs glyphicon glyphicon-trash row-remove" style="font-size: 16px ;    background-color: #f1a1c2;"> </button>
                                    </td> </tr> </tbody>';
        return $Tbody;
    }

    /**
     *
     * @param Schema_Input_HTML $input
     * @return Abstract_Input
     */
    private function GenereteType(Schema_Input_HTML $input): Abstract_Input
    {

        switch ($input->getType()) {
            case "textarea":
                $inputHTML = new Textarea($input);
                break;

            case "select":
                $inputHTML = new Select($input);

                break;
            case "mult_select":
                $inputHTML = new MultiSelect($input);

                break;

            default:
                $inputHTML = new Input($input);
                break;
        }

        return $inputHTML->setChild();
    }
}
