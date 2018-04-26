<?php
namespace app\components;

use Yii;
use app\models\Merchant;
use app\models\MerchantCallback;
use app\models\MerchantCallbackLog;
use app\models\MerchantCallbackQueue;
use app\models\MerchantCallbackQueueTmp;
use app\models\MerchantTransaction;
use app\models\labels\ModelLabel;
use app\components\Curl;
use app\modules\v1\handlers\ApiException;

class CallbackHandler
{
    static function saveCallback($data)
    {

        if (!$data) return false;

        $callbackqueue = new MerchantCallbackQueue();
        $tmp = new MerchantCallbackQueueTmp();
        $callbackqueue->setAttributes($data);
        $tmp->setAttributes($data);
        $callbackqueue->transaction_id = (string)$callbackqueue->transaction_id;
        $tmp->transaction_id = (string)$tmp->transaction_id;

        if ($callbackqueue->save() && $tmp->save()) {
            return true;
        } else {
            $errors = "";

            if (!empty($callbackqueue->getErrors())) {
                $errors = json_encode($callbackqueue->getErrors());
            }

            if (!empty($tmp->getErrors())) {
                $errors = json_encode($tmp->getErrors());
            }

            return false;
        }

    }

    static function doProcess()
    {
        //failed: 0 new, 1 success, 2 failed
        $callback_list = MerchantCallbackQueueTmp::find()
            ->where(['merchant_callback_queue_tmp.status' => ['0', '2']])
            ->andFilterWhere(['<', 'merchant_callback_queue_tmp.callback_attempt', '6'])
            // ->join('join',
            //     'merchant_callback',
            //     'merchant_callback.merchant_id=merchant_callback_queue_tmp.merchant_id'
            // )//merchant callback
            ->all();

        self::startProcess($callback_list);
    }


    static function byMerchantId($id)
    {

        //failed: 0 new, 1 success, 2 failed
        $callback_list = MerchantCallbackQueueTmp::find()
            ->where(['merchant_callback_queue_tmp.status' => ['0', '2']])
            ->andFilterWhere(['<', 'merchant_callback_queue_tmp.callback_attempt', '6'])
            ->andWhere(['merchant_callback_queue_tmp.merchant_id' => $id])
            ->all();

        self::startProcess($callback_list);
    }

    static function byTransactionId($id)
    {

        //failed: 0 new, 1 success, 2 failed
        $callback_list = MerchantCallbackQueueTmp::find()
            ->where(['merchant_callback_queue_tmp.status' => ['0', '2']])
            ->andFilterWhere(['<', 'merchant_callback_queue_tmp.callback_attempt', '6'])
            ->andWhere(['merchant_callback_queue_tmp.transaction_id' => $id])
            ->all();

        self::startProcess($callback_list);
    }
    
    protected static function startProcess($callback_list)
    {
        if ($callback_list) {
            
            // update to 'on process'
            $trx_id = [];
            foreach ($callback_list as $list) {
                $trx_id[] = $list->transaction_id;
            }
            MerchantCallbackQueue::updateAll(['status' => '3'], ['in', 'transaction_id', $trx_id]);
            MerchantCallbackQueueTmp::updateAll(['status' => '3'], ['in', 'transaction_id', $trx_id]);
            // end update

            echo "start\n\n";
            $process_id = uniqid();
            foreach ($callback_list as $row) {

                if (self::doProcessSingle($row, $process_id, $row->id) == true) {
                    echo "trxid : " . $row->transaction_id . " - success\n";
                } else {
                    echo "trxid : " . $row->transaction_id . " - failed\n";
                }
            }

            echo "finish\n\n";
        } else {
            echo "do nothing";
        }
    }

    static function doRetryCallback($id = 0, $process_id = null)
    {
        if ($id == 0) {
            //failed: 0 new, 1 success, 2 failed
            $merchant_queue_list = MerchantCallbackQueue::find()
                ->where(['merchant_callback_queue.status' => ['2']])
                // ->andFilterWhere(['>=', 'merchant_callback_queue.callback_attempt', '6'])
                // ->join('join',
                //     'merchant_callback',
                //     'merchant_callback.merchant_id=merchant_callback_queue.merchant_id'
                // )//merchant callback
                ->asArray()
                ->all();
            if ($merchant_queue_list) {
                // update to 'on process'
                $trx_id = [];
                foreach ($merchant_queue_list as $list) {
                    $trx_id[] = $list['transaction_id'];
                }
                MerchantCallbackQueue::updateAll(['status' => '3'], ['in', 'transaction_id', $trx_id]);
                // end update
                $callback_list = [];
                foreach ($merchant_queue_list as $list) {
                    $tmp = new MerchantCallbackQueueTmp();
                    $tmp->setAttributes($list);
                    $tmp->status = '3';
                    $tmp->save();
                    $callback_list[] = $tmp;
                }
            } else {
                echo "not found";
                exit;
            }


        } else {
            $merchant_queue = MerchantCallbackQueue::find()
                ->where(['merchant_callback_queue.status' => ['2']])
                // ->andFilterWhere(['>=', 'merchant_callback_queue.callback_attempt', '6'])
                ->andWhere(['merchant_callback_queue.id' => $id])
                // ->join('join',
                //     'merchant_callback',
                //     'merchant_callback.merchant_id=merchant_callback_queue.merchant_id'
                // )//merchant callback
                ->asArray()
                ->one();
            if ($merchant_queue) {
                MerchantCallbackQueue::updateAll(['status' => '3'], ['transaction_id' => $merchant_queue['transaction_id']]);
                $callback_list = [];
                $tmp = new MerchantCallbackQueueTmp();
                $tmp->setAttributes($merchant_queue);
                $tmp->status = '3';
                $tmp->save();
                $callback_list[] = $tmp;
            } else {
                echo "not found";
                exit;
            }

        }

        if ($callback_list) {
            // echo "start retry callback\n\n";

            $process_id = (!empty($process_id)) ? $process_id : uniqid();
            foreach ($callback_list as $row) {

                if (self::doProcessSingle($row, $process_id, $row->id) == true) {
                    echo "trxid : " . $row->transaction_id . " - success\n";
                } else {
                    echo "trxid : " . $row->transaction_id . " - failed\n";
                }
            }

            echo "finish\n\n";
        } else {
            echo "do nothing";
        }
    }

    static function doRetryByMerchantId($id = 0, $process_id = null)
    {
        if ($id == 0) {
            $message = "Class :  CallbackHandler\nFunction : doRetryByMerchantId()\nError : Do Nothing\nLine : 210";
            Curl::bot_telegram($message);
            echo "do nothing";
            exit;
        } else {
            $merchant_queue = MerchantCallbackQueue::find()
                ->where(['merchant_callback_queue.status' => ['2']])
                ->andWhere(['merchant_callback_queue.merchant_id' => $id])
                ->asArray()->one();
            if ($merchant_queue) {
                MerchantCallbackQueue::updateAll(['status' => '3'], ['transaction_id' => $merchant_queue['transaction_id']]);
                $callback_list = [];
                $tmp = new MerchantCallbackQueueTmp();
                $tmp->setAttributes($merchant_queue);
                $tmp->status = '3';
                $tmp->save();
                $callback_list[] = $tmp;
            } else {
                echo "not found";
                exit;
            }

        }

        if ($callback_list) {
            // echo "start retry callback\n\n";

            $process_id = (!empty($process_id)) ? $process_id : uniqid();
            foreach ($callback_list as $row) {

                if (self::doProcessSingle($row, $process_id, $row->id) == true) {
                    echo "trxid : " . $row->transaction_id . " - success\n";
                } else {
                    echo "trxid : " . $row->transaction_id . " - failed\n";
                }
            }

            echo "finish\n\n";
        } else {
            echo "do nothing";
        }
    }

    static function doRetryByTransactionId($id = 0, $process_id = null)
    {
        if ($id == 0) {
            $message = "Class :  CallbackHandler\nFunction : doRetryByTransactionId()\nError : Do Nothing\nLine : 260";
            Curl::bot_telegram($message);
            echo "do nothing";
            exit;
        } else {
            $merchant_queue = MerchantCallbackQueue::find()
                ->where(['merchant_callback_queue.status' => ['2']])
                ->andWhere(['merchant_callback_queue.transaction_id' => $id])
                ->asArray()->one();
            if ($merchant_queue) {
                MerchantCallbackQueue::updateAll(['status' => '3'], ['transaction_id' => $merchant_queue['transaction_id']]);
                $callback_list = [];
                $tmp = new MerchantCallbackQueueTmp();
                $tmp->setAttributes($merchant_queue);
                $tmp->status = '3';
                $tmp->save();
                $callback_list[] = $tmp;
            } else {
                echo "not found";
                exit;
            }

        }

        if ($callback_list) {
            // echo "start retry callback\n\n";

            $process_id = (!empty($process_id)) ? $process_id : uniqid();
            foreach ($callback_list as $row) {

                if (self::doProcessSingle($row, $process_id, $row->id) == true) {
                    echo "trxid : " . $row->transaction_id . " - success\n";
                } else {
                    echo "trxid : " . $row->transaction_id . " - failed\n";
                }
            }

            echo "finish\n\n";
        } else {
            echo "do nothing";
        }
    }

    protected static function doProcessSingle($row, $process_id = '00000000000000', $tmp_id = null)
    {
        try {
            
            $transaction_id = $row->transaction_id;
            $merchant_callback_queue_tmp_id = $row->id;
            if (empty($tmp_id)) {
                $merchant_queue = MerchantCallbackQueue::findOne(['transaction_id' => $transaction_id, 'id' => $tmp_id]);
            } else {
                $merchant_queue = MerchantCallbackQueue::findOne(['transaction_id' => $transaction_id]);
            }
            $queue_id = $merchant_queue->id;

            if ($transaction_id) {

                $detail = MerchantTransaction::find()->where(['id' => $transaction_id])->one();

                $merchant = $detail->merchantByCode;

               // dd($detail->merchant_id);
               // dd($merchant);

                $response = array();

                if (strlen($detail->journal_tag) != 9) {
                    $child = Merchant::findOne(['mid' => $detail->journal_tag]);
                    $merchant_id = $merchant->mid;
                    $merchant_name = $merchant->name;
                    $sub_merchant_id = $child->mid;
                    $sub_merchant_name = $child->name;
                } else {
                    $merchant_id = $merchant->mid;
                    $merchant_name = $merchant->name;
                    $sub_merchant_id = NULL;
                    $sub_merchant_name = NULL;
                }

                if ($merchant) {
                    $response['merchant'] = true;
                    $response['merchant_email'] = $merchant->email;
                    // $response['merchant_id'] = $merchant->mid;
                    // $response['merchant_name'] = $merchant->name;
                    $response['merchant_id'] = $merchant_id;
                    $response['merchant_name'] = $merchant_name;
                    $response['sub_merchant_id'] = $sub_merchant_id;
                    $response['sub_merchant_name'] = $sub_merchant_name;
                    $response['merchant_prime_id'] = '';
                    $response['merchant_feedback'] = "Available";
                } else {
                    $response['merchant'] = false;
                    $response['merchant_email'] = NULL;
                    $response['merchant_id'] = NULL;
                    $response['merchant_name'] = NULL;
                    $response['sub_merchant_id'] = NULL;
                    $response['sub_merchant_name'] = NULL;
                    $response['merchant_prime_id'] = NULL;
                    $response['merchant_feedback'] = "Invalid Merchant or Merchant is Inactive";
                }


                $sof = "";
                switch ($detail->pay_type) {
                    case 'debit':
                        $sof = 'd';
                        break;
                    case 'unikqu':
                        $sof = 'u';
                        break;
                    case 'visa':
                        $sof = 'v';
                        break;
                    case 'master':
                        $sof = 'm';
                        break;
                    case 'mastercard':
                        $sof = 'm';
                        break;
                }

                $data = [
                    'bill_id' => $detail->bill_id,
                    'ref_id' => $detail->ref_id,
                    'approval_code' => $detail->approval_code,
                    'consumer_pan_masking' => $detail->consumer_pan_masking,
                    'payment_amount' => $detail->payment_amount,
                    'payment_amount_fee' => $detail->payment_amount_fee,
                    'transaction_date' => $detail->transaction_date,
                    'payment_type' => $detail->pay_type,
                    'payment_sof' => $sof,
                    'currency_code' => 'IDR',
                    'pid' => $detail->id,
                    'merchant_id' => $response['merchant_id'],
                    'merchant_name' => $response['merchant_name'],
                    'sub_merchant_id' => $response['sub_merchant_id'],
                    'sub_merchant_name' => $response['sub_merchant_name'],
                    'merchant_prime_id' => $response['merchant_prime_id'],
                ];


                $callback = MerchantCallback::find()
                    ->where(['merchant_id' => $merchant->merchant_id])
                    ->one();

                $responseDecode = ['status' => "111"];

                $message = "default";

                if ($callback) {
                    $response['ref_url'] = true;

                    if ($callback->callback_url) {
                        $response['url'] = $callback->callback_url;
                        // $responseJson = Curl::get_content($response['url'], json_encode($data));
                        // $responseDecode = json_decode($responseJson, true);
                        $i = 0;
                        $max_retry = Yii::$app->params['callback']['max_retry'];
                        while ($i < $max_retry or $responseDecode['status'] != '000') {
                            $responseJson = Curl::get_content($response['url'], json_encode($data));
                            $responseDecode = json_decode($responseJson, true);
                            if (isset($responseDecode['status']) && $responseDecode['status'] == '000') {
                                $i = $max_retry;
                                break;
                            } elseif ($i == $max_retry) {
                                break;
                            }
                            $i++;
                        }

                        // $responseDecode = ['status' => '000'];

                        $response['url_response'] = $responseDecode;
                        $response['url_value_status'] = false;
                        $response['url_status'] = false;
                        $response['url_value'] = "Invalid Response";
                        $message = "failed";

    //                    if (array_key_exists("status", $response['url_response'])) {
                        if (isset($response['url_response']['status'])) {


                            $status = $response['url_response']['status'];

                            if ($status == '000') {

                                $response['url_status'] = true;
                                $response['url_value_status'] = true;
                                $response['url_value'] = $response['url_response']['status'];
                                $message = "success";
                            }
                        }
                    } else {
                        $response['url_status'] = false;
                        $response['url'] = "URL Not set";

                        $response['url_response'] = NULL;

                        $response['url_value_status'] = false;
                        $response['url_value'] = NULL;
                        $message = "failed";
                    }
                } else {
                    $response['ref_url'] = false;

                    $response['url_status'] = false;
                    $response['url'] = "URL Not Set";
                    $response['url_response'] = NULL;
                    $response['url_value_status'] = false;
                    $response['url_value'] = NULL;
                    $message = "failed";
                }

                $response_date = date("Y-m-d h:i:s");
                $feedback = self::response($response);
                // dd($feedback);

                $callback_log = new MerchantCallbackLog();

                $callback_log->setAttributes([
                    'response_code' => isset($responseDecode['status']) ? $responseDecode['status'] : '111',
                    'process_id' => $process_id,
                    'message' => $message,
                    'merchant_callback_queue_id' => $queue_id,
                    'merchant_id' => $merchant->merchant_id,
                    'request' => json_encode($data),
                    'response' => json_encode($responseDecode),
                    'detail' => json_encode($response),
                ]);
                if ($callback_log->validate()) {

                    $find = MerchantCallbackQueueTmp::findOne($merchant_callback_queue_tmp_id);
                    // d($merchant_queue);
                    // dd($find);
                    if ($callback_log->save()) {
                        
                        if ($callback_log->message == 'failed') {
                            $merchant = json_decode($callback_log->request,true);
                            $message =  "[TRANSACTION]".
                                        "\nBill ID => ".$merchant['bill_id'].
                                        "\nRef ID => ".$merchant['ref_id'].
                                        "\nMerchant ID => ".$merchant['merchant_id'].
                                        "\nMerchant Name => ".$merchant['merchant_name'].
                                        "\nSub Merchant ID => ".$merchant['sub_merchant_id'].
                                        "\nSub Merchant Name => ".$merchant['sub_merchant_name'].
                                        "\nPayment Amount => ".$merchant['payment_amount'].
                                        "\nPayment Amount Fee => ".$merchant['payment_amount_fee'].
                                        "\nResponse => ".$callback_log->response.
                                        "\nResponse Detail => ".$callback_log->detail;
                            Curl::bot_telegram($message);
                        }

                        if (!$response['url_status']) {
                            //set status to failed 2, add callback attemp +1
                            $merchant_queue->setAttributes([
                                'callback_attempt' => $merchant_queue->callback_attempt + 1,
                                'status' => '2'
                            ]);
                            $merchant_queue->save();
                            $find->delete();

                            return false;
                        } else {

                            //set to success 1
                            $merchant_queue->setAttributes([
                                'callback_attempt' => $merchant_queue->callback_attempt + 1,
                                'status' => '1']);
                            $merchant_queue->save();
                            $find->delete();
                        }

                        return $response['url_status'];
                    } else {

                        //set status to failed 2, add callback attemp +1
                        $merchant_queue->setAttributes([
                            'callback_attempt' => $merchant_queue->callback_attempt + 1,
                            'status' => '4'
                        ]);

                        $merchant_queue->save();
                        $find->delete();

                        return false;
                    }

                } else {
                    
                    print_r($callback_log->errors);
                    die;
                }


                return true;
            }
            return false;
        } catch (\Exception $e) {
           
            self::catchError($e);
        }
    }

    public static function response($response)
    {
        $result = array();

        if ($response['merchant'] == true && $response['ref_url'] == true && $response['url_status'] == true && $response['url_value_status'] == true) {
            $result['status'] = "000";
            $result['response'] = $response['url_response'];

            return $result;
        } else {
            $error['merchant'] = $response['merchant_feedback'];
            $error['url'] = $response['url'];
            $error['ref_url'] = $response['url_response'];
            $error['url_value'] = $response['url_value'];

            $result['status'] = "619";
            $result['response'] = $error;
            
            return $result;
        }
    }

    public static function runConsole()
    {
        $path = Yii::getAlias('@command');
        $command = "nohup " . PHP_PATH . ' ' . $path . DIRECTORY_SEPARATOR ."yii callback &"; // TODO dynamic action and params 
        return shell_exec($command);
    }

    public static function runConsoleRetry($id = 0, $process_id = null)
    {
        $path = Yii::getAlias('@command');
        $process_id = (!empty($process_id)) ? $process_id : uniqid();
        $command = PHP_PATH . ' ' . $path . DIRECTORY_SEPARATOR ."yii callback/retry ".$id. " " . $process_id; // TODO dynamic action and params 
        return shell_exec($command);
    }

    protected function catchError($e)
    {
        Yii::error($e);

        if ($e instanceof ApiException) {
            echo $e->responseSend();
        } else {
            $data = array('line' => $e->getLine(), 'file' => $e->getFile());
            $response = array(
                'status' => 333,
                'message' => $e->getMessage()
            );

            if (\Yii::$app->params['debug']) $response['data'] = $data;
            $resp = json_encode($response);

            echo $resp;
        }

        return false;
    }
}