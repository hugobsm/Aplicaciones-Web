
<?php

class RedsysAPI {
    private $params;
    private $clave;

    public function __construct() {
        $this->params = array();
    }

    public function setParameter($key, $value) {
        $this->params[$key] = $value;
    }

    public function getParameter($key) {
        return isset($this->params[$key]) ? $this->params[$key] : null;
    }

    public function createMerchantParameters() {
        $json = json_encode($this->params);
        $json = base64_encode($json);
        return $json;
    }

    public function createMerchantSignature($key) {
        $this->clave = $key;
        $decodedKey = base64_decode($this->clave);
        $order = $this->getParameter("DS_MERCHANT_ORDER");
        $keyDerivada = $this->encrypt_3DES($order, $decodedKey);
        $datos = $this->createMerchantParameters();
        $signature = $this->mac256($datos, $keyDerivada);
        return base64_encode($signature);
    }

    private function encrypt_3DES($message, $key) {
        $cipher = "des-ede3";
        $encryptedMessage = openssl_encrypt($message, $cipher, $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING);
        return $encryptedMessage;
    }

    private function mac256($data, $key) {
        return hash_hmac('sha256', $data, $key, true);
    }

    public function decodeMerchantParameters($datos) {
        $decoded = base64_decode($datos);
        return json_decode($decoded, true);
    }

    public function checkMerchantSignature($key, $datos, $firma) {
        $this->clave = $key;
        $decodedKey = base64_decode($this->clave);
        $params = $this->decodeMerchantParameters($datos);
        $order = $params["Ds_Order"];
        $keyDerivada = $this->encrypt_3DES($order, $decodedKey);
        $expectedSignature = base64_encode($this->mac256($datos, $keyDerivada));
        return $firma === $expectedSignature;
    }
}