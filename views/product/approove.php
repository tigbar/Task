<form method="get" action="/">
    <input type="hidden" name="action" value="approove">
    <input type="hidden" name="totalSum" value=" . <?=$totalSum?> . ">
    <b>First name:</b>
    <input type="text" name="firstName">
    <br/><br/>
    <b>Last name:</b>
    <input type="text" name="lastName">
    <br/><br/>
    <b>email:</b>
    <input type="text" name="email">
    <input type="hidden" name="count" value="<?=$value['count']?>">
    <br/><br/>
    <input type="submit" value="Approove">
</form>

<?php
