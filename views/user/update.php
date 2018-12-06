<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/24/2018
 * Time: 12:02 AM
 */

use kartik\widgets\ActiveForm;


/** @var $git String */
/** @var $composer String */
/** @var $database String */
?>

<div class="card" style="width: 90%;padding: 8px">
    <div class="alert alert-info fadeIn" style="font-size: 1.2em">
        <div style="margin-bottom: 16px"><b>Logs</b>:<br></div>
        <div style="margin-bottom: 4px"><b>Git</b>: <?= $git ?><br></div>
        <div style="margin-bottom: 4px"><b>Repositories</b>: <?= !$composer ? 'No new repositories. Your system is up-to-date.' : $composer ?><br></div>
        <div style="margin-bottom: 4px"><b>Database</b>: <?= $database ?><br></div>
    </div>
    <button onclick="location.href='index'" class="btn btn-success"
            style="width:100%;margin: 8px auto auto;">Home
    </button>
</div>



