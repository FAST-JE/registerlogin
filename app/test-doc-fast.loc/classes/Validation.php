<?php

namespace App\Classes;
use \ReflectionClass;

class Validation
{
    public $errors = [];
    /*
     * @param string $email
     *
     * @return bool
     */
    public function validateEmail($field_value, $field_name)
    {
        if (!filter_var($field_value, FILTER_VALIDATE_EMAIL))
            $this->errors = array_merge($this->errors, [$field_name => "email is not valid"]);

        return true;
    }

    /*
     *
     */
    protected function getFuncArgNames($func_name) {
        $f = new ReflectionClass($this);
        $f = $f->getMethod($func_name);
        $result = array();
        foreach ($f->getParameters() as $param) {
            $result[] = $param->name;
        }
        return $result;
    }

    /*
     * @param array $data, $params
     *
     * @return string
     */

    public function validateData($data, $params)
    {

        $methods = [
            'min' =>        ['name' => 'minLength',     'params' => array_fill_keys(array_values($this->getFuncArgNames('minLength')), '')],
            'email' =>      ['name' => 'validateEmail', 'params' => array_fill_keys(array_values($this->getFuncArgNames('validateEmail')), '')],
            'required' =>   ['name' => 'requireParam',  'params' => array_fill_keys(array_values($this->getFuncArgNames('requireParam')), '')]
        ];

        if (!is_array($data) || empty($params) && !is_array($params))
            throw new Exception("Method accepts 2 parameters which should be arrays");

        foreach ($params as $k=>$v) {
            $v = array_map('trim', explode(',', $v));

            if (empty($v))
                throw new Exception("Params is empty for {$k}");

            foreach ($v as $param) {
                $paramsForCallback = [];
                $options = null;

                if (strpos($param, ":")) {
                    $param_part = array_map('trim', explode(':', $param));
                    $param = $param_part[0];
                    unset($param_part[0]);
                    $options = array_values($param_part);
                }

                if ($methods[$param]['params']) {
                    foreach ($methods[$param]['params'] as $key_item=>$item) {
                        if ($key_item == 'data')
                            $methods[$param]['params'][$key_item] = $data;

                        if ($key_item == 'field_value')
                            $methods[$param]['params'][$key_item] = $data[$k];

                        if ($key_item == 'options')
                            $methods[$param]['params'][$key_item] = $options;

                        if ($key_item == 'field_name')
                            $methods[$param]['params'][$key_item] = $k;
                    }
                    $paramsForCallback = array_merge($methods[$param]['params'], $paramsForCallback);
                }

                if (!in_array($param, array_keys($methods)))
                    throw new Exception("param: '{$param}' does not exist");

                call_user_func_array([$this,  $methods[$param]['name']], $paramsForCallback);
            }
        }

    }

    /*
     * @param array $data, $params
     *
     * @return string
     */
    public function requireParam($data, $field_value, $field_name)
    {
        if (!isset($data[$field_name]) || empty($field_value))
            $this->errors = array_merge($this->errors, [$field_name => "field '{$field_name}' is required"]);

        return true;
    }

    public function minLength($field_value, $field_name, array $options)
    {
        if (strlen($field_value) < intval($options[0]))
            $this->errors = array_merge($this->errors, [$field_name => "the field must not be less than {$options[0]} characters"]);

        return true;
    }

    /*
     * @param string $input
     *
     * @return bool
     */
    public function validateEmptyInput($input)
    {
        return !empty($input) ?? false;
    }

    /*
     * @param string $password
     *
     * @return bool
     */
    public function validateLengthPassword($password)
    {
        return strlen($password) > 6 ?? false;
    }

    /*
     * @param string $password1, $password2
     *
     * @return bool
     */
    public function validateEqualPasswords($password1, $password2)
    {
        return $password1 === $password2 ?? false;
    }
}