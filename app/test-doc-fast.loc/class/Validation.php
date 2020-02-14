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