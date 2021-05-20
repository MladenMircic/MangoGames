<table class="table tableAdminMenu">
<tr >
    <td class="borderless">
        <form method="post" action= "<?= site_url("Administrator/Leaderboards")?>">
            <input type="submit" class="btn btnMenu btn-dark" name="submit" value="leaderboards">
        </form>
    </td>
</tr>
<tr>
    <td class="borderless">
        <form method="post" action= "<?= site_url("Administrator/update")?>">
            <input type="submit" class="btn btnMenu btn-dark" name="submit" value="Update">
        </form>
    </td>
</tr>
<tr>
    <td class="borderless">
        <form method="post" action= "<?= site_url("Administrator/mistakeLog")?>">
            <input type="submit" class="btn btnMenu btn-dark" name="submit" value="Mistake Log">
        </form>
    </td>
</tr>
<tr>
    <td class="borderless">
        <form method="post" action= "<?= site_url("Administrator/changeLog")?>">
            <input type="submit" class="btn btnMenu btn-dark" name="submit" value="Change Log">
        </form>
    </td>
</tr>
<tr>
    <td class="borderless">
        <form method="post" action= "<?= site_url("Administrator/deleteLog")?>">
            <input type="submit" class="btn btnMenu btn-dark" name="submit" value="Delete Log">
        </form>
    </td>
</tr>
<tr>
    <td class="borderless">
        <form method="post" action= "<?= site_url("Administrator/registerModerator")?>">
            <input type="submit" class="btn btnMenu btn-dark" name="submit" value="Register Moderator">
        </form>
    </td>
</tr>
<tr>
    <td class="borderless">
        <form method="post" action= "<?= site_url("Administrator/quit")?>">
            <input type="submit" class="btn btnMenu btn-dark" name="submit" value="Quit">
        </form>
    </td>
</tr>
</table>