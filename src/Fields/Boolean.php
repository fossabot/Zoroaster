<?php

    namespace KarimQaderi\Zoroaster\Fields;

    use KarimQaderi\Zoroaster\Fields\Other\Field;
    use KarimQaderi\Zoroaster\Http\Requests\RequestField;

    class Boolean extends Field
    {
        use \KarimQaderi\Zoroaster\Fields\Traits\Validator;

        public $nameViewForm = 'boolean';
        public $textAlign = 'center';

        public $customResourceController = true;




        public function beforeResourceStore(RequestField $requestField)
        {
            $value = $requestField->request->{$requestField->field->name};

            return [
                'error' => $this->getValidatorField($requestField),
                'data' => [$requestField->field->name => ($value === 'on' || $value === 1) ? 1 : 0] ,
            ];

        }


        public function ResourceUpdate(RequestField $requestField)
        {

            $value = $requestField->request->{$requestField->field->name};

            return [
                'error' => $this->getValidatorField($requestField),
                'data' => [$requestField->field->name => ($value === 'on' || $value === 1) ? 1 : 0] ,
            ];
        }

        public function ResourceStore(RequestField $requestField)
        {
            $value = $requestField->request->{$requestField->field->name};

            return [
                'error' => $this->getValidatorField($requestField),
                'data' => [$requestField->field->name => ($value === 'on' || $value === 1) ? 1 : 0] ,
            ];
        }


    }