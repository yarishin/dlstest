<?php
App::uses('Component', 'Controller');

class StripeComponent extends Component
{
    public function initialize(Controller $controller)
    {
        $this->controller = $controller;
    }

    private function setKey() {
        $this->setting = $this->controller->setting;
        if(!empty($this->setting['stripe_mode'])) {
            if(!empty($this->setting['stripe_secret'])) {
                \Stripe\Stripe::setApiKey($this->setting['stripe_secret']);
            } else {
                throw new InternalErrorException('stripe_secretが設定されていません');
            }
        } else {
            if(!empty($this->setting['stripe_test_secret'])) {
                \Stripe\Stripe::setApiKey($this->setting['stripe_test_secret']);
            } else {
                throw new InternalErrorException('stripe_test_secretが設定されていません');
            }
        }
    }

    /**
     * カード決済（即売上確定）
     * @param int $amount
     * @param string $token
     * @param string $description
     * @return string $charge_id
     */
    public function payForAllIn($amount, $token, $description = '') {
        $this->setKey();
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $amount,
                "currency" => "jpy",
                "source" => $token,
                "description" => $description
            ));
            return $charge->id;
        } catch (Exception $e) {
            $this->log('ERROR[StripeComponent.payForAllIn]');
            $this->log($e->getMessage());
            return null;
        }
    }

}