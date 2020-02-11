<?php


class Validation
{
    /*
     * @param string $email
     *
     * @return bool
     */
    public function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function validateEmptyInput($input)
    {
        return empty($input) ? false : true;
    }
}