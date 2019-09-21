<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\assets\ToastrAsset;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;
use \yii\helpers\ArrayHelper;

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
$navigationItems = [
    ['label' => 'Projects', 'url' => ['project/index'], 'type' => 1],
    ['label' => 'Customers', 'url' => ['customer/index'], 'type' => 1],
    ['label' => 'Invoices', 'url' => ['invoice/index'], 'type' => 1],
    ['label' => 'Projects Payments', 'url' => ['project-payment/index'], 'type' => 1],
    ['label' => 'Employees', 'url' => ['employee/index'], 'type' => 1],
    ['label' => 'Procurements', 'url' => ['procurement/index'], 'type' => 1],
    ['label' => 'Projects Expenses', 'url' => ['project-expense/index'], 'type' => 1],
    ['label' => 'Suppliers', 'url' => ['supplier/index'], 'type' => 1],
    ['label' => 'Releases', 'url' => ['release/index'], 'type' => 1],
];

$currentAction = Yii::$app->controller->id . '/' . Yii::$app->controller->action->id;
$urls = array_map(function ($item) {
    return $item['url'][0];
}, $navigationItems);
if (!in_array($currentAction, $urls)) {
    $navigationItems [] = ['label' => Yii::$app->requestedRoute, 'url' => [$currentAction], 'type' => 1, 'options' => ['style' => 'position:absolute;right:10px']];
}
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
                            . Html::submitButton(Html::img('@web/images/header/logout.svg', ['class' => 'img', 'alt' => 'Logout']) . ' Logout' . ' (' . User::get()->username . ')'
                                . Html::endForm()); ?>
                    </li>
                <?php endif; ?>
            </div>
            <div id="mainTitle">
                <?php echo Yii::$app->name; ?>
            </div>
        </div>
        <div id="nav">
            <ul style="margin-right: 50px">
                <?php if (!Yii::$app->user->isGuest): ?>
                    <?php foreach ($navigationItems as $item) : ?>
                        <?php if ($item['type'] >= User::get()->type): ?>
                            <?php $active = $this->context->route == $item['url'][0] ? 'active-link' : ''; ?>
                            <?= Html::a("<li class='$active'>$item[label]</li>", Url::to($item['url']), ArrayHelper::getValue($item, 'options', [])) ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if (Yii::$app->user->isGuest): ?>
                    <li>
                        <?php $text = Html::img('@web/images/header/login.svg', ['class' => 'img', 'alt' => 'Login']) . ' Login' ?>
                        <?= Html::a($text, Url::to(['/site/login'])) ?>
                    </li>
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
        <p class="pull-left">&copy;ARF <?= date('Y') . ' - V' . VERSION ?></p>

        <p class="pull-right"></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
