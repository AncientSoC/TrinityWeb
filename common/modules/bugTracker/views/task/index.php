<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\modules\bugTracker\models\Task;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\bugTracker\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('bugTracker','Задачи');
Yii::$app->params['breadcrumbs'][] = $this->title;
if (is_null($searchModel->project_id)) {
    $createUri = ['create'];
} else {
    $createUri = ['create', 'project_id' => $searchModel->project_id];
}

?>
    <div class="task-index">

        <h1><?= Html::encode($this->title) ?></h1>
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a(Yii::t('bugTracker','Добавить задачу'), $createUri, ['class' => 'btn btn-success']) ?>
        </p>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'options' => [
                'class' => 'grid-view table-responsive'
            ],
            'columns' => [
                'task_id',
                [
                    'attribute' => 'project_id',
                    'value' => function ($model) {
                        return $model->project->name;
                    },
                ],
                [
                    'attribute' => 'title',
                    'value' => function ($model) {
                        return Html::a($model->title, ['view', 'task_id' => $model->task_id]);
                     },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'status',
                    'filter' => Task::statuses(true),
                    'value' => function ($model) {
                        return Task::statuses(true)[$model->status];
                    },
                ],
                [
                    'attribute' => 'priority',
                    'filter' => Task::priorities(),
                    'value' => function ($model) {
                        return Task::priorities()[$model->priority];
                    },
                ],
//                'created_at',
//                'updated_at',
//                'closed_at',
                // 'description:ntext',

            ],
        ]); ?>
    </div>

<?php
//echo $this->render('_calendar');