<?php

namespace backend\controllers;

use Yii;
use backend\models\CategoryImages;
use backend\models\CategoryImagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\UploadedFile;
use common\components\AccessRule;
use yii\filters\AccessControl;
use common\models\Admin;


/**
 * CategoryImagesController implements the CRUD actions for CategoryImages model.
 */
class CategoryImagesController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
    'class' => AccessControl::className(),
    // We will override the default rule config with the new AccessRule class
    'ruleConfig' => [
    'class' => AccessRule::className(),
                          ],
    'only' => ['create', 'update', 'delete'],
    'rules' => [
        [
            'actions' => ['create'],
            'allow' => true,
            // Allow users, moderators and admins to create
            'roles' => [
                Admin::ROLE_USER,
                Admin::ROLE_MODERATOR,
                Admin::ROLE_ADMIN
            ],
        ],
        [
            'actions' => ['update'],
            'allow' => true,
            // Allow moderators and admins to update
            'roles' => [
                Admin::ROLE_MODERATOR,
                Admin::ROLE_ADMIN
            ],
        ],
        [
            'actions' => ['delete'],
            'allow' => true,
            // Allow admins to delete
            'roles' => [
                Admin::ROLE_ADMIN
            ],
        ],
    ],
],
        ];
    }

    /**
     * Lists all CategoryImages models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategoryImagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CategoryImages model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CategoryImages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CategoryImages();
        $model->scenario = CategoryImages::SCENARIO_CREATE;

        if ($model->load(Yii::$app->request->post()) ) 
            {
                if($model->image = UploadedFile::getInstance($model, 'image'))
                {
                    $model->save();
                    $image = $model->upload();        
                }          
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CategoryImages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        {
            if($model->image = UploadedFile::getInstance($model, 'image'))
            {
                $image =   $model->upload();        
                $model->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);  
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CategoryImages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CategoryImages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CategoryImages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CategoryImages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
