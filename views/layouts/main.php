<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\assets\ToastrAsset;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
ToastrAsset::register($this);
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
    ['label' => 'Users', 'url' => ['user/index'], 'type' => 1],
    ['label' => 'Cycle', 'url' => ['cycle/index'], 'type' => 1],
    ['label' => 'School', 'url' => ['school/index'], 'type' => 1],
    ['label' => 'Department', 'url' => ['department/index'], 'type' => 1],
    ['label' => 'Major', 'url' => ['major/index'], 'type' => 1],
    ['label' => 'Course', 'url' => ['course/index'], 'type' => 1],
    ['label' => 'Instructor', 'url' => ['instructor/index'], 'type' => 1],
    ['label' => 'Terms', 'url' => ['term/index'], 'type' => 1],
    ['label' => 'Evaluation', 'url' => ['evaluation/index'], 'type' => 2],
    ['label' => 'Students', 'url' => ['student/index'], 'type' => 2],
    ['label' => 'Offered Courses', 'url' => ['offered-course/index'], 'type' => 2],
    ['label' => 'Evaluation Mails', 'url' => ['evaluation/mailing'], 'type' => 1],
];
?>

<div class="wrap">

    <div id="header">
        <div id="title">

            <div id="nav">
                <?php if (!Yii::$app->user->isGuest): ?>
                    <li class="rightItems"><?php echo Html::a(Html::img('@web/images/header/settings.svg', ['class' => 'img', 'alt' => ' Settings']) . ' Settings', Url::to(['/user/settings'])) ?>
                    </li>
                    <li class="rightItems">
                        <?php echo Html::beginForm(['/site/logout'], 'post')
                            . Html::submitButton(Html::img('@web/images/header/logout.svg', ['class' => 'img', 'alt' => 'Logout']) . ' Logout' . ' (' . Yii::$app->user->identity->Username . ')'
                                . Html::endForm()); ?>
                    </li>
                <?php endif; ?>
            </div>
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
                            <?php $o = $this->context->route == $n['url'][0] ? 'activeLink' : '';
                            $li1 = "<li class='$o'>"; ?>
                            <?= Html::a($li1 . $n['label'] . '</li>', Url::to($n['url'])) ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if (Yii::$app->user->isGuest): ?>
                    <li><?php echo Html::a(Html::img('@web/images/header/login.svg', ['class' => 'img', 'alt' => 'Login']) . ' Login', Url::to(['/site/login'])) ?></li>
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

        <p class="pull-right"></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
