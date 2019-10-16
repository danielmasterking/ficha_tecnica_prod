<?php 
namespace app\models;

use Yii;


class Hdv_tercero extends \yii\db\ActiveRecord{

	public $archivo;


	public static function tableName()
    {
        return 'hdv_tercero';
    }



    public function rules()
    {
        return [
            [['archivo'],'safe'],
            //[['archivo'],'file','extensions'=>'jpg, gif, png, pdf, jpeg', 'maxFiles' => 1],
        ];
    }


    public function attributeLabels()
    {
        return [
           
            'archivo' => 'Hoja de vida',

        ];
    }


}





?>
