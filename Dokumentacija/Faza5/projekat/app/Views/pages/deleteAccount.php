
<form method="post" action="<?=site_url('Administrator/deleteAccount') ?>">
<table class="table" style="text-align: center;">
    <tr>
        <td colspan="2" class="borderless" style="color: red">
            <?php
                if (!empty($errors['accountToDelete']))
                    echo $errors['accountToDelete'];
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" class="borderless" >
            <h3>Delete account</h3>
        </td>
    </tr>
    <tr>
        <td colspan="2" class="borderless" style="font-weight: bold;">
            Username:
            <input type="text" name="accountToDelete">
        </td>
    </tr>
    <tr>
        <td colspan="2" class="borderless">
            <input class="btn btn-dark" type="submit">
        </td>
    </tr>
</table>
</form>
