<?php

namespace App\Presenters;

use ZBubliny\Model\Entity\Notification;

class NotificationPresenter extends BasePresenter
{

    public function actionDefault($key) {
        if($key === 'example') {
            $notification = new Notification();
            $notification->title = 'War in space';
            $notification->describe = 'Lorem ipsum';
            $notification->url = 'https://edition.cnn.com/2017/10/13/us/puerto-rico-superfund-water/index.html';
            $notification->key = '123';
        } else {
            $notification = $this->em->getRepository(Notification::class)->findOneBy(['key' => $key]);
        }

        if($notification) {
            $this->template->notification = $notification;
        } else {
            $this->flashMessage('Ups, something happend. No match with your id of notification.', 'danger');
            $this->redirect('Homepage:');
        }
    }

}
