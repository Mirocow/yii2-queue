<?php

namespace mirocow\queue\models;

use yii\base\Model;
use yii\helpers\Json;

/**
 * Class MessageModel
 * @package mirocow\queue\models
 *
 * @property string $worker
 * @property string $class this is optional property, no required
 * @property string $method
 * @property array $arguments
 */
class MessageModel extends Model
{
    public $worker;
    public $class;
    public $method;
    public $arguments = [];

    public function rules()
    {
        return [
            [['worker', 'method'], 'required'],
            [['worker', 'class', 'method'], 'string'],
        ];
    }

    /**
     * @param mixed $message
     * @return $this
     */
    public static function loadRawMessage($payload = null)
    {
        if (!empty($payload) && is_string($payload)) {
            $payload = Json::decode($payload);
            if(!$payload){
                return null;
            }
            return new self($payload);
        } else
            return null;
    }

    /**
     * Convert model to JSON
     *
     * @return string
     */
    public function toJSON()
    {
        return Json::encode($this->getAttributes());
    }

}
