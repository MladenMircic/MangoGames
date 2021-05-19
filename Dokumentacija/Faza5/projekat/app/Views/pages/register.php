<form method="post" action=" <?= site_url("Register/checkRegisterCredentials") ?>">
    <table class="table registerForm">
        <tr>
            <td colspan="2" style="color: red; border-top: none">
                <?php
                if (!empty($errors['username']))
                    echo $errors['username'];
                else if (!empty($errors['password'])) {
                    echo $errors['password'];
                }
                else if (!empty($errors['confirmPass'])) {
                    echo $errors['confirmPass'];
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>
                Username:
            </td>
            <td>
                <input type="text" name="username">
            </td>
        </tr>
        <tr>
            <td>
                Password:
            </td>
            <td>
                <input type="password" name="password">
            </td>
        </tr>
        <tr>
            <td>
                Confirm password:
            </td>
            <td>
                <input type="password" name="confirmPass">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center">
                <input class="btn btn-dark btnRegister" type="submit" name="submit" value="Register">
            </td>
        </tr>
    </table>
</form>