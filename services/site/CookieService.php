<?php

namespace app\services\site;

use Yii;
use yii\helpers\Html;

class CookieService
{

    public function getCookies()
    {
        $cookies = Yii::$app->response->cookies;
        $favoriteValidators = (Yii::$app->request->cookies->getValue('favoriteValidators')) ? Yii::$app->request->cookies->getValue('favoriteValidators') : "{}";
        return json_decode($favoriteValidators, true);
    }


    public function addInCookie($address)
    {
        $favoriteValidators = $this->getCookies();
        if (!$this->checkInCookie($address,$favoriteValidators)){
            $favoriteValidators[] = $address;
        }
        \Yii::$app->session->setFlash('success', 'Validator added to favorites');
        return $this->saveCookie($favoriteValidators);
    }

    public function deleteFromCookie($address)
    {
        $favoriteValidators = $this->getCookies();
        if (count($favoriteValidators)){
            foreach($favoriteValidators as $key => $value){
                if ($value == $address){
                    unset($favoriteValidators[$key]);
                }
            }
        }
        \Yii::$app->session->setFlash('warning', 'Validator removed from favorites');

        return $this->saveCookie($favoriteValidators);
    }

    public function checkInCookie($address,$favoriteValidators)
    {
        return in_array($address, $favoriteValidators);
    }

    public function removeCookie()
    {
        $cookies = Yii::$app->response->cookies;
        $cookies->remove('favoriteValidators');
        return true;
    }

    public function saveCookie($cookieData)
    {
        $cookies = Yii::$app->response->cookies;
        $this->removeCookie();
        $cookies->add(new \yii\web\Cookie([
            'name' => 'favoriteValidators',
            'value' => json_encode($cookieData),
            'expire' => time() + 31622400,
        ]));

        return true;
    }
}