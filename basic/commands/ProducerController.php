<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ProducerController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
        $config = \Kafka\ProducerConfig::getInstance();
		$config->setMetadataRefreshIntervalMs(10000);
		$config->setMetadataBrokerList('localhost:9092');
		$config->setBrokerVersion('1.0.0');
		$config->setRequiredAck(1);
		$config->setIsAsyn(true);
		$config->setProduceInterval(500);
		$producer = new \Kafka\Producer(
		    function() {
		        return [
		            [
		                'topic' => 'test',
		                'value' => date('YmdHis'),
		                'key' => 'testkey',
		            ],
		            [
		                'topic' => 'Sample',
		                'value' => 'Sample:'.date('YmdHis'),
		                'key' => 'testkey',
		            ],
		        ];
		    }
		);
		$producer->success(function($result) {
			var_dump($result);
		});
		$producer->error(function($errorCode) {
				var_dump($errorCode);
		});
		$producer->send(true);
    }
}
