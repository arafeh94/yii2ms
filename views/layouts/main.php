<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>


<?php
$navigation = [
    ['label' => 'AdminAction1', 'url' => ['site/index'], 'type' => 1],
    ['label' => 'AdminAction2', 'url' => ['site/about'], 'type' => 1],
    ['label' => 'AdminAction3', 'url' => ['site/about'], 'type' => 1],
    ['label' => 'UserAction1', 'url' => ['site/about'], 'type' => 2],
    ['label' => 'UserAction2', 'url' => ['site/about'], 'type' => 2],
    ['label' => 'UserAction3', 'url' => ['site/about'], 'type' => 2],
];
?>

<div class="wrap">

    <div id="header">
        <div id="topRightLinks">
            <ul>

                <?php if (Yii::$app->user->isGuest): ?>
                    <li><?php echo Html::a(Html::img('@web/images/header/login.svg', ['class' => 'img', 'alt' => 'Login']), Url::to(['/site/login'])) ?></li>
                <?php endif; ?>


                <?php if (!Yii::$app->user->isGuest): ?>
                    <li><?php echo Html::a(Html::img('@web/images/header/settings.svg', ['class' => 'img', 'alt' => 'Settings']), Url::to(['/site/settings'])) ?></li>
                    <li>
                        <?php echo Html::beginForm(['/site/logout'], 'post')
                            . Html::submitButton(Html::img('@web/images/header/logout.svg', ['class' => 'img', 'alt' => 'Logout']) . ' (' . Yii::$app->user->identity->Username . ')'
                                . Html::endForm()); ?>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
        <div id="title">
            <div id="mainTitle">
                <?php echo Yii::$app->name; ?>
            </div>
            <div id="subTitle">
                <?php echo Yii::t('app', 'University Scholarship Program') ?>
            </div>
        </div>
        <div id="nav">
            <ul>

                <?php if (!Yii::$app->user->isGuest): ?>
                    <?php foreach ($navigation as $n) : ?>
                        <?php if ($n['type'] >= Yii::$app->user->identity->Type): ?>
                            <li><?=
                                Html::a($n['label'], Url::to($n['url']),
                                    $this->context->route == $n['url'][0] ? ['class' => 'activeLink'] : []
                                ) ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <div class="container effect7">
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; LAU <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
