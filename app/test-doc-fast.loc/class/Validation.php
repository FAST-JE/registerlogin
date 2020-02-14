<?php


class Validation
{
    public $errors = [];
    /*
     * @param string $email
     *
     * @return bool
     */
    public function validateEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            array_push($this->errors, "email is not valid");

        return true;
    }

    /*
     * @param array $data, $params
     *
     * @return string
     */

    public function validateData($data, $params)
    {

        $methods = [
            'email' => ['name' => 'validateEmail', 'params' => ['field'=>'']],
            'required' => ['name' => 'requireParam', 'params' => ['data'=>'', 'field_name'=>'']],
            'min' => ['name' => 'minLength', 'params' => ['field'=>'']]
        ];

        if (!is_array($data) || empty($params) && !is_array($params))
            throw new Exception("Method accepts 2 parameters which should be arrays");

        foreach ($params as $k=>$v) {
            $v = array_map('trim', explode(',', $v));

            if (empty($v))
                throw new Exception("Params is empty for {$k}");

            foreach ($v as $param) {
                $paramsForCallback = [];

                if (strpos($param, ":")) {
                    $param_part = array_map('trim', explode(':', $param));
                    $param = $param_part[0];
                    unset($param_part[0]);
                    $paramsForCallback = array_merge($paramsForCallback, $param_part);
                }

                if ($methods[$param]['params']) {
                    foreach ($methods[$param]['params'] as $key_item=>$item) {
                        if ($key_item == 'data')
                            $methods[$param]['params'][$key_item] = $data;

                        if ($key_item == 'field')
                            $methods[$param]['params'][$key_item] = $data[$k];

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
    public function requireParam($data, $required_param)
    {
        if (!isset($data[$required_param]))
            array_push($this->errors, "field is not found");

        return true;
    }

    public function minLength($field, $min_length)
    {
        if (strlen($field) < $min_length)
            array_push($this->errors, "the field must not be less than {$min_length} characters");

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