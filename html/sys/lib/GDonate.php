<?php

class GDonate
{
    private $event;

    public function __construct(GDonateEvent $event)
    {
        $this->event = $event;
    }

    public function getResult($privategdonate)
    {
        $request = $_GET;

        if (empty($request['method'])
            || empty($request['params'])
            || !is_array($request['params'])
        )
        {
            return $this->getResponseError('Invalid request');
        }

        $method = $request['method'];
        $params = $request['params'];

        if ($params['sign'] != $this->getMd5Sign($params['account'], $params['sum'], $privategdonate))
        {
            return $this->getResponseError('Incorrect digital signature');
        }

        $GDonateModel = GDonateModel::getInstance();

        if ($method == 'check')
        {
            if ($GDonateModel->getPaymentByGDonateId($params['gdonateId']))
            {
                // Платеж уже существует
                return $this->getResponseSuccess('Payment already exists');
            }

            if (!$GDonateModel->createPayment(
                $params['gdonateId'],
                $params['account'],
                $params['sum'],
                1
            ))
            {
                return $this->getResponseError('Unable to create payment database');
            }

            $checkResult = $this->event->check($params);
            if ($checkResult !== true)
            {
                return $this->getResponseError($checkResult);
            }

            return $this->getResponseSuccess('CHECK is successful');
        }

        if ($method == 'pay')
        {
            $payment = $GDonateModel->getPaymentByGDonateId(
                $params['gdonateId']
            );

            if ($payment && $payment->status == 1)
            {
                return $this->getResponseSuccess('Payment has already been paid');
            }

            if (!$GDonateModel->confirmPaymentByGDonateId($params['gdonateId']))
            {
                return $this->getResponseError('Unable to confirm payment database');
            }

            $this->event
                ->pay($params);

            return $this->getResponseSuccess('PAY is successful');
        }

	return $this->getResponseError($method.' not supported');
    }

    private function getResponseSuccess($message)
    {
        return json_encode(array(
            "jsonrpc" => "2.0",
            "result" => array(
                "message" => $message
            ),
            'id' => 1,
        ));
    }

    private function getResponseError($message)
    {
        return json_encode(array(
            "jsonrpc" => "2.0",
            "error" => array(
                "code" => -32000,
                "message" => $message
            ),
            'id' => 1
        ));
    }

    private function getMd5Sign($account, $sum, $secretKey)
    {
        return md5($account.$sum.$secretKey);
    }
}
