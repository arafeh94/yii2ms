<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 6/9/2018
 * Time: 5:12 PM
 */

/**
 * @var $requiredCredits int
 * @var $transferredCreditsDetails string
 * @var $transferredCredits int
 * @var $gradCredits int
 * @var $passedCredits int
 */

?>

<table class="table table-borderless table-condensed table-striped" style="margin-bottom: 0; width: auto">
    <tr>
        <td>Credits required for the major</td>
        <td class="info"><?= $requiredCredits ?></td>
    </tr>
    <?php if ($transferredCredits) : ?>
        <tr>
            <td>Transferred credits <?= $transferredCreditsDetails ? $transferredCreditsDetails : '' ?></td>
            <td class="info"><?= $transferredCredits ?></td>
        </tr>
    <?php endif; ?>
    <tr>
        <td>Credits needed for graduation</td>
        <td class="info"><?= $gradCredits ?></td>
    </tr>
    <tr>
        <td>Credits passed</td>
        <td class="info"><?= $passedCredits ?></td>
    </tr>
</table>
