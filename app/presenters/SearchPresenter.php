<?php

namespace App\Presenters;

use ZBubliny\Model\Entity\Notification;

class SearchPresenter extends BasePresenter
{

    public function actionDefault($input) {
        $input = str_replace(' ',',', $input);
        $keywords = explode(',',$input);

        $this->template->input = $input;
        $this->template->result = $this->askSearchApi($keywords);
    }

    private function askSearchApi(array $keywords) {
        $curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_URL, 'https://chart.googleapis.com/chart?cht=p3&chs=250x100&chd=t:60,40&chl=Hello|World&chof=json');
        curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

        $jsonData = json_decode(curl_exec($curlSession));
        curl_close($curlSession);
        return $jsonData;
    }

}
