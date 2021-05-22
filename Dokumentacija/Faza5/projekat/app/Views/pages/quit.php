
<table class="table tableQuit">
    <tr>
        <td colspan="2" style="font-weight: bold; border: none">
            Are you sure you want to quit the game?
        </td>
    </tr>
    <tr>
        <td style="border: none">
            <form method="post" action="<?= site_url('User/logout') ?>">
                <input class="btn btn-dark" type="submit" value="YES">
            </form>
        </td>
        <td style="border: none">
            <form method="post" action="<?= site_url('User') ?>">
                <input class="btn btn-dark" type="submit" value="NO" id="no">
            </form>
        </td>
    </tr>
</table>