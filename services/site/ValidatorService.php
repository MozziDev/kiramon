<?php

namespace app\services\site;

use yii\httpclient\Client;

class ValidatorService
{
    public function getAllValidators()
    {
        $favoriteValidators = new CookieService();
        $cookieFavoriteArr = $favoriteValidators->getCookies();
        $client = new Client(['responseConfig' => [
            'format' => Client::FORMAT_JSON
        ]
        ]);
        $response = $client->createRequest()
            ->setUrl('https://testnet-rpc.kira.network/api/valopers?all=true')
            ->setMethod('GET')
            ->send();
        if ($response->isOk) {

            $kiraValidators = $response->getData();

            return [
                'status' => 'Ok',
                'validators' => $this->getValidators($kiraValidators, $cookieFavoriteArr),
                'waiting' => $this->getWaitingValidators($kiraValidators),
                'validatorStatus' => $this->getStatusValidatorsArray($kiraValidators),
                'favoritesValidators' => $this->getFavoriteValidators($kiraValidators, $cookieFavoriteArr)
            ];
        }

        return ['status' => 'error'];
    }

    private function getValidators(array $kiraValidators, array $cookieFavoriteArr)
    {
        $kiraValidatorsWithFavorite = [];

        foreach($kiraValidators['validators'] as $kiraValidator){
            $kiraValidator['favorite'] = false;
            foreach($cookieFavoriteArr as $cookieFavorite){
                if ($cookieFavorite == $kiraValidator['address']){
                    $kiraValidator['favorite'] = true;
                }
            }
            $kiraValidatorsWithFavorite[] = $kiraValidator;
        }
        return $kiraValidatorsWithFavorite;
    }

    private function getWaitingValidators(array $kiraValidators)
    {
        return $kiraValidators['waiting'];
    }
    private function getStatusValidatorsArray(array $kiraValidators)
    {
        return $kiraValidators['status'];
    }

    public function getValidatorsForAutocomplete($validators)
    {
        $validatorsForAutocomplete = [];
        foreach($validators as $validator){
            $validatorsForAutocomplete[] = [
                'label' => $validator['moniker'].' - '.$validator['address'],
                'value' => $validator['moniker'].' - '.$validator['address'],
                'address' => $validator['address']
            ];
        }
        return $validatorsForAutocomplete;
    }

    public function getValidatorByAddress($allValidators, $address)
    {
        $resultValidator = [];
        foreach($allValidators as $validator){
            if($validator['address'] == $address){
                $resultValidator[] = $validator;
            }
        }

        return $resultValidator;
    }

    public function getValidatorByStatus($validators, $status)
    {
        foreach($validators as $key => $value){
            if($value['status'] != strtoupper($status)){
                unset($validators[$key]);
            }
        }

        return $validators;
    }

    public function getFavoriteValidators(array $validators, array $cookieValidators)
    {
        $favoritesValidators = [];
        foreach($validators['validators'] as $validator){
            foreach($cookieValidators as $cookieValidator){
                if($cookieValidator == $validator['address']){
                    $validator['favorite'] = true;
                    $favoritesValidators[] = $validator;
                }
            }
        }

        return $favoritesValidators;
    }
}