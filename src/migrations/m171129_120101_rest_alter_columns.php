<?php
use yii\db\Schema;
class m171129_120101_rest_alter_columns extends \yii\db\Migration
{
    public function up()
    {
        $database = Yii::$app->db->createCommand("SELECT DATABASE()")->queryScalar();

        $query = "
            SELECT
                1
            FROM
                information_schema.COLUMNS
            WHERE
                TABLE_SCHEMA = '$database'
            AND table_name = 'user'
            AND column_name = 'col1'
        ";

        $result = \Yii::$app->db->createCommand($query)->queryAll();

        if (!count($result)) {
            $sql = "ALTER TABLE user ADD col1 INT (11) NOT NULL";
            $this->execute($sql);
        }
    }
}